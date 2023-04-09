<?php

namespace App\Services;

use App\Models\Metric;
use App\Models\Counter;

use Carbon\Carbon;

class MetricService
{
    public static function getMetricsById($counter_id) {
        return  Metric::query()->select(['left', 'top', 'height', 'width'])->where('counter_id', $counter_id)->get()->toArray();
    }

    public static function getMetricsByDateToChart($counter_id, $date){

        $metrics = Metric::query()
            ->selectRaw('count(id) as clicks')
            ->selectRaw('date as d')
            ->where('counter_id', $counter_id)
            ->whereDate('date', $date)
            ->groupBy('date')
            ->pluck('clicks', 'd');

        //generation of statistics data on activity per day
        //TODO не самый оптимальный способ подготовки данных
        $dateFormated = (new Carbon($date))->format('Y-m-d');
        for($i=0; $i<24; $i++) {
            $str = (string) $i;
            if ($i<10) {
                $str = '0'.$i;
            }
            $day["{$dateFormated} {$str}:00:00"] = 0;
        }
        $result= array_merge($day, $metrics->toArray());
        $labels = $metrics->keys();
        $labels_modify = [];

        foreach($labels as $l) {
            $new = (new Carbon($l))->format('H');
            $labels_modify[] = $new;
        }

        return ['labels' => $labels_modify, 'data'=>$metrics->values() ];
    }

    public static function create($metrics_validated, $url){

        $counter_id = $metrics_validated['counter_id'];

        $counter = Counter::query()->where('counter', $counter_id )->firstOrFail();

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

            return true;
        }

        return $url ;
    }

    public static function createCounterCode($counter_id) {

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

        return $counter_code;
    }
}
