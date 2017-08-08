@extends('cms::layouts.mTabs',['index'=>'backend_gears'])
        <!-- Nav tabs -->
@section('tab')
    {!! HTML::style('app/Modules/Uploads/Resources/assets/css/new-store.css') !!}
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cms_module_list">
            <h3 class="menuText f-s-17 hide">
                <span class="module_icon_main"></span>
                <span class="module_icon_main_text">Units</span>
            </h3>
            <div class=" menuBox">
                <div class="selectCat">
                </div>
            </div>
            <hr>
            <ul class="list-unstyled menuList" id="components-list">
                @if(count($themes))
                    @foreach($themes as $theme)
                        @if($curentTheme)
                            @if($curentTheme->slug == $theme->slug)
                                <li class="active">
                            @else
                                <li class="">
                            @endif
                        @else
                            @if($themes[0]->slug == $theme->slug)
                                <li class="active">
                            @else
                                <li class="">
                                    @endif
                                    @endif
                                    <a href="?p={!! $theme->slug !!}" rel="unit" data-slug="{{ $theme->name }}"
                                       class="tpl-left-items">
                                        <span class="module_icon"></span> {{ $theme->name }}
                                    </a>
                                </li>
                                @endforeach
                                @else
                                    No Units
                                @endif
            </ul>
        </div>


        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 unit-box">
                    {{--@include('console::backend.gears.units._partials.unit_box')--}}
                </div>
            </div>
            <div class="row template-search">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 template-search-box m-t-10 m-b-10">
                    <form class="form-horizontal">
                        <div class="form-group m-b-0  ">
                            <label for="inputEmail3" class="control-label text-left"><i
                                        class="fa fa-sort-amount-desc"></i> Sort By</label>
                            <select class="selectpicker" data-style="selectCatMenu" data-width="50%">
                                <option>Recently Added</option>
                            </select>

                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 p-l-0 p-r-0">
                    <div class="template-upload-button clearfix">
                        <div class="rightButtons">
                            <div class="btn-group listType">
                                <a href="#" class="btn btnListView"><i class="fa fa fa-th-list"></i></a>
                                <a href="#" class="btn btnGridView active"><i class="fa fa-th-large"></i></a>
                            </div>
                            <a class="btn btn-default searchBtn"><i class="fa fa-search " aria-hidden="true"></i></a>
                        </div>

                        <ul class="editIcons list-unstyled ">
                            <li><a href="#" class="btn trashBtn"><i class="fa fa-trash-o"></i></a></li>
                            <li><a href="#" class="btn copyBtn"><i class="fa fa-clone"></i></a></li>
                            <li><a href="#" class="btn editBtn"><i class="fa fa-pencil"></i></a></li>
                            <li>
                                <a href="{!! url('admin/console/backend/theme/settings',[$curentTheme->slug,'superadmin']) !!}"
                                   target="_blank" class="addons-deactivate btnDeactivate btn">
                                    <i class="fa fa-cog f-s-14"></i> </a>

                                @if($curentTheme->slug == \App\Modules\Resources\Models\BackendTh::active()->slug)
                                    <span class="label label-success m-r-10 active-111"><i
                                                class="fa fa-check"></i></span>
                                    {{--Active</span>--}}
                                @else
                                    <a href="#" class="btn label label-info activate-theme activate_111 btnactivate"
                                       slug="{{ $curentTheme->slug }}" style="cursor: pointer;"><i
                                                class="fa fa-check-square-o" aria-hidden="true"></i></a>
                                    {{--Activate</a>--}}
                                @endif</li>
                        </ul>

                        <button class="btn btn-sm pull-right btnUploadWidgets" type="button" data-toggle="modal"
                                data-target="#uploadfile">
                            <i class="fa fa-cloud-upload module_upload_icon"></i> <span class="upload_module_text">Upload Theme</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row template-search">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 p-l-0 p-r-0">
                    <div class="template-upload-button clearfix">


                        {{--<ul class="editIcons list-unstyled ">--}}
                        {{--<a href="{!! url('admin/console/backend/theme/settings',[$curentTheme->slug,'superadmin']) !!}"--}}
                        {{--target="_blank" class="addons-deactivate  m-r-10"><i--}}
                        {{--class="fa fa-cog f-s-14"></i> </a>--}}

                        {{--@if($curentTheme->slug == \App\Modules\Resources\Models\BackendTh::active()->slug)--}}
                        {{--<span class="label label-success m-r-10 active-111"><i--}}
                        {{--class="fa fa-check"></i></span>--}}
                        {{--Active</span>--}}
                        {{--@else--}}
                        {{--<a href="#" class="label label-info m-r-10 activate-theme activate_111"--}}
                        {{--slug="{{ $curentTheme->slug }}" style="cursor: pointer;"><i--}}
                        {{--class="fa fa-check-square-o" aria-hidden="true"></i></a>--}}
                        {{--Activate</a>--}}
                        {{--@endif--}}
                        {{--</ul>--}}
                    </div>
                </div>
            </div>

            <div class="templates-list  m-t-20 m-b-10">
                <div class="row m-b-10">
                    {!! HTML::image('resources/assets/images/ajax-loader5.gif', 'a picture', array('class' => 'thumb img-loader hide')) !!}
                    <div class="raw tpl-list">
                        @include('console::backend.gears._partials.themes_roles')
                    </div>
                </div>
            </div>

            <div class="loadding"><em class="loadImg"></em></div>
            <nav aria-label="" class="text-center">
                <ul class="pagination paginationStyle">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            <div class="text-center">
                <button type="button" class="btn btn-lg btn-primary btnLoadmore"><em class="loadImg"></em> Load more
                </button>
            </div>

        </div>
    </div>

    <div class="modal fade" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'/admin/uploads/units/upload-unit','class'=>'dropzone', 'id'=>'my-awesome-dropzone']) !!}
                    {!! Form::hidden('data_type','files',['id'=>"dropzone_hiiden_data"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('resources::assests.deleteModal',['title'=>'Delete Widget'])
@stop
@section('CSS')
    {!! HTML::style('js/bootstrap-select/css/bootstrap-select.min.css') !!}
    <style>
        .child-tpl {
            width: 95% !important;
        }

        .img-loader {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 50px;
            left: 40%;
        }

        a.btnDeactivate.addons-deactivate, a.btnactivate.activate-theme.activate_111 {
            font-size: 21px !important;
            width: 34px !important;
            height: 33px !important;
            padding: 0 !important;
            vertical-align: middle !important;
            border: solid 1px #d2d3d5 !important;
            box-shadow: 1px 1px 3px 0 rgba(2, 2, 2, 0.14) !important;
            border-radius: 4px !important;
            background-color: white !important;

        }

        a.btnDeactivate.addons-deactivate {
            line-height: 27px;
            margin-right: 6px;
            color: #6b778e;
        }

        a.btnDeactivate.addons-deactivate:hover {
            color: #6b778e;
        }

        .label.btnactivate {
            display: inline-block;
            color: #69b89c;
        }

        .label.btnactivate:hover {
            color: #69b89c;
        }

    </style>
@stop
@section('JS')
    {!! HTML::script('js/dropzone/js/dropzone.js') !!}
    {!! HTML::script('js/bootstrap-select/js/bootstrap-select.min.js') !!}
    <script>
        Dropzone.options.myAwesomeDropzone = {
            init: function () {
                this.on("success", function (file) {
                    location.reload();

                });
            }
        };

        $(document).ready(function () {
            $("body").on('click', '.activate-theme', function () {
                var slug = $(this).attr('slug');

                $.ajax({
                    type: "post",
                    url: "{!! url('/admin/console/backend/theme/make-active') !!}",
                    cache: false,
                    datatype: "json",
                    data: {
                        slug: slug
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("[name=_token]").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            location.reload();
                        }
                    }
                });
            });

            $('body').on("change", ".select-type", function () {
                var val = $(this).val();
                var url = window.location.pathname + "?type=" + val;

                window.location = url;
            });

            $('.rightButtons a').click(function (e) {
                e.preventDefault();
                $(this).addClass('active').siblings().removeClass('active');
            });

            $('.btnListView').click(function (e) {
                e.preventDefault();
                $('#viewType').addClass('listView');
            });

            $('.btnGridView').click(function (e) {
                e.preventDefault();
                $('#viewType').removeClass('listView');
            });

            $('.selectpicker').selectpicker();

        });

    </script>
@stop
