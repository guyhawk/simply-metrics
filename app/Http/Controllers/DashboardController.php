<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;
use App\Models\Metric;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index() {
        $counters = Counter::query()->get();
        return view('dashboard.index', compact('counters'));
    }

    public function store(Request $request) {
        $validated = validator($request->all(), [
            'site_name' => ['required', 'string', 'max:100'],
            'site_url' => ['required', 'string', 'max:100'],
        ])->validate();

        $counter_id = random_int(10000000, 99999999);

        $counter = Counter::query()->create([
            'site_name' => $validated['site_name'],
            'site_url' => $validated['site_url'],
            'counter' => $counter_id,
        ]);

        // return 'create';
        return redirect()->route('dashboard');
    }

    public function show(Counter $counter) {
        $metrics = Metric::query()->select(['left', 'top', 'height', 'width'])->where('counter_id', $counter->id)->get()->toArray();
        $metrics_today = Metric::query()
            ->selectRaw('count(id) as click')
            ->selectRaw('date as d')
            ->where('counter_id', $counter->id)
            ->whereDate('date', new Carbon(now()))
            ->groupBy('date')
            ->pluck('click', 'd');
        $labels = $metrics_today->keys();
        $data = $metrics_today->values();
        $counter_id = $counter->counter;
        $app_url = config('app.url');
        $counter_code = "
        <!-- Simply Analitic -->
        <script>
            let clickData;
            const id = {$counter_id};
            const body = document.querySelector('body');
            body.addEventListener('mouseup',  async (e) => {
                const date = new Date();
                clickData = {counter_id: id, date, left: e.x, top: e.y, height: body.offsetHeight, width: body.offsetWidth};
                try {
                    await postData('{$app_url}/api/metrics', clickData)
                }catch {};
            });

            async function postData(url = '', data = {}) {
                const response = await fetch(url, {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer',
                    body: JSON.stringify(data),
                });
                return response.json();
            };
        </script>";

        return view('dashboard.show', compact('counter', 'labels', 'data', 'counter_code', 'metrics'));

    }

    public function create() {
        return view('dashboard.create');
    }

    public function destroy() {
        return 'dashboard.destroy';
    }

}
