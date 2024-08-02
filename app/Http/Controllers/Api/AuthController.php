<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register(
            email: $request->email,
            password: $request->password,
            name: $request->name
        );

        $token = $this->authService->getTokenForUser($user);

        return response()
            ->json(
                UserResource::make($user)->setToken($token),
                Response::HTTP_CREATED
            );
    }

    public function login(LoginRequest $request): JsonResource|JsonResponse
    {
        try {
            $user = $this->authService->login(
                email: $request->email,
                password: $request->password
            );

            $token = $this->authService->getTokenForUser($user);

            return response()
                ->json(
                    UserResource::make($user)->setToken($token),
                );
        } catch (WrongCredentialsException) {
            return response()->json([
                'message' => __('messages.wrong credentials')
            ]);
        }
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return response()->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
