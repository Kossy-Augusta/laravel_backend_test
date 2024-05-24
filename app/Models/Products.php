<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'unit_price',
        'amount_sold',
        'user_id'
    ];

    /**
     * Get the user that own a particular product
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
