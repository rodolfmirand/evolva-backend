<?php

namespace App\Services;

use App\Models\User;
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

        $user->fill($updateData);
        $user->save();

        return $user;
    }

    public function getJourneysByUser($userId)
    {
        $user = User::with('journeys')->find($userId);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        return response()->json($user->journeys);
    }
}
