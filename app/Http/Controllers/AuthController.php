<?php

namespace App\Http\Controllers;

use App\Exceptions\WrongCredentialsException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function __construct(private readonly AuthService $authService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register(
            email: $request->email,
            password: $request->password,
            name: $request->name
        );

        Auth::login($user);

        return to_route('tasks.index');
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->login(
                email: $request->email,
                password: $request->password
            );

            Auth::login($user);

            return to_route('tasks.index');
        } catch (WrongCredentialsException) {
            return redirect()->back()->withErrors([
                'message' => __('messages.wrong credentials')
            ]);
        }
    }

    public function logout()
    {
        $this->authService->logout();
        Auth::logout();
        Session::flush();
        return to_route('login');
    }

    public function loginView()
    {
        return view('login');
    }

    public function registerView()
    {
        return view('register');
    }
}
