@extends('btybug::layouts.uiPreview')

@section('content')
    {!! BBbutton('styles','bodycontianerclass','Select Style',['class'=>'btn selectGrayBtn rightSelectBtn ','data-type'=>'container', 'data-filterclass' =>'body']) !!}
    <div class="center-block" id="widget_container">
        {!! $html !!}
    </div>
    <textarea type="hidden" class="hide" id="hidden_data">{!! $json !!}</textarea>
@stop

@section('settings')
    <div class="withoutifreamsetting animated bounceInRight hide" data-settinglive="settings">
        {!! Form::model($model,['id'=>'add_custome_page']) !!}
        @include($settingsHtml)
        {!! Form::close() !!}
    </div>

    @include('resources::assests.magicModal')
@stop
@section('CSS')
    {!! HTML::style("/css/core_styles.css") !!}
    {!! HTML::style("/css/builder-tool.css") !!}
    {!! HTML::style("https://jqueryvalidation.org/files/demo/site-demos.css") !!}

    {!! HTML::style('css/preview-template.css') !!}
    {!! HTML::style('js/animate/css/animate.css') !!}
    @if(isset($model->css) && $model->css)
        @foreach($model->css as $css)
            {!! HTML::style('/resources/views/layouts/themes/'.$model->folder.'/css/'.$css) !!}
        @endforeach
    @endif
    @yield('CSS')
    @stack('css')
@stop
@section('JS')

    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script("js/UiElements/ui-preview-setting.js") !!}
    {!! HTML::script("js/UiElements/ui-settings.js") !!}
    {!! HTML::script("https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js") !!}
    {!! HTML::script("https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js") !!}
    @if(isset($model->js) && $model->js)
        @foreach($model->js as $js)
            {!! HTML::script('/resources/views/layouts/themes/'.$model->folder.'/js/'.$js) !!}
        @endforeach
    @endif
    {!! HTML::script('js/UiElements/content-layout-settings.js') !!}
    @yield('JS')
    @stack('javascript')
@stop
