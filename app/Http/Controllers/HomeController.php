<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index');
    }
}
