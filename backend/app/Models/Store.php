<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreItems;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
    ];

    public function items()
    {
        return $this->hasMany(StoreItems::class);
    }
}
