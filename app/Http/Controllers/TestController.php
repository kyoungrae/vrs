<?php

namespace App\Http\Controllers;

/**
 * Stub for /test route (routes/web.php). Replace with real tests if needed.
 */
class TestController extends Controller
{
    public function index()
    {
        return response('OK', 200, ['Content-Type' => 'text/plain']);
    }
}
