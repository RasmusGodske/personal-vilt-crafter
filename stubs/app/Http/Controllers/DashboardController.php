<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return inertia('Dashboard', [
            'message' => 'Hello, World!' // This will be passed to the defined props in the Vue component
        ]);
    }
}