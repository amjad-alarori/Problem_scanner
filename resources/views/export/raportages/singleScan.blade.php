<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='' rel='stylesheet'>
    <title>Export</title>
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

        @font-face {
            font-family: "Corbel";
            font-style: normal;
            font-weight: normal;
            src: url("fonts/Corbel.ttf") format("truetype");
        }

        td, b, p, label {
            font-family: "Corbel" !important;
        }

        .td {
            background-color: white;
            border: 1px solid #020407;
            width: 200px !important;
            text-align: center;
            padding: 10px;
            height: 200px;
        }

        .logo {
            height: 50px;
            float: left;
            margin-top: -20px;
        }

        .img {
            height: 125px;
            margin-bottom: 40px;
        }

        body {
            width: 100%;
            height: 100%;
        }

        .table {
            width: 50%;
            margin-top: 65px;
        }

        .scan-ratio-input-1 {
            color: #32b34b;
        }

        .scan-ratio-input-2 {
            color: #92ca47;
        }

        .scan-ratio-input-3 {
            color: #ffc73a;
        }

        .scan-ratio-input-4 {
            color: #ff8e2a;
        }

        .scan-ratio-input-5 {
            color: #ff2f1c;
        }

        .scan-ratio-label {
            margin: 5px;
            padding-left: 15px;
        }

        .block-text {
            width: 100%;
            height: 50px;
            line-height: 30px;
            color: white;
            margin-bottom: 5px;
            margin-top: -20px;
            font-family: "Corbel" !important;
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
    @foreach($data as $dt)
        <table class="table" style="width: 100%;" cellspacing="0">
            @foreach($dt as $chunk)
                <tr>
                    @foreach($chunk as $item)
                        @php
                            $question = \App\Models\Questions::find($item['question_id']);
                            $category = $question->categories;
                        @endphp
                        <td class="td">
                                                        <img class="img" src="{{$category->image}}"/>
                            <p style="background-color: {{$category->color}};" class="block-text">{{$question->question}}</p>
                            <table style="width: 100%">
                                <tr>
                                    @for($counter=1;$counter < 6; $counter++)
                                        <td style="text-align: center">
                                            <label class="scan-ratio-label"><b>&nbsp;{{$counter}}</b></label>
                                            <br>
                                            <input style="width: 100%" class="scan-ratio-input-{{$counter}}"
                                                   type="radio"
                                                   name="questioninput{{$question->id}}}"
                                                   value="{{$item['answer']}}" disabled
                                                   @if($counter == $item['answer']) checked="checked" @endif>
                                        </td>
                                    @endfor
                                </tr>
                            </table>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
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
