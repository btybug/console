@extends('btybug::layouts.uiPreview')

@section('content')
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
    <div class="modal fade" id="magic-settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        {{--{!! Form::open(['url'=>'/admin/backend/theme-edit/live-save', 'id'=>'magic-form']) !!}--}}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    {{--{!! Form::submit('Save',['class' => 'btn btn-success pull-right m-r-10']) !!}--}}
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" style="min-height: 500px;">

                    <div id="magic-body">

                    </div>
                </div>
            </div>
        </div>
        {{--{!! Form::close() !!}--}}
    </div>

@stop
@section('CSS')
    {!! HTML::style('css/preview-template.css') !!}
    {!! HTML::style('js/animate/css/animate.css') !!}
    @foreach($model->css as $css)
        {!! HTML::style('/resources/views/ContentLayouts/'.$model->folder.'/css/'.$css) !!}
    @endforeach
@stop
@section('JS')
    @foreach($model->js as $js)
        {!! HTML::style('/resources/views/ContentLayouts/'.$model->folder.'/js/'.$js) !!}
    @endforeach
    {!! HTML::script('js/UiElements/content-layout-settings.js') !!}
@stop
