<?php

namespace App\Services;

use App\Exceptions\WrongCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class AuthService
{

    public function register(string $email, string $password, string $name): User
    {
        /** @var User */
        return User::query()->create([
            'email' => $email,
            'password' => $password,
            'name' => $name
        ]);
    }

    /**
     * @throws WrongCredentialsException
     */
    public function login(string $email, string $password): User
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            /** @var User */
            return User::query()
                ->where('email', $email)
                ->first();
        }

        throw new WrongCredentialsException();
    }

    public function logout(): bool
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return true;
    }

    public function getTokenForUser(User $user): string
    {
        return $user->createToken(str()->random(20))->plainTextToken;
    }

}
