<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Mail\TicketPurchaseConfirmation;

try {
    echo "Fetching Order 10...\n";
    $order = Order::withoutGlobalScopes()
        ->with(['user', 'event.venue', 'tickets.ticketType'])
        ->find(10);

    if (!$order) {
        die("Order 10 not found. Please run a test purchase first.\n");
    }

    echo "Sending TicketPurchaseConfirmation Mailable for Order 10...\n";
    Mail::to('test@example.com')->send(new TicketPurchaseConfirmation($order, 'Magaly'));
    echo "Mailable successfully sent!\n";
} catch (\Exception $e) {
    echo "Error sending email:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
