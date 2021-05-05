@extends('layouts.app')
@section('content')
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        img {
            height: 60px;
            width: auto;
        }

        .row-color {
            width: 50%;
            margin: 0 auto;
            height: 30px;
        }

        .orange {
            background-color: #FF8E2A;
            width: 50%;
        }

        .red {
            background-color: #FF2F1B;
        }

        .yellow {
            background-color: #FEC842;
        }

        .lightgreen {
            background-color: #91CB47;
            width: 50%;
        }

        .green {
            background-color: #33B34B;
            width: 50%;
        }

        .selectionbox {
            display: block;
            margin-left: 30px;
        }

        @media print {

            .questionimage {
                max-width: 277px;
            }

            .row-color {
                width: 50%;
                margin: 0 auto;
                height: 30px;
            }

            .orange {
                background-color: #FF8E2A;
                width: 50%;
            }

            .red {
                background-color: #FF2F1B;
            }

            .yellow {
                background-color: #FEC842;
            }

            .lightgreen {
                background-color: #91CB47;
                width: 50%;
            }

            .green {
                background-color: #33B34B;
                width: 50%;
            }

            #breadcrumb {
                display: none;
            }

            #exportButton, #exportButton2 {
                display: none;
            }

            #pdfLogo {
                display: block !important;
            }

            * {
                -webkit-print-color-adjust: exact;
            }

            @page {
                size: auto;
                margin: 0mm;

            }

            #charts {
                position: absolute;
                left: 3%;
            }

            body {
                page-break-after: avoid;
                page-break-before: avoid;
                padding: 20px;
                margin: 25mm 0;
                overflow: visible !important;
            }

            .selectionbox {
                margin-left: 5px;
            }

            #QuestionCategoriesTab {
                display: none;
            }

            .pagebreak {
                page-break-before: always;
                padding-top: 50px;
            }
        }

        #pdfLogo {
            display: none;
        }

    </style>

    <nav id="breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/scan">Scan</a></li>
            <li class="breadcrumb-item"><a href="/results">Resultaten</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$firstResult->name}}</li>
        </ol>
    </nav>
    <div class="container">
        <ul class="nav nav-tabs" id="QuestionCategoriesTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="questions-tab" data-toggle="tab" href="#questions" role="tab"
                   aria-controls="questions" aria-selected="true">Vragen</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab"
                   aria-controls="categories" aria-selected="false">Leefgebieden</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="export-tab" data-toggle="tab" href="#export" role="tab">Export</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="questions" role="tabpanel" aria-labelledby="questions-tab">
                <img id="pdfLogo" src='/img/logos/orange_eyes.jpg'>
                <div class="row">
                    <div class="col-6"><p style="padding-top:30px;">
                            Client: {{$firstResult->name}} <br>
                            Afgenomen door: {{$AuthUser->name}}
                        </p>
                    </div>

                    <div class="col-6" style="padding-top:30px;">

                        {{--                        <button onclick="exportToPdf()" id="exportButton" class="btn btn-primary float-right">exporteer--}}
                        {{--                            naar--}}
                        {{--                            pdf--}}
                        {{--                        </button>--}}


                    </div>
                </div>
                <h3>0 meting</h3>
                <div class="row pl-3 pr-3">
                    @php $counter2=0;$counter3=0;@endphp


                    @foreach($firstquestions as $question)
                        @if($question['value'] != 0)
                            @if($counter3 ==0)
                                @if($counter2 == 12)

                                    @php $counter2=1;$counter3=1;@endphp
                </div>
                <div class="pagebreak"></div>
                <div class="row pl-3 pr-3">
                    <div class="col-3 border p-0" scope="col" style="width:5%;"><img
                            src="{{$question['image']}}"
                            style="height:200px; max-width:277px; margin:10px auto; display: block;">
                        <p style="text-align:center;">
                            <b>{{$question['question']}}</b><br>
                        </p>
                        <div class="selectionbox">
                            @for($counter=1;$counter < 6; $counter++)
                                <label class="scan-ratio-label">{{$counter}}<br/>
                                    <input type="radio" name="questioninput{{$question['id']}}"
                                           value="{{$question['value']}}" disabled
                                           @if($counter == $question['value']) checked="checked" @endif>
                                </label>
                            @endfor
                        </div>
                    </div>
                    @else
                        @php $counter2++;@endphp
                        <div class="col-3 border p-0" scope="col" style="width:5%;"><img
                                src="{{$question['image']}}"
                                style="height:200px; max-width:277px; margin:10px auto; display: block;">
                            <p style="text-align:center;">
                                <b>{{$question['question']}}</b><br>
                            </p>
                            <div class="selectionbox">
                                @for($counter=1;$counter < 6; $counter++)
                                    @if($counter == $question['value'])
                                        <label class="scan-ratio-label">{{$counter}}<br/>
                                            <input type="radio" name="questioninput{{$question['id']}}"
                                                   value="{{$question['value']}}" checked="checked">
                                        </label>
                                    @else
                                        <label class="scan-ratio-label">{{$counter}}<br/>
                                            <input type="radio" name="questioninput{{$question['id']}}"
                                                   value="{{$question['value']}}" disabled>
                                        </label>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @endif
                    @else
                        @if($counter2 == 16)
                            @php $counter2=1;@endphp
                </div>
                <div class="pagebreak"></div>
                <div class="row pl-3 pr-3">
                    <div class="col-3 border p-0" scope="col" style="width:5%;"><img
                            src="{{$question['image']}}"
                            style="height:200px; max-width:277px; margin:10px auto; display: block;">
                        <p style="text-align:center;">
                            <b>{{$question['question']}}</b><br>
                        </p>
                        <div class="selectionbox">
                            @for($counter=1;$counter < 6; $counter++)
                                @if($counter == $question['value'])
                                    <label class="scan-ratio-label">{{$counter}}<br/>
                                        <input type="radio" name="questioninput{{$question['id']}}"
                                               value="{{$question['value']}}" checked="checked">
                                    </label>
                                @else
                                    <label class="scan-ratio-label">{{$counter}}<br/>
                                        <input type="radio" name="questioninput{{$question['id']}}"
                                               value="{{$question['value']}}" disabled>
                                    </label>
                                @endif
                            @endfor
                        </div>
                    </div>
                    @else
                        @php $counter2++;@endphp
                        <div class="col-3 border p-0" scope="col" style="width:5%;"><img
                                src="{{$question['image']}}"
                                style="height:200px; max-width:277px; margin:10px auto; display: block;"
                                class="questionimage">
                            <p style="text-align:center;">
                                <b>{{$question['question']}}</b><br>
                            </p>
                            <div class="selectionbox">
                                @for($counter=1;$counter < 6; $counter++)
                                    @if($counter == $question['value'])
                                        <label class="scan-ratio-label">{{$counter}}<br/>
                                            <input type="radio" name="questioninput{{$question['id']}}"
                                                   value="{{$question['value']}}" checked="checked">
                                        </label>
                                    @else
                                        <label class="scan-ratio-label">{{$counter}}<br/>
                                            <input type="radio" name="questioninput{{$question['id']}}"
                                                   value="{{$question['value']}}" disabled>
                                        </label>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @endif
                    @endif

                    @endif
                    @endforeach
                </div>

                <div class="pagebreak"></div>
                <div class="mt-5" id="charts">
                    <img id="pdfLogo" class="mb-3" src='/img/logos/orange_eyes.jpg'>
                    <h3>Overzicht gemaakte scans</h3>
                    <canvas id="myChart" width="400" height="150"></canvas>
                </div>
                <div class="pagebreak">
                </div>
                <div id="chart2" class="pl-3 pr-3 mt-5">
                    <img id="pdfLogo" class="mb-3" src='/img/logos/orange_eyes.jpg'>

                    <h3>Tijdsverloop per leefgebied</h3>
                    <div class="row">
                        <div class="col">
                        </div>
                        @foreach($categoryLabels as $label)
                            <div class="col" style="text-align: center;">{{$label}}</div>
                        @endforeach
                    </div>
                    @php $counter= 0; @endphp
                    @foreach($questions as $question)
                        @if($counter == 5)
                            @php $counter =0; @endphp
                            <div class="pagebreak"></div>
                        @else    @php $counter++; @endphp @endif
                        <div class="row p-0 chart2-row">
                            <div class="col">
                                <div style="text-align: center; padding-top:10px;">
                                    <img style="height:150px; margin:0 auto;display: block;"
                                         src="{{$question['image']}}">
                                    {{$question['question']}}
                                </div>
                            </div>
                            @foreach($question['answers'] as $item)
                                <div class="col">@for($x=0+$item;$x<5;$x++)
                                        <div class="row">
                                            <div style="height:30px;"></div>
                                        </div>
                                    @endfor
                                    <div class="row row-color   @switch($item)
                                    @case(5)
                                        red
