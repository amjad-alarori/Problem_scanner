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
            width: 200px !important;
            text-align: center;
            padding: 10px;
            height: 200px;
        }

        .logo {
            height: 60px;
        }

        .img {
            /*max-width: 240px;*/
            height: 150px;
            margin-top: 2px;
        }

        body {
            width: 100%;
            height: 100%;
        }

        table {
            width: 50%;
        }

        .scan-ratio-input-1 {
            color: #32b34b;
            margin: 1px;
        }

        .scan-ratio-input-2 {
            color: #92ca47;
            margin: 1px;
        }

        .scan-ratio-input-3 {
            color: #ffc73a;
            margin: 1px;
        }

        .scan-ratio-input-4 {
            color: #ff8e2a;
            margin: 1px;
        }

        .scan-ratio-input-5 {
            color: #ff2f1c;
            margin: 1px;
        }

        .scan-ratio-label {
            margin: 5px;
        }

        .block-text {
            width: 100%;
            height: 50px;
            background-color: red;
            line-height: 35px;
        }

    </style>
</head>
<body>
    <img class="logo" src="{{public_path('img/logos/orange_eyes.jpg')}}">
{{--    <h1>{{$scan->name}}</h1>--}}
    <table style="width: 100%; margin-top: 20px;" cellspacing="0">
        @foreach($data as $chunk)
            <tr>
                @foreach($chunk as $item)
                    @php
                        $question = \App\Models\Questions::find($item['question_id']);
                    @endphp
                    <td>
                        <img class="img" src="{{public_path('img/categorieën/18gebrekaangeld.png')}}"/>
                        <p class="block-text">{{$question->question}}</p>
                        @for($counter=1;$counter < 6; $counter++)
                            <label class="scan-ratio-label">{{$counter}}
                                <input class="scan-ratio-input-{{$counter}}" type="radio"
                                       name="questioninput{{$question->id}}}"
                                       value="{{$item['answer']}}" disabled
                                       @if($counter == $item['answer']) checked="checked" @endif>
                            </label>
                        @endfor
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
    <script type="text/php">
if ( isset($pdf) ) {
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 560;
            $x = 750;
            $pdf->text($x, $y, $pageText, $font, $size);
        }
    ');
}


    </script>
</body>
</html>
