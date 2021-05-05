<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
    <style>

        .card{

            border: blue 5px solid ;

        }
        body{
            width: 100%;
            height: 100%;
        }
        table {
            width: 50%;
        }
        td {
            width: 10px;
            height: 100px;
        }
        .black {
            background-color: blue;
        }
        .color-1{}
        .color-2{}
        .color-3{}
    </style>
</head>
<body>
<h1>hello world</h1>

<div class="row pl-3 pr-3">
    @foreach($data as $dataArray)

        <div class="card">
            <img src="{{$dataArray['question']->image}}" alt="Avatar" style="width:100%">
            <div class="container">
                <h4><b>{{$dataArray['question']->question}}</b></h4>
                <p>{{$dataArray['answer']}}</p>
            </div>
        </div>

{{--            <img src="{{$dataArray['question']->image}}" alt="">--}}
{{--            <p style="text-align:center;">--}}
{{--                <b>--}}
{{--                {{$dataArray['question']->question}}--}}
{{--                {{$dataArray['answer']}}--}}

{{--            </p>--}}

            @endforeach
{{--{{$scan->name}}--}}
{{--@foreach($data as $dataArray)--}}
{{--    <img src="{{$dataArray['question']->image}}" alt="">--}}
{{--@endforeach--}}



<table>
    <tr>
{{--        <td class="black color-{{$amount}}"></td>--}}
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td class="black"></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td class="black"></td>
    </tr>

</table>

</body>
</html>
