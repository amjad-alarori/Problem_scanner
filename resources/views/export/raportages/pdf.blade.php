<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
    <style>
        td {
            border: 1px solid black;
        }

        .card {

            border: #eae8e6 2px solid;
            width: 200px;
            margin: 5px;
        }

        td {
            width: 200px !important;
            text-align: center;
            padding: 10px;
            height: 200px;
        }

        img {
            width: 240px;
            height: 150px;
            margin-top: 2px;
        }
        body{
            width: 100%;
            height: 100%;
        }

        table {
            width: 50%;
        }

        /*td {*/
        /*    width: 10px;*/
        /*    height: 310px;*/
        /*}*/



        .scan-ratio-input-1 {
            color: #32b34b;
            margin:1px;
        }

        .scan-ratio-input-2 {
            color: #92ca47;
            margin:1px;
        }

        .scan-ratio-input-3 {
            color: #ffc73a;
            margin:1px;
        }

        .scan-ratio-input-4 {
            color: #ff8e2a;
            margin:1px;
        }

        .scan-ratio-input-5 {
            color: #ff2f1c;
            margin:1px;
        }

        .scan-ratio-label{
            margin: 5px;
        }



    </style>
</head>
<body>
{{--<h1>{{$scan->name}}</h1>--}}
{{--<table style="width:100%">--}}
{{--    <tr>--}}
{{--@foreach($data as $dataArray)--}}


{{--        <div class="card">--}}
{{--            <img src="C:\Code\periode 3\OrangeEyes\storage\app\public\images\E74bY1dwL2x0aaU7KnkitlIT7a6wHt40i6RERW80.jpg" alt="kapot" place>--}}
{{--            <div class="container">--}}
{{--                <h4><b>{{$dataArray['question']->question}}</b></h4>--}}
{{--                <div class="selectionbox">--}}
{{--                    @for($counter=1;$counter < 6; $counter++)--}}
{{--                        <div class="flex-row">--}}
{{--                            <label class="scan-ratio-label-{{$counter}}">{{$counter}}--}}
{{--                                <input type="radio" name="questioninput{{$dataArray['question']->id}}}"--}}
{{--                                       value="{{$dataArray['answer']}}" disabled--}}
{{--                                       @if($counter == $dataArray['answer']) checked="checked" @endif>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    @endfor--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--        @endforeach--}}
{{--    </tr>--}}
{{--        <th>Age</th>--}}
{{--    </tr>--}}

{{--</table>--}}


{{--    @foreach($data as $dataArray)--}}
{{--        <div class="row">--}}
{{--        <div class="card">--}}
{{--            <img src="C:\Code\periode 3\OrangeEyes\storage\app\public\images\E74bY1dwL2x0aaU7KnkitlIT7a6wHt40i6RERW80.jpg" alt="kapot" place>--}}
{{--                <div class="container">--}}
{{--                <h4><b>{{$dataArray['question']->question}}</b></h4>--}}
{{--                <div class="selectionbox">--}}
{{--                    @for($counter=1;$counter < 6; $counter++)--}}
{{--                        <div class="flex-row">--}}
{{--                        <label class="scan-ratio-label-{{$counter}}">{{$counter}}--}}
{{--                            <input type="radio" name="questioninput{{$dataArray['question']->id}}}"--}}
{{--                                   value="{{$dataArray['answer']}}" disabled--}}
{{--                                   @if($counter == $dataArray['answer']) checked="checked" @endif>--}}
{{--                        </label>--}}
{{--                        </div>--}}
{{--                    @endfor--}}
{{--                </div>--}}

{{--                </div>--}}
{{--        </div>--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--</div>--}}

{{--            <img src="{{$dataArray['question']->image}}" alt="">--}}
{{--            <p style="text-align:center;">--}}
{{--                <b>--}}
{{--                {{$dataArray['question']->question}}--}}
{{--                {{$dataArray['answer']}}--}}

{{--            </p>--}}


{{--{{$scan->name}}--}}
{{--@foreach($data as $dataArray)--}}
{{--    <img src="{{$dataArray['question']->image}}" alt="">--}}
{{--@endforeach--}}



{{--<table>--}}
{{--    <tr>--}}
{{--        <td class="black color-{{$amount}}"></td>--}}
{{--        <td></td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td></td>--}}
{{--        <td></td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td></td>--}}
{{--        <td class="black"></td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td></td>--}}
{{--        <td></td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td></td>--}}
{{--        <td></td>--}}
{{--        <td class="black"></td>--}}
{{--    </tr>--}}

{{--</table>--}}
<img class="logo" src="C:\Code\periode 3\OrangeEyes\storage\app\public\images\logos\logo orange eyes.jpg"><h1>{{$scan->name}}</h1>
<table style="width: 100%;">

    @foreach($data as $chunk)
    <tr>
        @foreach($chunk as $item)
        <td>
            <img
                src="C:\Code\periode 3\OrangeEyes\storage\app\public\images\YHb7ecWBHcBYH5InX9Md12f1pFDNgYb1RcXJgh86.png"/>

                <p>{{$item['question']->question}}</p><br>
                 @for($counter=1;$counter < 6; $counter++)

            <label class="scan-ratio-label">{{$counter}}
              <input class="scan-ratio-input-{{$counter}}" type="radio" name="questioninput{{$item['question']->id}}}"
                 value="{{$item['answer']}}" disabled
                  @if($counter == $item['answer']) checked="checked" @endif>
            </label>

                                        @endfor
{{--            <table>--}}
{{--                <tr>--}}
{{--                    <td>1</td>--}}
{{--                    <td>2</td>--}}
{{--                    <td>3</td>--}}
{{--                    <td>4</td>--}}
{{--                    <td>5</td>--}}
{{--                </tr>--}}
{{--            </table>--}}
        </td>
        @endforeach

    </tr>
    @endforeach
</table>
</body>
</html>
