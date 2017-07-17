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
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="{!! url('resources/assets/images/module.jpg') !!}" alt="" class="img-rounded img-responsive"/>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>   {!!$module->name !!} Module </h4>
                        <small>{!!$module->author !!} </small>
                        <p>
                            <i class="glyfa fa fa-hashtag"></i>{!! $module->version !!}
                            <br/>
                            <i class="glyfa fa fa-globe"></i><a href="{!! @$module->author_site !!}"> {!! @$module->author_site !!}</a>
                            <br/>
                            <i class="glyfa fa fa-hourglass-end"></i>{!! BBgetDateFormat(@$module->created_at) !!}
                            <br/>
                            <i class="glyfa fa fa-pie-chart"></i>{!! @$module->description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('CSS')
    <style>
        .glyfa {
            margin-bottom: 10px;
            margin-right: 10px;
        }

        small {
            display: block;
            line-height: 1.428571429;
            color: #999;
        }
    </style>
@stop