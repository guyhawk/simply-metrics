@extends('layouts.base')

@section('content')

    <div class="page-header">
        <h2 class="page-title">
            {{ $counter->site_name }}
        </h2 >
        <div class="page-header-right">
            <a href="#" class="btn btn-detele-button">{{__('Delete')}}</a>
            <div class="confirmation-delete">
                <div class="mb-1">{{__('Delete counter?')}}</div>
                <form action="{{ route('dashboard.destroy',  $counter->id) }}" method="POST">
                     @csrf
                    @method('DELETE')
                    <button class="btn mb-1">{{__('Yes')}}</button>
                </form>
                <a href="#" class="btn btn-secondary btn-confirmation-cancel">{{__('No')}}</a>
            </div>
        </div>
    </div>

    <div>
        <div class="counter-information">
            <div class="counter-information__label">
                {{ __('ID') }}:
            </div>
            <div class="counter-information__content">
                {{ $counter->counter }}
            </div>
        </div>
        <div class="counter-information">
            <div class="counter-information__label">
                {{ __('Url') }}:
            </div>
            <div class="counter-information__content">
                {{ $counter->site_url }}
            </div>
        </div>

    </div>
    <div class="counter-code">
        <div class="counter-code__title">{{__('Counter code') }}:</div>
        <div class="counter-code__text">   {{ $counter_code }}</div>
    </div>


    @if (empty($metrics))
        <div class="empty-metrics">{{__('No statistics for this counter.')}}</div>
    @else
        <div class="title-2">{{ __('Clicks map') }}</div>
        <canvas id="clickmap" width="960px" height="540px" style="border: 1px solid #eee"></canvas>

        <div class="title-2">{{ __('Clicks') }}</div>
        <div class="data-widget">
            <a href="{{route('dashboard.show', $counter->id)}}?date={{$date['prev_date']}}" class="data-widget__control data-widget__control_prev"><</a>
            <div class="data-widget__today">{{$date['current_date']}}</div>
            <a href="{{route('dashboard.show', $counter->id)}}?date={{$date['next_date']}}"class="data-widget__control data-widget__control_next">></a>
        </div>
        <canvas id="myChart" height="100px"></canvas>
    @endif

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">

    const labels =  {{ Js::from($labels) }};
    const users =  {{ Js::from($data) }};

    const data = {
        labels: labels,
        datasets: [{
            label: 'Activity',
            backgroundColor: 'rgb(4, 32, 28)',
            borderColor: 'rgb(4, 32, 28)',
            data: users,
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                    },
                },
            },
        }
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

</script>

<script type="text/javascript">
    function draw(){
     const metrics =  {{ Js::from($metrics) }};
      let canvas = document.getElementById('clickmap');

      if (canvas.getContext){
        var ctx = canvas.getContext('2d');

        if (metrics.length > 0) {
            metrics.forEach((element,index) => {
                console.log(index)
                const left = (element.left / element.width) * 960;
                const top = (element.top / element.height) * 540;

                ctx.beginPath();
                ctx.arc(left, top, 3, 0, 2*Math.PI, false);
                ctx.fillStyle = '#AF5200';
                ctx.fill();
                ctx.lineWidth = 1;
                ctx.strokeStyle = '#AF5200';
                ctx.stroke();

            });
        }
      }
    }
    draw()
    </script>
    <script>
        const confirmation_delete_container = document.querySelector('.confirmation-delete');
        const btn_delete = document.querySelector('.btn-detele-button');
        const btn_delete_cancel = document.querySelector('.btn-confirmation-cancel');

        btn_delete.addEventListener('click', (e)=>{
            e.preventDefault();
            confirmation_delete_container.classList.add('open');
        });

        btn_delete_cancel.addEventListener('click', (e)=>{
            e.preventDefault();
            confirmation_delete_container.classList.remove('open');
        })


    </script>
@endpush
