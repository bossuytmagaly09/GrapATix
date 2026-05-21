<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Jobs\ProcessStripePaymentJob;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret'); // Make sure this is in config/services.php

        if (!$endpointSecret) {
            Log::warning('Stripe webhook secret niet ingesteld.');
            return response('Webhook secret missing', 400);
        }

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe webhook fout: invalid payload');
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe webhook fout: invalid signature');
            return response('Invalid signature', 400);
        }

        // Handle the checkout.session.completed event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            // Dispatch the job to process the payment asynchronously
            ProcessStripePaymentJob::dispatch($session->id);
        }

        return response('Webhook handled', 200);
    }
}
