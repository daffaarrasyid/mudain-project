<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Pastikan response mendukung penambahan header (bukan tipe file mentah/download)
        if (method_exists($response, 'header')) {
            // 1. Mengatasi "Missing Anti-clickjacking Header" (Mencegah web dibingkai iframe oleh hacker)
            $response->header('X-Frame-Options', 'SAMEORIGIN');

            // 2. Mengatasi "X-Content-Type-Options Header Missing" (Mencegah MIME sniffing)
            $response->header('X-Content-Type-Options', 'nosniff');

            // 3. Tambahan XSS Protection standar
            $response->header('X-XSS-Protection', '1; mode=block');

            // 4. Mengatasi "Content Security Policy (CSP) Header Not Set"
            // Kita setting cukup longgar (unsafe-inline & allow https/data) supaya
            // CDN Tailwind, FontAwesome, Alpine.js, Chart.js, dan UI-Avatars lo tetap jalan normal!
            $response->header('Content-Security-Policy', "default-src 'self' 'unsafe-inline' 'unsafe-eval' https: http: data: blob:;");

            // 5. Mengatasi "Server Leaks Information via X-Powered-By"
            $response->headers->remove('X-Powered-By');
        }

        return $response;
    }
}