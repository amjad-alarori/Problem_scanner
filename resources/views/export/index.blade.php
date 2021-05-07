@extends('layouts.app')
@section('content')
    <nav id="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/scan">Scan</a></li>
            <li class="breadcrumb-item"><a href="/results">Resultaten</a></li>
            <li class="breadcrumb-item active">{{$result->name}}</li>
        </ol>
    </nav>
    <div class="container">
        <ul class="nav nav-tabs" id="QuestionCategoriesTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="questions-tab" data-toggle="tab" href="#questions" role="tab">Vragen</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab">Leefgebieden</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="export-tab" data-toggle="tab" href="#export" role="tab">Export</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active p-3" id="questions" role="tabpanel">
                <p class="mb-0">Client: {{$result->name}}</p>
                {{--                Wtf?--}}
                <p>Afgenomen door: {{auth()->user()->name}}</p>
                @foreach($questions->chunk(4) as $questionsChunked)
                    <div class="row">
                        @foreach($questionsChunked as $question)
                            <div class="col-3 border text-center">
                                <img style="height:200px; max-width:277px; margin:10px auto; display: block;"
                                     src="{{$question->image}}">
                                <p>
                                    <b>{{$question->__question}}</b><br>
                                </p>
                                <div class="d-flex justify-content-around">
                                    @for($counter = 1; $counter < 6; $counter++)
                                        <label>
                                            {{$counter}}
                                            <br/>
                                            @if($counter == $question['value']) <h2 style="line-height: 0.4;"><b
                                                    class="text-primary">•</b></h2> @endif
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="mt-5" id="charts">
                    <h3>Overzicht gemaakte scans</h3>
                    <canvas id="myChart" width="400" height="150"></canvas>
                </div>
            </div>
            <div class="tab-pane fade show" id="categories" role="tabpanel">

            </div>
            <div class="tab-pane fade show" id="export" role="tabpanel">
                <div class="p-5">
                    <p>Exporteer een individuele scan naar PDF</p>
                    <a class="btn btn-primary" href="{{route('downloadPDF', ['result' => $result])}}">Export to PDF</a>
                    <p>Exporteer het tijdsverloop per vraag naar PDF</p>
                    <a class="btn btn-primary" href="{{route('downloadPDFbyQuestion',['result' => $result])}}">Export to PDF</a>
                    <p>Exporteer het tijdsverloop per categorie naar PDF</p>
                    <a class="btn btn-primary" href="{{route('downloadPDFbyCategory',['result' => $result])}}">Export to PDF</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        // var ctx2 = document.getElementById("myChart2").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chart1Labels) !!},
                datasets: [1,1,1,1,1],
                // datasets: data.bardata,
            },
            options: {
                tooltips: {
                    displayColors: true,
                    callbacks: {
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                        },
                        type: 'linear',
                    }]
                },
                responsive: true,
                legend: {position: 'bottom'},
            }
        });
        // var myChart2 = new Chart(ctx2, {
        //     type: 'bar',
        //     data: {
        //         labels: data.dates,
        //         datasets: data.bardata,
        //     },
        //     options: {
        //         tooltips: {
        //             displayColors: true,
        //             callbacks: {
        //                 mode: 'x',
        //             },
        //         },
        //         scales: {
        //             xAxes: [{
        //                 stacked: true,
        //                 gridLines: {
        //                     display: false,
        //                 }
        //             }],
        //             yAxes: [{
        //                 stacked: true,
        //                 ticks: {
        //                     beginAtZero: true,
        //                 },
        //                 type: 'linear',
        //             }]
        //         },
        //         responsive: true,
        //         legend: {position: 'bottom'},
        //     }
        // });
    </script>
@stop
