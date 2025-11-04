<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'image_url',
        'price',
        'is_active',
    ];

    public function owers()
    {
        return  $this->belongsToMany(User::class, 'user_inventory')
            ->withPivot(['quantity'])
            ->withTimestamps();
    }
}
