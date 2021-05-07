<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Raportage</title>
</head>
<body>
    <style>
        .logo {
            width: 250px;
        }

        .block-img {
            width: 200px;

        }

        img{
            height: 200px;
            width: 200px;
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
            height: 28.5px;
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

        .block-text {
            background-color: #ffc841;
            color: white;
            padding: 10px;
            clear: left;
            width: 100px;
            text-align: center;
            font-weight: bold;
        }

        .td-left {
            border-left: 1px solid #2c2e35;
            border-top: 1px solid #2c2e35;
            border-bottom: 1px solid #2c2e35;
        }

        .td-right {
            border: 1px solid #2c2e35;
        }

        .td-left, .td-right {
            padding: 10px 2px 10px 10px;
        }
    </style>

    <img class="logo" src="/Users/samir/School/Code/2020_ADSD_Semester2_TeamB2/public/img/logos/orange_eyes.jpg">

    <table style="width: 100%">
        @foreach($dataArray as $data)  (chunk)
        <tr>
            @foreach ($data as $question_id => $item)

            <td class="td-left">
                @php
                $question = \App\Models\Questions::find($question_id);
                @endphp
                <img
                    src="{{$question ? $question->image : ''}}"

                    class="block-img">

                <table class="block-table">

                    <tbody>
                    @for($counter=1;$counter < 6; $counter++)
                    for loop (counter van 5 mogelijkheden)
                    <tr>
                        @foreach($item as $answer):
                        foreach loop (anwers)

                        <td @if($counter == $answer)
                            class="answer-{{$answer}}"
                           @endif ></td>



                        @endforeach
                    </tr>
                    @endfor


                    </tbody>
                </table>
                <div class="block-text">Mening van anderen</div>

            </td>

                @endforeach


        </tr>
        @endforeach
    </table>
</body>
</html>
