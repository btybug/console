@extends('layouts.admin')
@section('content')
    <div class="row">
    </div>
    <div class="row toolbarNav m-b-10 p-b-5">
        <div class="col-md-9">
            <div class="form-inline">
                <div class="form-group p-r-10 p-b-5  m-0">
                    <label for="name" class="p-r-10">Urls Coming from {!! $slug !!} Module</label>
                    {{--<input type="text" name="name" class="form-control" data-json="name" value="{!! $menu !!}"/>--}}
                </div>
            </div>
        </div>
        <div class="col-md-3 text-right"> {!! Form::button('Optimize', array('class' => 'btn btn-danger btn-danger-red urls-page-optimization', )) !!} </div>
    </div>

    <div class="row">
        <div class="col-md-4 menu_childs">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <!--Custom Link-->
                <div class="panel panel-darkblack panel-default">
                    <div class="panel-body menujstree" data-jstree="menu" data-nav-drag>
                        {!! $html !!}
                    </div>
                </div>
                <!--Custom Link-->


            </div>
        </div>
        <div class="col-md-7 hide opt-messages">

        </div>
        <div>

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

            <div class="modal fade" tabindex="-1" id="createitem" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Create Item</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="creatname" class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="creatname" name="creatname"
                                               placeholder="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="creaturl" class="col-sm-3 control-label">url</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="creaturl" name="creaturl"
                                               placeholder="url">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="creaticon" class="col-sm-3 control-label">Icon</label>
                                    <div class="col-sm-9">
                                        <a href="#" class="btn btn-default btn-sm" data-icon="iconbutton">Select
                                            Icon</a>
                                        <span class="iconView" data-iconSeting=""><i class="fa fa-road"></i></span>
                                        <input type="text" name="creaticon" class="geticonseting" value="fa fa-road">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Create</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>
    </div>
    {!! Form::hidden(null,$slug,['data-slug']) !!}
@stop
@section('CSS')
    {!! HTML::style('/resources/assets/css/menu.css?v=0.16') !!}
    {!! HTML::style('/resources/assets/css/tool-css.css?v=0.23') !!}
    {!! HTML::style('/resources/assets/css/page.css?v=0.15') !!}
    {!! HTML::style('/resources/assets/css/treeDefoults/style.min.css') !!}
@stop

@section('JS')
    {!! HTML::script('/resources/assets/js/jstree.min.js') !!}
    {!! HTML::script('resources/assets/js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('resources/assets/js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('resources/assets/js/icon-plugin.js?v=0.4') !!}
    <script>
        $(document).ready(function () {
            $('.urls-page-optimization').on('click', function () {
                $('.opt-messages').empty();
                var data = {'slug': $("[data-slug]").val()}
                $.ajax({
                    url: "{!! url('admin/console/modules/urls-pages-optimization') !!}",
                    data: data,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
//                        <div class="alert alert-success">
//                                    <strong>Success!</strong> This alert box could indicate a successful or positive action.
//                            </div>
                            var messages = $('<div/>');
                            var message = $('<div/>', {
                                'class': 'alert'
                            });
                            var strong = $('<strong/>');
                            var p = $('<i/>');
                            $.each(data.messages, function (key, value) {
                                switch (key) {
                                    case 'success':
                                        $.each(value, function (k, v) {
                                            var success = message.clone().addClass('alert-success');
                                            var title = strong.clone().text('Success!');
                                            var text = p.clone().text(k + ":" + v);
                                            messages.append(success.append(title,text));
                                        });
                                        break ;
                                    case 'exist':
                                        $.each(value, function (k, v) {
                                            var success = message.clone().addClass('alert-info');
                                            var title = strong.clone().text('Exist!');
                                            var text = p.clone().text(k + ":" + v);
                                            messages.append(success.append(title,text));
                                        });
                                        break;
                                    case 'warning':
                                        $.each(value, function (k, v) {
                                            var success = message.clone().addClass('alert-danger');
                                            var title = strong.clone().text('Warning!');
                                            var text = p.clone().text(k + ":" + v);
                                            messages.append(success.append(title,text));
                                        });
                                        break;
                                }
                                $('.opt-messages').removeClass('hide');
                                $('.opt-messages').html(messages);

                            });
                        }

                    }

                });
            })
        })
    </script>

    {!! HTML::script('resources/assets/js/backend-buildmenu.js') !!}

@stop

