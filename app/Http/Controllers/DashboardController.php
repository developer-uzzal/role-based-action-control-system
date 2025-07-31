<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    function index()
    {
        $userCount = User::count();
        return Inertia::render('Dashboard', ['userCount' => $userCount]);
    }
}
