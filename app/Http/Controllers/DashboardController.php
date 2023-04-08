<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;
use Carbon\Carbon;

use App\Services\CounterService;
use App\Services\MetricService;

class DashboardController extends Controller
{
    public function index() {
        $counters = CounterService::getAllCounters();
        return view('dashboard.index', compact('counters'));
    }

    public function store(Request $request) {
        $validated = validator($request->all(), [
            'site_name' => ['required', 'string', 'max:100'],
            'site_url' => ['required', 'string', 'max:100'],
        ])->validate();

        CounterService::create($validated);

        return redirect()->route('dashboard');
    }

    public function show(Counter $counter) {
        $metrics = MetricService::getMetricsById($counter->id);

        $metrics_today = MetricService::getMetricsByDateToChart($counter->id, new Carbon(now()));

        $labels = $metrics_today['labels'];
        $data = $metrics_today['data'];
        $counter_id = $counter->counter;
        $counter_code = MetricService::createCounterCode($counter_id);

        return view('dashboard.show', compact('counter', 'labels', 'data', 'counter_code', 'metrics'));

    }

    public function create() {
        return view('dashboard.create');
    }

    public function destroy($counter_id) {
        CounterService::delete($counter_id);
        return redirect()->route('dashboard');
    }

}
