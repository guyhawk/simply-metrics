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
        $request = request();

        $input_date = validator($request->all(), [
            'date' => ['nullable', 'string', 'date'],
        ])->validate();

        $input_date = (new Carbon($input_date['date'] ?? null))->format('Y-m-d');

        $date = [
            'current_date' => $input_date,
            'prev_date' => (new Carbon($input_date))->subDay()->format('Y-m-d'),
            'next_date' => (new Carbon($input_date))->addDay()->format('Y-m-d'),
        ];

        $metrics_today = MetricService::getMetricsByDateToChart($counter->id, $date);

        $labels = $metrics_today['labels'];
        $data = $metrics_today['data'];
        $counter_id = $counter->counter;
        $counter_code = MetricService::createCounterCode($counter_id);

        return view('dashboard.show', compact('counter', 'labels', 'data', 'counter_code', 'metrics', 'date'));

    }

    public function create() {
        return view('dashboard.create');
    }

    public function destroy($counter_id) {
        CounterService::delete($counter_id);
        return redirect()->route('dashboard');
    }

}
