<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetDefaultDataToSession
{
    public function __construct(private string $iso, private float $sale_rate) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!(session()->has('currency_iso'))) {
            session()->put('currency_iso', $this->iso);
            session()->put('sale_rate', $this->sale_rate);
        }
        return $next($request);
    }
}
