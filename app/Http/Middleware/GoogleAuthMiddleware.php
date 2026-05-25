<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GoogleAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Firebase UID header se lo
        $firebaseUid = $request->header('X-Firebase-UID')
                    ?? $request->bearerToken()
                    ?? $request->get('firebase_uid');

        // UID nahi mila → 401 return karo
        if (!$firebaseUid) {
            return response()->json([
                'success'  => false,
                'message'  => 'Unauthorized. Please login with Google.',
                'redirect' => '/signup',
            ], 401);
        }

        // DB mein user check karo
        $user = \App\Models\GoogleUser::where('firebase_uid', $firebaseUid)->first();

        if (!$user) {
            return response()->json([
                'success'  => false,
                'message'  => 'User not found. Please signup first.',
                'redirect' => '/signup',
            ], 401);
        }

        // User ko request mein attach karo
        $request->merge(['auth_user' => $user]);

        return $next($request);
    }
}