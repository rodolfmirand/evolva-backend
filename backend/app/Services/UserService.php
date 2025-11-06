<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data): User
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function updateUser(User $user, array $data): User
    {
        $updateData = Arr::only($data, ['name', 'email', 'password']);

        // Hasher a senha somente se ela foi enviada na requisição
        if (isset($updateData['password'])) {
            $updateData['password'] = Hash::make($updateData['password']);
        }

        $user->update($updateData);

        return $user;
    }

    public function getJourneysByUser($userId): Collection
    {
        $user = User::with('journeys')->find($userId);

        return $user ? $user->journeys : null;
    }
}
