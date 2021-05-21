<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Raportage</title>
    <style>
        #bg {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 1100px;
            height: 800px;
            z-index: -1;
            margin-left: -30px;
            margin-bottom: -40px;
        }

        td {
            background-color: white;
        }

        @font-face {
            font-family: "Corbel";
            font-style: normal;
            font-weight: normal;
            src: url("fonts/Corbel.ttf") format("truetype");
        }

        td, b, p, label {
            font-family: "Corbel" !important;
        }

        .logo {

            height: 50px;
            margin-bottom: 30px;
            margin-top: -20px;
        }

        .block-img {
            width: 120px;
            height: 120px;
            float: left;
        }

        table {
            border-spacing: 0;
        }

        .block-table {
            float: right;
            margin-left: 20px;
            width: 400px;
            height: 90px;
            border-spacing: 10px 0;
        }

        .block-table tbody, .block-table tr {
            margin-left: 200px;
        }

        .block-table td {
            background-color: #eae8e6;
            height: 36.5px;
        }

        .answer-1 {
            background-color: #32b34b !important;
        }

        .answer-2 {
            background-color: #92ca47 !important;
        }

        .answer-3 {
            background-color: #ffc73a !important;
        }

        .answer-4 {
            background-color: #ff8e2a !important;
        }

        .answer-5 {
            background-color: #ff2f1c !important;
        }

        .answer-0 {
            background-color: #1c606a;
        }

        .block-text {
            color: white;
            padding: 10px;
            clear: left;
            width: 100px;
            text-align: center;
            font-family: "Corbel" !important;
        }

        .td-left {
            border-left: 1px solid #2c2e35;
            border-top: 1px solid #2c2e35;
            border-bottom: 1px solid #2c2e35;
            width: 50%;
        }

        .td-right {
            border: 1px solid #2c2e35;
        }

        .td-left, .td-right {
            padding: 10px 2px 10px 10px;
        }

        .date {
            padding: 10px;
            text-align: center;
            transform: rotate(90deg);
            color: black !important;
            background-color: transparent !important;
        }

        .tb {
            margin-top: 65px;
        }
    </style>
</head>
<body>
    <img id="bg" src="{{public_path('assets/images/export/bg.png')}}">
    <img class="logo" src="{{public_path('img/logos/orange_eyes.jpg')}}">
    <table style="float: right; margin-top: -20px;">
        <tr>
            <td style="width: 100px;">Made for:</td>
            <td style="text-align: right; padding-right: 10px; border-right: 1px solid #020407">{{$metadata["result_made_for"]}}</td>
            <td style="width: 100px; padding-left: 10px;">Created on:</td>
            <td style="text-align: right">{{$metadata['created_at']}}</td>
        </tr>
        <tr>
            <td>Made by:</td>
            <td style="text-align: right; padding-right: 10px; border-right: 1px solid #020407">{{$metadata["result_made_by"]}}</td>
            <td style="padding-left: 10px;">Scan:</td>
            <td style="text-align: right">{{$scan->name}}</td>
        </tr>
    </table>
    @foreach($dataArray as $dt)
        <table class="tb" style="width: 100%;">
            @foreach($dt as $data)
                <tr>
                    @php
                        $left =true;
                    @endphp
                    @foreach ($data as $question_id => $item)

                        <td @if($left) class="td-left" @else class="td-right" @endif>
                            @if($left)
                                {{$left = false}}
                            @endif
                            <img src="{{$questionsImages[$question_id]}}"
                                 class="block-img">
                            <table class="block-table">
                                <tbody>
                                @for($counter=5;$counter > 0; $counter--)
                                    <tr>
                                        @foreach($item[0] as $answer)
                                            <td @if($counter == $answer)
                                                class="answer-{{$answer}}"
                                                @endif
                                            ></td>
                                        @endforeach
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                            {{--                                14--}}
                            <div class="block-text"
                                 style="background-color: {{\App\Models\Questions::find($question_id)->categories->color}}">
                                @if(strlen(\App\Models\Questions::find($question_id)->question) > 14)
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach(str_split(\App\Models\Questions::find($question_id)->question, 14) as $char)
                                        @php
                                            $i++;
                                        @endphp
                                        {{$char}}
                                        @if($i % 14 == 0)
                                            <br/>
                                        @endif
                                    @endforeach
                                @else
                                    {{\App\Models\Questions::find($question_id)->question}}
                                    <br>
                                    <span style="color: {{\App\Models\Questions::find($question_id)->categories->color}}">&nbsp;</span>
                                @endif
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach

            <tr style="width: 100%">
                @php
                    $left =true;
                @endphp
                <td @if($left) class="td-left" @else class="td-right" @endif style="border: none; background-color: transparent !important;">
                    @if($left)
                        {{$left = false}}
                    @endif

                    <table class="block-table">
                        <tbody>
                        <tr>
                            @foreach($dataByQuestionsDates as $dataItem)
                                <td class="date">
                                    {{date_format($dataItem,"d-m-Y")}}

                                </td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </td>


                <td @if($left) class="td-left" @else class="td-right" @endif style="border: none; background-color: transparent !important;">
                    @if($left)
                        {{$left = false}}
                    @endif

                    <table class="block-table">
                        <tbody>
                        <tr>
                            @foreach($dataByQuestionsDates as $dataItem)
                                <td class="date">
                                    {{date_format($dataItem,"d-m-Y")}}

                                </td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        @if(!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
    <script type="text/php">
if ( isset($pdf) ) {
$pdf->page_script('
if ($PAGE_COUNT > 1) {
$font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
$pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
$pdf->text(750, 560, $pageText, $font, 12);
}
');
}




    </script>
</body>
</html>