@break
                                    @case(4)
                                        orange
@break
                                    @case(3)
                                        yellow
@break
                                    @case(2)
                                        lightgreen                                 @break
                                    @case(1)
                                        green                                @break
                                    @endswitch
                                        ">

                                    </div>
                                    @for($item; $item>1; $item--)
                                        <div class="row">
                                            <div style="height:30px;"></div>
                                        </div>
                                    @endfor
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="row" style="border-top:1px solid;">
                        <div class="col">

                        </div>
                        @foreach($categoryLabels as $label)
                            <div class="col" style="text-align: center;">{{$label}}</div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">
                <img id="pdfLogo" class="mt-5" src='/img/logos/orange_eyes.jpg'>
                <div class="row">
                    <div class="col-6"><p style="padding-top:30px;">
                            Client: {{$firstResult->name}} <br>
                            Afgenomen door: {{$AuthUser->name}}
                        </p>
                    </div>

                    <div class="col-6" style="padding-top:30px;">

                        {{--                        <button onclick="exportToPdf()" id="exportButton" class="btn btn-primary float-right">exporteer--}}
                        {{--                            naar--}}
                        {{--                            pdf--}}
                        {{--                        </button>--}}


                    </div>
                </div>
                <h3>0 meting</h3>
                <div class="row pl-3 pr-3">
                    @foreach($categories as $category)
                        <div class="col-3 border p-0" scope="col" style="width:5%;"><img
                                src="{{$category['category']['image']}}"
                                style="height:200px; max-width:277px; margin:10px auto; display: block;">
                            <p style="text-align:center;">
                                <b>{{$category['category']['name']}}</b><br>
                            </p>
                            <div class="selectionbox">
                                @for($counter=1;$counter < 6; $counter++)
                                    @if($counter == round(($category['value']/$category['questionCount'])))
                                        <label class="scan-ratio-label">{{$counter}}<br/>
                                            <input type="radio" name="input{{$category['category']['name']}}"
                                                   value="{{round(($category['value']/$category['questionCount']))}}"
                                                   checked="checked">
                                        </label>
                                    @else
                                        <label class="scan-ratio-label">{{$counter}}<br/>
                                            <input type="radio" name="input{{$category['category']['name']}}"
                                                   value="{{round(($category['value']/$category['questionCount']))}}"
                                                   disabled>
                                        </label>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagebreak"></div>
                <div class="mt-5" id="charts">
                    <img id="pdfLogo" class="mb-3" src='/img/logos/orange_eyes.jpg'>
                    <h3>Overzicht gemaakte scans</h3>
                    <canvas id="myChart2" width="400" height="150"></canvas>
                </div>
                <div class="pagebreak">
                </div>
                <div id="chart2" class="pl-3 pr-3 mt-5">
                    <img id="pdfLogo" class="mb-3" src='/img/logos/orange_eyes.jpg'>

                    <h3>Tijdsverloop per leefgebied</h3>
                    <div class="row">
                        <div class="col">
                        </div>
                        @foreach($categoryLabels as $label)
                            <div class="col" style="text-align: center;">{{$label}}</div>
                        @endforeach
                    </div>
                    @php $counter= 0; @endphp
                    @foreach($categoryResults as $category)
                        @if($counter == 6)
                            @php $counter =0; @endphp
                            <div class="pagebreak"></div>
                        @else    @php $counter++; @endphp @endif
                        <div class="row p-0 chart2-row">
                            <div class="col">
                                <div style="text-align: center; padding-top:10px;">
                                    <img style="height:150px; margin:0 auto;display: block;"
                                         src="{{$category['image']}}">
                                    {{$category['label']}}
                                </div>
                            </div>
                            @foreach($category['data'] as $item)
                                <div class="col">@for($x=0+$item;$x<5;$x++)
                                        <div class="row">
                                            <div style="height:30px;"></div>
                                        </div>
                                    @endfor
                                    <div class="row row-color   @switch($item)
                                    @case(5)
                                        red
