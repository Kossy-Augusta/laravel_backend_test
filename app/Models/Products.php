<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
 
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
    /**
     * Product can belong to different categories
     */

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product','prodcuts_id','category_id');
    }
}
