@extends('cms::layouts.admin')
@section('content')
    <div class="row">
        <a href="{!! url('admin/console/structure/pages') !!}"><div class="pages col-md-5">Pages</div></a>
        <a href="{!! url('admin/console/structure/menus') !!}"><div class="pages col-md-5">Menus</div></a>
        <a href="{!! url('admin/console/structure/classify') !!}"><div class="pages col-md-5">Classify</div></a>
        <a href="{!! url('admin/console/structure/urls') !!}"><div class="pages col-md-5">Urls</div></a>
        <a href="{!! url('admin/console/structure/settings') !!}"><div class="pages col-md-5">Settings</div></a>
        <a href="{!! url('admin/console/structure/tables') !!}"><div class="pages col-md-5">Tables</div></a>
    </div>
@stop
@section('CSS')
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