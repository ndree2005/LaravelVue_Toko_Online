<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Welcome', [
            'totalProduk'   => 0,
            'totalPenjual'  => 0,
        ]);
        //return redirect()->route('Welcome')->with('success', 'Flash message berfungsi!');
    }
}
