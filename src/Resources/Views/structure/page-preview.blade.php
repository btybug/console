@extends('cms::layouts.pagesPreview')

@section('content')
    <div class="previewlivesettingifream">
        @if($data['page'] and $data['url'])
            @if(! starts_with($data['url'],"/"))
                <?php $data['url'] = "/" . $data['url']; ?>
            @endif
            @if(isset($_GET['pl_live_settings']))
                <iframe src="{{ $data['url'].'?pl='. $data['layout'].'&pl_live_settings=page_live&page_id='.$data['page_id'] }}"
                        id="iframeinfor"></iframe>
            @else
                <iframe src="{{ $data['url'].'?pl='. $data['layout'].'&page_id='.$data['page_id'] }}"
                        id="iframeinfor"></iframe>
            @endif

            <div class="iframenotclickable"></div>
        @else
            Admin Page can't be rendered
        @endif
    </div>
    <div class="withoutifreamsetting animated bounceInRight hide" data-settinglive="settings">
        <form id="add_custome_page" action="#" method="post">
            @if(isset($settingsHtml))
                @include($settingsHtml,$settings)
            @endif
        </form>
    </div>
    <div id="previewImageifreamimage"></div>
@stop

@section('CSS')
    {!! HTML::style('css/create_pages.css') !!}
    {!! HTML::style('css/preview-template.css') !!}
    {!! HTML::style("/js/animate/css/animate.css") !!}
    {!! HTML::style("/css/preview-template.css") !!}
@stop

@section('JS')
    {!! HTML::script("js/html2canvas/js/html2canvas.js") !!}
    {!! HTML::script("js/canvas2image/js/canvas2image.js") !!}
    {!! HTML::script("js/bootbox/js/bootbox.min.js") !!}
    {!! HTML::script("js/UiElements/ui-page-preview-setting.js") !!}


    <script>
        $(document).ready(function () {


            $('body').on('click', '.item', function () {
                var layoutID = $(this).data('value');
                var currentUrl = window.location.pathname;
                window.location.href = currentUrl + "?pl=" + layoutID + "&pl_live_settings=page_live";
            });

        });
    </script>
@stop