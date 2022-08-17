<?php

namespace App\Http\Controllers\Organization\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('organization.dashboard.index');
    }
}
