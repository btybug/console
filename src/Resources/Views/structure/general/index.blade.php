@extends('btybug::layouts.admin')

@section('content')

    <div class="main_lay_cont">
        <div class="row for_title_row">
            <h1 class="text-center">General</h1>
        </div>
        <div class="row layouts_row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 items_links">
                <a href="{!! url('admin/console/general/validations') !!}" class="ly_items">
                    <h3>Validations</h3>
                    <h2><i class="fa fa-cogs" aria-hidden="true"></i></h2>
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 items_links">
                <a href="{!! url('admin/console/general/trigger-events') !!}" class="ly_items">
                    <h3>Trigger-Events</h3>
                    <h2><i class="fa fa-bank" aria-hidden="true"></i></h2>
                </a>
            </div>
        </div>
    </div>

@stop
@section('CSS')
    {!! HTML::style('public/css/backend_layouts_style.css') !!}
    <style>
        .pages.col-md-5 {
            border: 1px solid black;
            border-radius: 8px;
            text-align: center;
            height: 200px;
            background: antiquewhite;
            padding-top: 72px;
            margin: 7px;
            font-size: xx-large;
            font-family: fantasy;
        }
    </style>
@stop
@section('JS')
@stop