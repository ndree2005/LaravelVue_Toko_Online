<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Orders/Index', [
            'user' => $request->user(),
            'orders' => [],
        ]);
    }

    public function dashboard(Request $request): Response
    {
        return Inertia::render('Buyer/Dashboard', [
            'user' => $request->user(),
        ]);
    }

    public function show(string $order)
    {
        abort(404, 'Pesanan tidak ditemukan.');
    }

    public function payment(string $order)
    {
        abort(404, 'Pesanan tidak ditemukan.');
    }

    public function uploadPayment(Request $request, string $order)
    {
        abort(404, 'Pesanan tidak ditemukan.');
    }
}
