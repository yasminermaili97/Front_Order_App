<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        $token = session('jwt_token');

        $userResponse = Http::withToken($token)->get(env('APP_URL_BACKEND') . '/user');
        $ordersResponse = Http::withToken($token)->get(env('APP_URL_BACKEND') . '/orders');

        if ($ordersResponse->successful() && $userResponse->successful()) {
            $orders = $ordersResponse->json()['data'];
            $user = $userResponse->json();
            return view('index', compact('orders', 'user'));
        }

        return redirect()->route('showLoginForm')->withErrors(['auth' => 'Token inválido o expirado.']);
    }

    public function create()
{
    $token = session('jwt_token');

    if (!$token) {
        return redirect()->route('showLoginForm')->withErrors(['auth' => 'Token no encontrado. Inicia sesión.']);
    }

    $response = Http::withToken($token)->get(env('APP_URL_BACKEND') . '/user');

    if ($response->successful()) {
        $user = $response->json();


        return view('create', compact('user'));
    }

    return redirect()->route('showLoginForm')->withErrors(['auth' => 'Token inválido o expirado.']);
}
public function store(Request $request)
{
    $token = session('jwt_token');

    if (!$token) {
        return redirect()->route('showLoginForm')->withErrors(['auth' => 'Token no encontrado.']);
    }

    $validated = $request->validate([
        'client_id' => 'required|integer',
        'sale_date' => 'required|date',
        'articles_id' => 'required|string',
        'amount' => 'required|integer'
    ]);

    $response = Http::withToken($token)->post(env('APP_URL_BACKEND') . '/order', $validated);

    if ($response->successful()) {
        return redirect()->route('orders')->with('success', 'Orden creada exitosamente.');
    }



    return back()->withErrors(['order' => 'No se pudo crear la orden.']);
}

public function cancel($id)
{
    $token = session('jwt_token');

    if (!$token) {
        return redirect()->route('showLoginForm')->withErrors(['auth' => 'Token no encontrado.']);
    }

    $url = env('APP_URL_BACKEND') . "/order/{$id}/cancelar";

    $response = Http::withToken($token)->post($url);

    if ($response->successful()) {
        return redirect()->route('orders')->with('success', 'Pedido cancelado correctamente.');
    }

    if ($response->status() == 412) {
        return back()->withErrors(['cancel' => 'El pedido no puede cancelarse porque ya fue procesado.']);
    }

    if ($response->status() == 404) {
        return back()->withErrors(['cancel' => 'Pedido no encontrado.']);
    }

    return back()->withErrors(['cancel' => 'Error al cancelar el pedido.']);
}

    
}
