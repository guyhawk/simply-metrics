<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Metric;
use Carbon\Carbon;

class MetricController extends Controller {
    public function store() {
        $request = request();
        $url = $request->headers->get('origin');
        $data = ['url' => $url];

        $metrics_validated = validator($request->all(), [
            'counter_id' => ['required', 'integer'],
            'left' => ['required', 'integer'],
            'top' => ['required', 'integer'],
            'height' => ['required', 'integer'],
            'width' => ['required', 'integer'],
            'date' => ['required'],
        ])->validate();

        $counter_id = $metrics_validated['counter_id'];

        $counter = Counter::query()->where('counter',$counter_id  )->firstOrFail();

        if ($counter['counter'] == $counter_id and $counter['site_url'] == $url) {

            $metrics = Metric::query()->create([
                'counter_id' => $counter['id'] ,
                'left' => $metrics_validated['left'],
                'top' => $metrics_validated['top'],
                'height' => $metrics_validated['height'],
                'width' => $metrics_validated['width'],
                'page' => '/',
                'date' => (new Carbon($metrics_validated['date']))->format('Y-m-d h:00:00'),
            ]);
            return response('',201);
        } else {
            return response('',404);
        }
    }
}
