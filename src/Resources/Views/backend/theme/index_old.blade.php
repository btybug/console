@extends('btybug::layouts.mTabs',['index'=>'backend_gears'])
@section('tab')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 admin_themes">
            <div class="row template-search div_top_31">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 template-search-box m-t-10 m-b-10">
                    <form class="form-horizontal form_sort_31">
                        <div class="form-group m-b-0">
                            <label for="inputEmail3" class="col-xs-12 col-sm-2 control-label">Sort By</label>
                            <div class="col-xs-12 col-sm-6 col-md-4 for_select_11">
                                <select class="form-control sort-items">
                                    <option>Recently Added</option>
                                </select>
                            </div>
                            <div class="col-sm-2 pull-right for_search_20">
                                <a class="btn btn-default"><i class="fa fa-search f-s-15" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 template-upload-button p-l-0 p-r-0">
                    <button class="btn btn-sm  pull-right m-b-10 " type="button" data-toggle="modal"
                            data-target="#uploadfile">
                        <span class="module_upload_icon m-l-20"></span><span class="upload_module_text">Upload</span>
                    </button>
                </div>
            </div>
            <div class="themes-list  m-t-20 m-b-10 div_cont_12">
                <div class="row templates m-b-10">
                    {!! HTML::image('public/img/ajax-loader5.gif', 'a picture', array('class' => 'thumb img-loader hide')) !!}
                    @if(count($themes))
                        @foreach($themes as $th)
                            <div class="raw tpl-list" style="background: white;">
                                <div class="row templates m-b-10">
                                    <div class="col-xs-12 p-l-0 p-r-0 for_img_112">
                                        <img src="{!! url('resources\assets\images\template-2.png')!!}"
                                             class="img-responsive"/>
                                        {{--<img src="{!! url('public/img/template-2.png')!!}"--}}
                                        {{--class="img-responsive"/>--}}
                                    </div>
                                    <div class="col-xs-12 templates-header p-t-10 p-b-10 for_header_112">
                                        <span class="pull-left templates-title f-s-15 col-xs-12 col-sm-12 col-md-6 col-lg-6 p-l-0  for_title_111">
                                            <i class="fa fa-bars f-s-13 m-r-5"
                                               aria-hidden="true"></i> {!! $th->title or $th->folder !!} </span>
                                        <div class="pull-right templates-buttons col-xs-12 col-sm-12 col-md-6 col-lg-6 p-r-0 text-right for_author_111">
                                            <i class="fa fa-user f-s-13 author-icon" aria-hidden="true"></i>
                                            <span class="name_111"> {{ $th->author or '---' }}
                                                , {!! BBgetDateFormat($th->created_at) !!}</span>

                                            <a href="{!! url('admin/console/backend/theme/settings',[$th->slug,'superadmin']) !!}"
                                               target="_blank" class="addons-deactivate  m-r-10"><i
                                                        class="fa fa-cog f-s-14"></i> </a>

                                            @if($th->slug == \App\Modules\Resources\Models\BackendTh::active()->slug)
                                                <span class="label label-success m-r-10 active-111"><i
                                                            class="fa fa-check"></i></span>
                                                {{--Active</span>--}}
                                            @else
                                                <a href="#" class="label label-info m-r-10 activate-theme activate_111"
                                                   slug="{{ $th->slug }}" style="cursor: pointer;"><i
                                                            class="fa fa-check-square-o" aria-hidden="true"></i></a>
                                                {{--Activate</a>--}}
                                            @endif


                                            @if($th->slug != "default_123456")
                                                <a href="javascript:void(0)" slug="{{ $th->slug }}"
                                                   class="addons-delete del-theme del_111"><i
                                                            class="fa fa-trash-o f-s-14 "></i> </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
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
                    {!! Form::open(['url'=>'/admin/console/backend/theme/upload','class'=>'dropzone', 'id'=>'my-awesome-dropzone']) !!}

                    {!! Form::close() !!} </div>
            </div>
        </div>
    </div>

@stop
@section('CSS')
    {{--{!! HTML::style('/app/Modules/Assets/Resources/css/new-store.css') !!}--}}
    {!! HTML::style('app\Modules\Resources\Resources\assets\css\new-store.css') !!}
    {!! HTML::style('app\Modules\Resources\Resources\assets\css\style_cube.css') !!}
@stop

@section('JS')
    {!! HTML::script('public/libs/dropzone/js/dropzone.js') !!}

    <script>
        $(document).ready(function () {
            Dropzone.options.myAwesomeDropzone = {
                init: function () {
                    this.on("success", function (file) {
                        location.reload();
                    });
                }
            };

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
                        'X-CSRF-TOKEN': $("#token").val()
                    },
                    success: function (data) {
                        if (!data.error) {
                            location.reload();
                        }
                    }
                });
            });

            $('body').on('click', '.del-theme', function () {
                var slug = $(this).attr('slug');
                $.ajax({
                    url: '/admin/console/backend/theme/delete',
                    data: {
                        slug: slug,
                        _token: $('#token').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
                            location.reload();
                        }
                    },
                    type: 'POST'
                });
            });
        });
    </script>
@stop
