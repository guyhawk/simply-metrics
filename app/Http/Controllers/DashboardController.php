<?php

namespace App\Http\Controllers;

use App\Services\CounterService;

class DashboardController extends Controller
{
    public function index() {
        $counters = CounterService::getAllCounters();
        return view('dashboard.index', compact('counters'));
    }

}
