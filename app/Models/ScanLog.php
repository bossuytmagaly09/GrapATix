<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'scanned_by',
        'scanned_at',
        'status', // success, duplicate, invalid
        'device_info',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    /**
     * Get the ticket associated with the scan log.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user/admin who performed the scan.
     */
    public function scannedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
