@extends('layouts.admin')
@section('content')
    <nav class="navbar navbar-default" role="navigation">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                @if( BBgetConfigMenu('uploadsMenu',isset($slug)?$slug:null))
                    @foreach( BBgetConfigMenu('uploadsMenu',isset($slug)?$slug:null) as $key=>$item)
                        @if(!BBgetAdminPagesCilds($item['url']))
                            <li><a href="{!! url($item['url']) !!}">{!! $item['title'] !!}</a></li>
                        @else
                            <li class="dropdown">
                                <a href="{!! url($item['url']) !!}" class="dropdown-toggle" data-toggle="dropdown">{!! $item['title'] !!} <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{!! url($item['url']) !!}">{!! $item['title'] !!}</a></li>

                                    @foreach( BBgetAdminPagesCilds($item['url']) as $key=>$child)
                                        <li><a href="{!! url($child->url) !!}">{!! $child->title !!}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->

    </nav>

    <div class="row">
        <a href="{!! url('admin/console/modules/'.$slug.'/build/pages') !!}"><div class="pages col-md-5">Pages</div></a>
        <a href="{!! url('admin/console/modules/'.$slug.'/build/urls') !!}"><div class="pages col-md-5">urls</div></a>
        <a href="{!! url('admin/console/modules/'.$slug.'/build/menus') !!}"><div class="pages col-md-5">menus</div></a>
        <a href="{!! url('admin/console/modules/'.$slug.'/build/classify') !!}"><div class="pages col-md-5">classify</div></a>
    </div>
@stop
{{--@include('tools::common_inc')--}}
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