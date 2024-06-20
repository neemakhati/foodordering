<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'username',
        'phone',
        'address',
        'status',
        'total_price',
        'food_details',
        'is_read'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_order_food', 'order_id', 'user_id')
            ->withPivot('food_id');
    }
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'order_food_user', 'order_id', 'food_id')->withPivot('user_id');
    }

}
