<?php

namespace App\Jobs;

use App\Mail\TicketPurchaseConfirmation;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTicketEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Het aantal keren dat de job mag worden geprobeerd.
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $orderId,
        public ?string $guestEmail = null,
        public ?string $guestName = null,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::withoutGlobalScopes()
            ->with(['user', 'event.venue', 'tickets.ticketType'])
            ->find($this->orderId);

        if (!$order) {
            Log::error("SendTicketEmailJob: Order {$this->orderId} niet gevonden.");
            return;
        }

        $email = $order->user?->email ?? $this->guestEmail;
        $name = $order->user?->name ?? $this->guestName ?? 'daar';

        if (!$email) {
            Log::warning("SendTicketEmailJob: Kon geen e-mail sturen voor order {$this->orderId} — e-mailadres ontbreekt.");
            return;
        }

        Mail::to($email)->send(new TicketPurchaseConfirmation($order, $name));

        Log::info("SendTicketEmailJob: Bevestigingsmail verstuurd naar {$email} voor order {$this->orderId}.");
    }
}
