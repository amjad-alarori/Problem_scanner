@extends('layouts.admin')
@section('content')
<head>
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>
             <h1>hoi dit is waar we de mail gaan doen temporary</h1>
<form method="post">
    <textarea id="summernote" name="editordata"></textarea>
</form>
             <script>
                 $(document).ready(function() {
                     $('#summernote').summernote();
                 });
             </script>
@endsection
