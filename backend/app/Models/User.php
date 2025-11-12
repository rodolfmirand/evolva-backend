<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Task;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'xp',
        'level',
        'avatar_url',
        'coins'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'xp' => 'integer',
        'level' => 'integer',
        'coins' => 'integer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user')
            ->withPivot(['status', 'completed_at', 'xp_earned', 'coins_earned', 'assigned_at', 'proof_url'])
            ->withTimestamps();
    }

    public function inventory()
    {
        return $this->belongsToMany(StoreItem::class, 'user_inventory', 'user_id', 'item_id')
            ->withPivot(['quantity', 'acquired_at'])
            ->withTimestamps();
    }

    public function journeys()
    {
        return $this->belongsToMany(Journey::class, 'journey_user')
            ->withPivot('is_master')
            ->withTimestamps();
    }
}
