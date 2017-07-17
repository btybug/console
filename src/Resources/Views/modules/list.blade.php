@extends('layouts.admin')
@section('content')
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cms_module_list">
            <h3 class="menuText f-s-17">
                <span class="module_icon_main"></span>
                <span class="module_icon_main_text">
                    {!! Form::select('type',['extra' => 'Extra Modules','core' => 'Core Modules'],$type,['class' => 'form-control select-modules']) !!}
                </span>
            </h3>
            <hr>
            <ul class="list-unstyled menuList" id="components-list">
                @if(count($extras))
                    @foreach($extras as $m)
                        <li class=" @if($m->slug == $module->slug) active @endif">
                            @if($type)
                                <a href="{!! url('admin/console/modules?type='.$type.'&m='. $m->basename) !!}">
                            @else
                                <a href="{!! url('admin/console/modules?m='. $m->slug) !!}">
                            @endif
                                <span class="module_icon"></span>
                                {!! $m->name !!}
                            </a>
                        </li>
                    @endforeach
                @else
                    <li>No Modules</li>
                @endif
            </ul>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6">
                            <a class="btn btn-sm  m-b-10 upload_module" href="/admin/console/optimisation">
                                <i class="fa fa-steam-square" aria-hidden="true"></i>
                                <span class="upload_module_text">Modules Optimize</span>

                            </a>
                        </div>

                        <div class="col-xs-6">
                        </div>
                    </div>

                    <div class="row module_detail">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <img src="{!! url('resources/assets/images/module.jpg') !!}" alt=""
                                 class="img-rounded img-responsive"/>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="module-title">{!! $module->name !!}</div>
                            <div class="module-desc">
                                {!! $module->description !!}
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pull-right text-right m-t-20">
                            @if(isset($module->have_setting) and $module->have_setting==1)
                                <a href="{!! url('admin/console/setting',$module->id) !!}"
                                   class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left settings"><i
                                            class="fa fa-pencil f-s-14 m-r-10"></i> Settings</a>
                            @endif
                            <a href="{!! url('admin/console/modules/'.$module->basename.'/general') !!}"
                               class="btn  btn-sm  m-b-5 p-l-20 p-r-20 width-150 text-left"><i
                                        class="fa fa-cogs f-s-14 m-r-10"></i> Config</a>
                        </div>
                    </div>

                    <div class="row module_detail_link">
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 m-t-10 m-b-10">
                            <a href="{!! $module->author_site or null !!}"
                               class="module_detail_author_link">{!! $module->author_site or null !!}</a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 module_author_detail m-t-10 m-b-10">
                            <div class="pull-left">
                                <i class="fa fa-bars f-s-15" aria-hidden="true"></i>
                                Version {!! $module->version !!}
                            </div>
                            <div class="pull-right">
                                <i class="fa fa-user f-s-15" aria-hidden="true"></i>
                                {!! $module->author or null!!}
                                , {!! BBgetDateFormat(isset($module->created_at)?$module->created_at :null) !!}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="m-t-15 col-xs-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#installed_add_ons"
                                                                  aria-controls="installed_add_ons" role="tab"
                                                                  data-toggle="tab">Installed Plugins</a></li>
                        <li role="presentation"><a href="#related_add_ons" aria-controls="related_add_ons" role="tab"
                                                   data-toggle="tab">Related Add-Ons</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content m-t-15">
                        <div role="tabpanel" class="tab-pane active" id="installed_add_ons">
                            @include("console::modules.plugins")
                        </div>
                        <div role="tabpanel" class="tab-pane" id="related_add_ons">...cc</div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@stop
@section('CSS')


    {!! HTML::style('resources/assets/js/bootstrap-switch/css/bootstrap-switch.min.css') !!}
    {!! HTML::style('app/Modules/Modules/Resources/assets/css/store.css') !!}
    {!! HTML::style('app/Modules/Modules/Resources/assets/css/new-store.css') !!}
@stop
@section('JS')
    <script>

        $(document).ready(function () {
            $("body").on('change','.select-modules',function(){
                var value = $(this).val();
                window.location.href = "/admin/console/modules?type=" + value;
            });

//            $('body').on('click', '.del-module', function () {
//                var namespace = $(this).attr('namespace');
//                $.ajax({
//                    url: '/admin/modules/delete',
//                    data: {
//                        namespace: namespace,
//                        _token: $('input[name=_token]').val()
//                    },
//                    dataType: 'json',
//                    success: function (data) {
//                        console.log(data);
//                        if (!data.error) {
//                            location.reload();
//                        } else {
//                            $('#message-modal .modal-body').html(data.message);
//                            $('#message-modal').modal();
//                        }
//                    },
//                    type: 'POST'
//                });
//            });
//            $('body').on('click', '.enb-disb', function () {
//                var namespace = $(this).attr('namespace');
//                var action=$(this).attr('data-action');
//                $.ajax({
//                    url: '/admin/modules/'+action,
//                    data: {
//                        namespace: namespace,
//                        _token:  $('input[name=_token]').val()
//                    },
//                    dataType: 'json',
//                    success: function (data) {
//                        if (!data.error) {
//                            location.reload();
//                        } else {
//                            $('#message-modal .modal-body').html(data.message);
//                            $('#message-modal').modal();
//                        }
//                    },
//                    type: 'POST'
//                });
//            });
        });

    </script>
@stop

