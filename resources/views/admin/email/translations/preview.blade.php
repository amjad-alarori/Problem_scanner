<style>
    .content {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        min-width: 700px;
        height: 60%;
    }
    iframe {
        min-width: 700px;
        height: 100%;
    }
</style>
<div class="content">
    <h1>{{$emailtranslation->subject}}</h1>
    <iframe src="{{route('emailtranslation.previewframe', ['emailtranslation' => $emailtranslation])}}" frameborder="0"></iframe>
</div>
