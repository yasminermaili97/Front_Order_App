<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $response = Http::post(env('APP_URL_BACKEND') . '/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $token = $response->json()['token'];
            session(['jwt_token' => $token]);
            return redirect()->route('orders');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas.']);
    }

    public function register(Request $request)
    {
        $response = Http::post(env('APP_URL_BACKEND') . '/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->successful()) {
            return redirect()->route('showLoginForm')->with('success', 'Registro exitoso. Por favor, inicia sesión.');
        }

        return back()->withErrors(['email' => 'No se pudo registrar.']);
    }

    public function logout()
    {
        $token = session('jwt_token');
        Http::withToken($token)->post(env('APP_URL_BACKEND') . '/logout');
        session()->flush();
        return redirect()->route('showLoginForm')->with('success', 'Sesión cerrada exitosamente.');
    }

    public function getUser()
    {
        $token = session('jwt_token');

        if ($token) {
            $response = Http::withToken($token)->get(env('APP_URL_BACKEND') . '/user');
            if ($response->successful()) {
                return $response->json();
            }
        }

        return null;
    }

}
