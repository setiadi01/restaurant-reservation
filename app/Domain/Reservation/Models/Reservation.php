<?php

namespace App\Domain\Reservation\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'table_id',
        'customer_id',
        'date',
        'time',
        'name',
        'email',
        'phone',
        'special_request',
    ];

    /**
     * Get the table that owns the reservation.
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}
