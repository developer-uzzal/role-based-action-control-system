<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    function index()
    {
        $userCount = User::count();
        return response()->json([
            'status' => 'success',
            'userCount' => $userCount
        ]);
    }

}