@break
                                    @case(4)
                                        orange
@break
                                    @case(3)
                                        yellow
@break
                                    @case(2)
                                        lightgreen                                 @break
                                    @case(1)
                                        green                                @break
                                    @endswitch
                                        ">

                                    </div>
                                    @for($item; $item>1; $item--)
                                        <div class="row">
                                            <div style="height:30px;"></div>
                                        </div>
                                    @endfor
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="row" style="border-top:1px solid;">
                        <div class="col">

                        </div>
                        @foreach($categoryLabels as $label)
                            <div class="col" style="text-align: center;">{{$label}}</div>
                        @endforeach
                    </div>


                </div>

            </div>
            <div class="tab-pane fade" id="export" role="tabpanel">
                <a class="btn btn-primary" href="{{ route('downloadPDF', ['result'=>$result_id]) }}">Export to
                    PDF</a>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        function exportToPdf() {
            window.print();
        }

        $.ajax({
            type: 'POST',
            url: '/results/json/',
            data: {
                _token: '{{csrf_token()}}',
                user_id:{{$firstResult->user_id}}
            },
            success: function (data) {
                console.log(data);
                var ctx = document.getElementById("myChart").getContext('2d');
                var ctx2 = document.getElementById("myChart2").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.dates,
                        datasets: data.bardata,
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
                var myChart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: data.dates,
                        datasets: data.bardata,
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

            }
        })
    </script>
@endpush
