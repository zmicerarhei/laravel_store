<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Contracts\RegisterServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function __construct(private RegisterServiceInterface $registerService)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->registerService->checkAdminRole()) {
            return $next($request);
        }

        abort(403, 'Access denied. Only admins can access this route.');
    }
}
