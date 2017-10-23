{!! Form::model($page,['url' => '/admin/console/structure/pages']) !!}
{!! Form::hidden('id',null,['class' => 'page_id']) !!}
<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 buttons">
    <div class="pull-right">
        <button type="submit" class="save_btn"><i class="fa fa-check" aria-hidden="true"></i>Save</button>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-9  col-lg-9 col-xl-9 create">

    <div class="published_1">
        @if($page)
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 left_sd verticalcontainer">

                    <div class="vertical-text">
                        <span><i class="fa fa-check-circle icon_pbl" aria-hidden="true"></i>Published</span>
                    </div>

                    <div class="row left_part_publ">
                        <div>
                            <div class="row rows">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 row_inputs">
                                    <i class="fa fa-file-text" aria-hidden="true"></i><span
                                            class="labls">Page Name</span>
                                    {!! Form::text('title',null,['class' => 'page_name']) !!}
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 row_inputs">
                                    <i class="fa fa-file-text" aria-hidden="true"></i><span
                                            class="labls">Page URL</span>
                                    <div class="page_address page_labels">{!! url($page->url) !!}</div>
                                </div>
                            </div>
                            <div class="row rows">
                            </div>
                            <div class="row rows">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 row_inputs">
                                    <i class="fa fa-file-o" aria-hidden="true"></i><span
                                            class="labls">Children Pages</span>
                                    {!! Form::select('child_status',
                                        \Sahakavatar\Console\Services\StructureService::getAdminPagesChildStatues(),
                                        null,[]) !!}
                                </div>
                            </div>
                            <div class="row rows">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 row_inputs ">
                                    <i class="fa fa-file-o" aria-hidden="true"></i><span class="labls">Allow role to page</span>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 row_inputs tagitinout">
                                    <input name="tags" class="hide tagitext"
                                           data-allwotag="{!! $rolesData !!}"
                                           value="">
                                    <ul id="tagits" class="tagInputList"
                                        data-allwotag="{!! $rolesData !!}"
                                        class="m-b-0 tagit ui-widget ui-widget-content ui-corner-all">
                                    </ul>
                                </div>
                            </div>
                            <div class="row rows">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 row_inputs ">
                                    <i class="fa fa-file-o" aria-hidden="true"></i><span
                                            class="labls">redirect to</span>
                                    <input type="text" name="redirect_to" id="redirectto" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 right_part_publ">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 author_name_div">
                            <div class="name_btn_div"><span class="author_name labls">Author Name</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 user_photo">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            {{--<i class="fa fa-user" aria-hidden="true"></i>--}}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div>
                No Pages Registered for {{ $slug }} Module
            </div>
        @endif
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 design_panel">
    @if($page)
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row panel_head">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 checkbox_ttl">
                        <h4 class="title_h">
                            <img src="{!!  url('\resources\assets\images\brash.png') !!}" alt="image">
                            Page Design
                        </h4>

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 body_layout">
                        <div class="col-md-6 checkbox_ttl">
                            {{Form::hidden('header',0)}}
                            {{Form::hidden('left_bar',0)}}
                            <label class="bd_layout"><span class="labls">Header</span>
                                {!! Form::checkbox('header',1,null,['style' => 'position:initial;z-index:1;']) !!}
                            </label>
                            <label class="bd_layout"><span class="labls">Left Bar</span>
                                {!! Form::checkbox('left_bar',1,null,['style' => 'position:initial;z-index:1;']) !!}
                            </label>
                        </div>
                        {{--<label class="bd_layout"><span class="labls">Body Layout</span></label>--}}

                        {{--<button class="refresh_button"><span class="labls">Layout 001</span><i class="fa fa-refresh" aria-hidden="true"></i></button>--}}
                        <div class="col-md-6">
                            <a target="_blank"
                               href="{!! url('/admin/console/config/page-preview/'.$page->id.'?pl='.$page->layout_id) !!}"
                               class="apply apply_contents">Apply Contents</a>
                            <span class="pull-right clickable"><i
                                        class="glyphicon glyphicon-chevron-up"></i></span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                        <img src="{!!  url('\resources\assets\images\create-pages.png') !!}" alt="image"
                             class="header_image">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
                        <div class="block">
                            <h5>Leodis Events</h5>
                            <h3>Forum no - 4</h3>
                            <h5>25.02.15</h5>
                            <h2>Lambert's yard</h2>
                            <p class="text_par">
                                It is a long established fact that a reader will be distracted by the
                                readable content of a page when looking at its layout.
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                            <h3><i class="fa fa-long-arrow-right" aria-hidden="true"></i></h3>
                            <p>
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    @endif
</div>
{!! Form::close() !!}