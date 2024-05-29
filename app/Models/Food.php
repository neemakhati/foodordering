<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'price',
        'image',
        'description',
        'categories_id',
        'isTrending'
    ];
    public function food() {
        return $this->belongsTo(Food::class);
    }
    public function cat()
    {
        return $this->belongsTo(Category::class,'categories_id');
    }
}
