<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MetricService;



class MetricController extends Controller {
    public function store() {
        $request = request();
        $url = $request->headers->get('origin');

        $metrics_validated = validator($request->all(), [
            'counter_id' => ['required', 'integer'],
            'left' => ['required', 'integer'],
            'top' => ['required', 'integer'],
            'height' => ['required', 'integer'],
            'width' => ['required', 'integer'],
            'date' => ['required'],
        ])->validate();

        $result = MetricService::create($metrics_validated, $url);


        if ($result) {
            // return response('',201);

            return response()->json(['res'=> $result]);
        } else {
            return response()->json(['res'=> $result]);
            // return response('',404);
        }
    }
}
