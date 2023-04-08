<?php

namespace App\Services;

use App\Models\Counter;

class CounterService
{
    public static function create($new_counter_validated){

        $counter_id = random_int(10000000, 99999999);

        $counter = Counter::query()->create([
            'site_name' => $new_counter_validated['site_name'],
            'site_url' => $new_counter_validated['site_url'],
            'counter' => $counter_id,
        ]);
    }

    public static function getAllCounters(){
        return Counter::query()->get();
    }

    public static function delete($id) {
        Counter::destroy($id);
    }
}
