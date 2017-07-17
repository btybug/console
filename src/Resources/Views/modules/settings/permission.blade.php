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
                                <a href="{!! url($item['url']) !!}" class="dropdown-toggle"
                                   data-toggle="dropdown">{!! $item['title'] !!} <b class="caret"></b></a>
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
        <div class="col-md-12 p-0">
            <div class="collection_page">
                {{--//heading--}}
                <div class="row colections_container">
                    <div class="collections">
                        <div class="col-md-3 first_area blue-col">
                            <a href="">Pages</a>
                        </div>
                        @foreach($roles as $k=>$role)
                            <div class="col-md-3 first_area blue-col">
                                <a href="">{!! $k !!}</a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row colections_container">
                    <div class="collections_bottom perm_list_box">
                        @include('console::modules.settings._partials.perm_list')
                    </div>
                </div>
            </div>


            {{--<div class="col-md-12 p-0">--}}
            {{--@if(count($files))--}}
            {{--@foreach($files as $key => $file)--}}
            {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panels_wrapper">--}}
            {{--<div class="panel panel-default panels accordion_panels">--}}
            {{--<div class="panel-heading bg-black-darker text-white"  role="tab" id="headingLink{{ $key }}">--}}
            {{--<span  class="panel_title">{{ $file->getBasename('.blade.php') }}</span>--}}
            {{--<a role="button" class="panelcollapsed collapsed" data-toggle="collapse"--}}
            {{--data-parent="#accordion" href="#collapseLink{{ $key }}" aria-expanded="true" aria-controls="collapseLink{{ $key }}">--}}
            {{--<i class="fa fa-chevron-down" aria-hidden="true"></i>--}}
            {{--</a>--}}
            {{--<ul class="list-inline panel-actions">--}}
            {{--<li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a></li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--<div id="collapseLink{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingLink">--}}
            {{--<div class="panel-body panel_body panel_1 show">--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endforeach--}}
            {{--@endif--}}
            {{--</div>--}}

        </div>
        @stop
        @section("JS")
            <script>
                $('body').on('click', '.show-child-perm', function () {
                    var permID = $(this).data('pageid');
                    var roleID = $(this).data('roleid');
                    var isChecked = 'no';
                    var token = $('[name=_token]').val();
                    if ($(this).is(":checked")) {
                        isChecked = 'yes';
                    }

                    $.ajax({
                        url: "{!! url('admin/console/modules/'.$slug.'/permission') !!}",
                        data: {
                            pageID: permID,
                            roleID: roleID,
                            isChecked: isChecked,
                            slug: "{!! $slug !!}",
                            _token: token
                        },
                        dataType: 'json',
                        success: function (data) {
                            $('.perm_list_box').html(data.html);
                        },
                        type: 'POST'
                    });
                });
            </script>
        @stop
        @push('css')
        {!! HTML::style('resources/assets/css/admin_pages.css') !!}
        <style>
            .blue-col {
                background: #499bc7;
            }

            .blue-col a {
                color: white !important;
            }

            ul.list_group li {
                list-style-type: none;
                display: inline-block;
            }

            .collection_page .collections_bottom {
                background-color: #fafafa;
                display: inline-block;
                width: 74%;
                margin-left: 70px;
                border: 1px solid #d8d8d8;
            }

            .collection_page .collections_bottom .cols {
                text-align: center;
            }

            .collection_page .collections {
                background-color: #fafafa;
                min-height: 60px;
                height: auto;
                width: 74%;
                margin-left: 70px;
                border: 1px solid #d8d8d8;
            }

            .collection_page .collections .first_area, .collection_page .collections .second_area, .collection_page .collections .third_area, .collection_page .collections .fourth_area {
                min-height: 58px;
            }

            .collection_page .collections .first_area, .collection_page .collections_bottom .first_area {
                color: #3d3d3d;
                font-size: 19px;
                border-right: 1px solid #d8d8d8;
                padding: 14px 22px;
                text-align: center;
            }

            .collection_page .collections .first_area a {
                color: #3d3d3d;
            }

            .collection_page .collections .first_area a:hover {
                text-decoration: none;
            }

            .collection_page .collections .second_area, .collection_page .collections_bottom .second_area {
                padding-top: 16px;
                border-right: 1px solid #d8d8d8;
                /*min-height: 58px;*/
            }

            .collection_page .collections .second_area span.name_auth {
                color: #818181;
                font-size: 16px;
            }

            .collection_page .collections .second_area i, .collection_page .collections_bottom li > a {
                color: #499bc7;
                margin-right: 12px;
                font-size: 20px;

            }

            .collection_page .collections_bottom li > a:hover {
                text-decoration: none;
            }

            .collection_page .collections .third_area, .collection_page .collections .fourth_area, .collection_page .collections .second_area {
                text-align: center;
            }

            .collection_page .collections .third_area, .collection_page .collections_bottom .third_area {
                padding-top: 11px;
                border-right: 1px solid #d8d8d8;
                /*min-height: 58px;*/
            }

            .collection_page .collections .fourth_area, .collection_page .collections_bottom .fourth_area {
                min-height: 58px;
                padding-top: 11px;
            }

            @media (min-width: 1207px) and (max-width: 1536px) {
                .collection_page .collections, .collection_page .collections_bottom {
                    width: 95%;
                    margin: 0 auto;
                    margin-top: 8px;
                }
            }

            @media (max-width: 1207px) {
                .collection_page .collections {
                    width: 95%;
                    margin: 0 auto;
                    margin-top: 8px;
                }

                .collection_page .collections .first_area {
                    text-align: center;
                }

                .collection_page .collections .third_area, .collection_page .collections .second_area, .collection_page .collections .first_area, .collection_page .collections .fourth_area {
                    width: 100%;
                }

                .collection_page .collections .fourth_area.pull-right {
                    float: none !important;
                    border-right: 1px solid #d8d8d8;
                }

            }

            @media (max-width: 1207px) {
                .collection_page .collections .fourth_area {
                    background-color: transparent;
                    min-height: 58px;
                    padding-top: 10px;
                    padding-bottom: 13px;
                }
            }

            /*.collection_page .collections .first_area a:hover {*/
            /*color: #847f7f;*/
            /*}*/
            /*.collection_page .collections:nth-child(3n+0){*/
            /*border-left: 11px solid #7372a2;*/
            /*}*/
            /*.collection_page .collections:nth-child(3n+1){*/
            /*border-left: 11px solid #4eab69;*/
            /*}*/
            /*.collection_page .collections:nth-child(3n+2){*/
            /*border-left: 11px solid #499bc7;*/
            /*}*/
            /*.collection_page .collections:nth-child(3n+3){*/
            /*border-left: 11px solid #ac4040;*/
            /*}*/
            /*.collection_page .collections:nth-child(3n+4){*/
            /*border-left: 11px solid #878638;*/
            /*}*/
            /*.collection_page .collections:nth-child(3n+5){*/
            /*border-left: 11px solid #2f7357;*/
            /*}*/
        </style>
    @endpush