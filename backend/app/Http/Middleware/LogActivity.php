<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->user()) {
            AuditLog::create([
                'user_id' => $request->user()->id,
                'action' => $request->method() . ' ' . $request->path(),
                'description' => 'API request',
                'metadata' => [
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'status_code' => $response->status(),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $response;
    }
}