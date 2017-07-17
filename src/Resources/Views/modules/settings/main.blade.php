@extends('layouts.admin')
@section('content')
    <div class="row">
        <a href="{!! url('admin/console/modules/'.$basename.'/general') !!}"><div class="pages col-md-5">General views</div></a>
        <a href="{!! url('admin/console/modules/'.$basename.'/gears') !!}"><div class="pages col-md-5">Gears</div></a>
        <a href="{!! url('admin/console/modules/'.$basename.'/assets') !!}"><div class="pages col-md-5">Assets</div></a>
        <a href="{!! url('admin/console/modules/'.$basename.'/build') !!}"><div class="pages col-md-5">Build</div></a>
        <a href="{!! url('admin/console/modules/'.$basename.'/permission') !!}"><div class="pages col-md-5">permission</div></a>
        <a href="{!! url('admin/console/modules/'.$basename.'/code') !!}"><div class="pages col-md-5">code</div></a>
        <a href="{!! url('admin/console/modules/'.$basename.'/tables') !!}"><div class="pages col-md-5">tables</div></a>
        <a href="{!! url('admin/console/modules/'.$basename.'/views') !!}"><div class="pages col-md-5">views</div></a>
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

