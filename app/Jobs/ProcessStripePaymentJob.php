<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class ProcessStripePaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sessionId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = StripeSession::retrieve($this->sessionId);
            $orderId = $session->metadata->order_id ?? null;
            $ticketQuantitiesJson = $session->metadata->ticket_quantities ?? '{}';
            $quantities = json_decode($ticketQuantitiesJson, true) ?? [];

            if (!$orderId) {
                Log::error("Stripe Webhook Job gefaald: geen order_id in metadata voor sessie {$this->sessionId}");
                return;
            }

            // Gebruik database transactie met een lock (lockForUpdate)
            // Dit voorkomt dat twee workers tegelijkertijd dezelfde order proberen te verwerken
            DB::transaction(function () use ($orderId, $session, $quantities) {
                // Bypass global scopes omdat de webhook op de achtergrond draait zonder auth
                $order = Order::withoutGlobalScopes()->where('id', $orderId)->lockForUpdate()->first();

                if (!$order) {
                    Log::error("Stripe Webhook Job gefaald: Order {$orderId} niet gevonden.");
                    return;
                }

                // Check of de order al is verwerkt om dubbele tickets te vermijden
                if ($order->status === 'paid') {
                    Log::info("Order {$orderId} is al gemarkeerd als paid. Job wordt overgeslagen.");
                    return;
                }

                // Markeer order als betaald
                $order->update([
                    'status' => 'paid',
                    'payment_id' => $session->payment_intent ?? $session->id,
                ]);

                // Installeer de QrCodeService
                $qrCodeService = app(\App\Services\QrCodeService::class);

                // Creëer de tickets
                foreach ($quantities as $ticketTypeId => $qty) {
                    for ($i = 0; $i < $qty; $i++) {
                        $qrData = $qrCodeService->generateForTicket();

                        Ticket::create([
                            'organization_id' => $order->organization_id,
                            'event_id' => $order->event_id,
                            'user_id' => $order->user_id,
                            'ticket_type_id' => $ticketTypeId,
                            'order_id' => $order->id,
                            'qr_code' => $qrData['url'],
                            'qr_image_path' => $qrData['path'],
                            'status' => 'paid',
                        ]);
                    }
                }

                Log::info("Stripe Webhook Job succes: Tickets aangemaakt voor Order {$orderId}.");
            });

        } catch (\Exception $e) {
            Log::error("Fout in ProcessStripePaymentJob: " . $e->getMessage());
            // Je kunt hier beslissen of je de job laat falen/retries toestaat
            throw $e;
        }
    }
}
