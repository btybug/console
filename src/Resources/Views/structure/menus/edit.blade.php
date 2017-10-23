@extends('cms::layouts.admin')
@section('content')
    {!! Form::open() !!}
    <div class="row">
        <div class="col-md-6">
            <a href="{!! url('admin/console/structure/menus?p='.$menu->id) !!}" class="btn btn-info">Back</a>
        </div>
        <div class="col-md-3">
            <h2 class="m-t-0">{{ $slug }} Menu</h2>
        </div>
        <div class="col-md-3">
            {!! Form::submit('Save',['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 right">
        <article>
            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                <div id="styles" class="panel_bd_styles">
                    {!! hierarchyAdminPagesListWithModuleName($pageGrouped, null, true, $slug) !!}
                </div>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-9 col-xl-9">
                <div class="panel panel-default">
                    <div class="panel-heading bg-black-darker text-white"><a href="/admin/frontend/menu/menufile/menu"
                                                                             class="btn btn-default btn-xs pull-right"
                                                                             data-download="json"
                                                                             download="menujson.json">Download</a>
                        <a href="#" class="btn btn-default btn-xs pull-right m-r-10" data-preview="menu">Preview</a>
                        Menu
                        Item
                    </div>
                    <div class="panel-body">
                        <ol id="sortable2" data-menulist="dropnew" class="dropfalse sortable sortable-mimheight">

                        </ol>
                    </div>
                </div>

            </div>
        </article>
    </div>


    <!-- Item template used by JS -->
    <script type="template" id="item-template">
        <li data-details='[serialized_data]' [class]>
            <div class="drag-handle not-selected">
                [title]
                <div class="item-actions" style="display: block;">
                    <a href="#" class="view-url"><i class="fa fa-cog"></i></a>
                    <a href="javascript:;" data-action="Collapse">
                        <i class="fa fa-arrow-down"></i> Collapse
                    </a>
                    <a href="javascript:;" data-action="delete"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                <div data-collapse="edit" class="collapse">ddf</div>
            </div>
            <ol></ol>
        </li>
    </script>
    <!-- END Item template -->
    <script type="template" id="new-menu-item">
        <!-- Save Status -->
        <input type="hidden" name="save_state" value="add"/>
        <form id="new-item-form">
            <input type="hidden" name="parent_id" value="0"/>
            <input type="hidden" name="item_id" value="0"/>
            <input type="hidden" name="menus_id" value=""/>
            <input type="text" class="hide" name="link_type" value=""/>
            <input type="text" class="hide" name="pagegroup" value=""/>
            <input type="text" class="hide" name="groupItem" value=""/>
            <div class="panel panel-default m-b-0">
                <div class="panel-body form-horizontal">
                    <div data-optionfilter="heading" class="form-group text-center">
                        <p>This is Dynamic Item Group. All of the items under this group will be displayed in
                            the menu, this will include any new item added automatically</p>
                    </div>
                    <div class="form-group" data-optionfilter="notheading">
                        <label for="edittext" class="col-sm-4 control-label">Item Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edittext" placeholder="Text"
                                   name="title">
                        </div>
                    </div>
                    <div class="form-group" data-optionfilter="notheading">
                        <label for="editcustom-link" class="col-sm-4 control-label">Item URL</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="editcustom-link"
                                   placeholder="http://www.example.com/home" name="url" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editclass" class="col-sm-4 control-label">Apply different Item class</label>
                        <div class="col-sm-8">
                            <input type="checkbox" name="hasclass" value="1">
                        </div>
                    </div>

                    <div class="form-group hide" data-showhide="hasclass">
                        <label for="editclass" class="col-sm-4 control-label">Item class</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="editclass" name="class">
                                <option value="">Select Class</option>
                                <option value="item_class_1">Item Class 1</option>
                                <option value="item_class_2">Item Class 2</option>
                                <option value="item_class_3">Item Class 3</option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group" data-optionfilter="notheading">
                        <label class="col-sm-4 control-label" for="editicon">Icon</label>
                        <div class="col-sm-8 removeindent">
                            <a href="#" class="btn btn-default btn-sm" data-icon="iconbutton">Select Icon</a>
                            <span class="iconView" data-iconSeting="">No Icon</span>
                            <input type="text" name="icon" class="geticonseting">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="editopenNewtab"></label>
                        <div class=" col-sm-8">
                            <input type="checkbox" id="editopenNewtab" name="new_link">
                            Open in new Tab?
                        </div>
                    </div>

                    <p class="text-right p-r-15">
                        <button type="button" class="btn btn-success save-item">Save</button>
                        <button type="button" class="btn btn-default" data-action="cancel">Cancel</button>
                    </p>
                </div>
            </div>
        </form>
    </script>
    {!! Form::textarea('json_data',$data,['data-export' => "json"]) !!}
    <input name="html_data" data-export="html" class="" value=''>
    <input name="id" data-export="ID" type="hidden" value=''>
    {!! Form::close() !!}
@stop
{{--@include('tools::common_inc')--}}
@section('CSS')
    {!! HTML::style('css/create_pages.css') !!}
    {!! HTML::style('css/menu.css?v=0.16') !!}
    {!! HTML::style('css/tool-css.css?v=0.23') !!}
    {!! HTML::style('css/page.css?v=0.15') !!}
    {!! HTML::style('css/admin_pages.css') !!}
    {!! HTML::style('js/tag-it/css/jquery.tagit.css') !!}
    <style>
        .page_labels {
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 10px 0 2px 15px;
            background: #e8e7e7;
            padding: 4px 13px;
            border: 1px solid #d6d2d2;
            font-size: 15px;
        }
    </style>
@stop

@section('JS')
    {!! HTML::script('js/create_pages.js') !!}
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('js/admin_pages.js') !!}
    {!! HTML::script('js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('js/icon-plugin.js?v=0.4') !!}
    {!! HTML::script('js/backend-console-createmenu.js') !!}
    {!! HTML::script('js/tag-it/tag-it.js') !!}
    <script>

        $(document).ready(function () {

            if ($('#tagits').length > 0) {
                var getExt = $('#tagits').data('allwotag').split(',')

                $('#tagits').tagit({
                    availableTags: getExt,
                    // This will make Tag-it submit a single form value, as a comma-delimited field.
                    autocomplete: {delay: 0, minLength: 0},
                    singleField: true,
                    singleFieldNode: $('.tagitext'),
                    beforeTagAdded: function (event, ui) {
                        if (!ui.duringInitialization) {
                            var exis = getExt.indexOf(ui.tagLabel);
                            if (exis < 0) {
                                $('.tagit-new input').val('');
                                //alert('PLease add allow at tag')
                                return false;
                            }
                        }

                    }
                })
            }
            fixbar()

            function fixbar() {
                var targetselector = $('.vertical-text');
                if (targetselector.length > 0) {
                    var getwith = targetselector.width()
                    var left = 0 - getwith / 2 - 15;
                    targetselector.css({'left': left, 'top': getwith / 2})
                }
            }

            var id;
            $("body").on('click', '[data-pagecolid]', function () {
                id = $(this).data('pagecolid');
                $.ajax({
                    url: '/admin/modules/gears/admin-pages-layout',
                    data: {id: id},
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
                            $('.page_layout').val(data.value);
                            $('.page_name').val(data.page_name);
                            $('.page_address').html(data.page_url);
                            $('.page-date').html(data.page_date);
                            //apply content
                            var applyC = $(".apply_contents").attr('href');
                            if (applyC) {
                                var res = applyC.split('/');

                                res[res.length - 1] = data.page_id + "?pl=" + data.value;
                                res = res.join('/');

                                $(".apply_contents").attr('href', res);
                            }
                        }
                    },

                });
            });
            $("body").on('click', '.save_btn', function () {
                $.ajax({
                    url: '/admin/backend/build/admin-pages/change-layout',
                    data: {id: id, layout_id: $('.page_layout').val()},
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {

                        }
                    },

                });
            });

            $("body").on('change', '.page_layout', function () {
                var layoutID = $(this).val();
                var applyC = $(".apply_contents").attr('href');
                var res = applyC.split('/');
                var last = res[res.length - 1];

                var page = last.substring(-1, last.indexOf('?'));

                res[res.length - 1] = page + "?pl=" + layoutID;
                res = res.join('/');

                $(".apply_contents").attr('href', res);
            });

            $("body").on('click', '.add-new-adminpage', function () {
                $('#adminpage').modal();
            });

            $("body").on('click', '.module-info', function () {
                var id = $(this).attr('data-module');
                var item = $(this).find("i");
                $.ajax({
                    url: '/admin/backend/build/admin-pages/module-data',
                    data: {id: id},
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('.module-info-panel').html('');
                        item.removeClass('fa-info-circle');
                        item.addClass('fa-refresh');
                        item.addClass('fa-spin');
                    },
                    success: function (data) {
                        item.removeClass('fa-refresh');
                        item.removeClass('fa-spin');
                        item.addClass('fa-info-circle');
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        }
                    },
                    type: 'POST'
                });
            });

            $("body").on('click', '.view-url', function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/admin/backend/build/admin-pages/pages-data',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('.module-info-panel').html('');
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        }
                    },
                    type: 'POST'
                });
            });
        });
    </script>
@stop