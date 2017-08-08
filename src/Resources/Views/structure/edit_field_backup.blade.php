@extends('cms::layouts.admin')
@section('content')
    <div class="col-md-12" id="add-new-fields">
        {!! Form::model($field,['url'=>['/admin/console/structure/fields/edit',$field->id],'class' => 'form-horizontal']) !!}
        <div class="col-md-12">  {!! Form::submit('Save',['class' => 'btn btn-success pull-right m-r-25']) !!}</div>
        <div class="col-md-12">
            <h3 class="modal-title m-b-20 text-center" id="myModalLabel">Edit Field</h3>
        </div>
        <div class="row">
            <div class="form-group col-md-6 m-r-0">
                <label class="col-md-3">Field Name</label>
                <div class="col-md-9">
                    @if($field->structured_by == 'custom')
                        {!! Form::text('name',null,['class' => 'form-control ']) !!}
                    @else
                        <div class="form-control" readonly="true" disabled="true"> {!! $field->name !!} </div>
                    @endif

                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="col-md-3">Group</label>
                <div class="col-md-9  p-r-0">
                    @if($field->structured_by == 'custom')
                        {!! Form::select('form_group',['' => 'Select Group'] +BBGetFromGroups(),null,['class' => 'form-control table-change']) !!}
                    @else
                        <div class="form-control" readonly="true" disabled="true"> {!! $field->form_group !!} </div>
                    @endif
                </div>
            </div>

            <div class="form-group col-md-12">
                <div  class="col-md-6">
                    <label class="col-md-3 p-l-0">Saving Target</label>
                    <div class="col-md-9">
                        @if($field->structured_by == 'custom')
                            {!! Form::select('table_name',['' => 'Select table'] +BBGetTables(),null,['class' => 'form-control table-change']) !!}
                        @else
                            <div class="form-control" readonly="true" disabled="true"> {!! $field->table_name !!} </div>
                        @endif

                    </div>
                </div>
                <div class="columns col-md-6 {!! ($field->table_name ) ? '' : 'hide' !!}">
                    {{--<label class="col-md-3">Column Name</label>--}}
                    <div class="col-md-12">
                        @if($field->structured_by == 'custom')
                            {!! Form::select('column_name',BBGetTableColumn($field->table_name ),null,['class' => 'form-control table-columns']) !!}
                        @else
                            <div class="form-control" readonly="true" disabled="true"> {!! $field->column_name !!} </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="form-group col-md-12">
                <div class="col-md-12">
                    <label class="col-md-3 p-l-0">Core Validation</label>
                    <div class="col-md-9">
                        @if($field->structured_by == 'custom')
                            {!! Form::text('validation',null,['class' => 'form-control core-val']) !!}
                        @else
                            <div class="form-control" readonly="true" disabled="true"> {!! $field->validation !!} </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-12">
            <label class="col-md-3">Field Type</label>
            <div class="col-md-9">
                @if($field->structured_by == 'custom')
                    {!! Form::select('type',[null=>'Select Field']+$types,null,['class' => 'form-control field-type']) !!}
                @else
                    <div class="form-control" readonly="true" disabled="true"> {!! $field->type !!} </div>
                @endif

            </div>
        </div>
        <div class="form-group {!! ($field->type) ? '' : 'hide' !!} field-units  col-md-12">
            <label class="col-md-3">Select unit</label>
            <div class="col-md-9">
                {!! Form::select('unit',[null=>'Select unit'] + BBGetUnitsByType($field->type,true),null,['class' => 'form-control field-type-units']) !!}
            </div>
        </div>

        <input type="hidden" name="settings" value="{!! $field->json_data !!}">
        {!! Form::close() !!}
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="minimum_validation" id="field_minimum_validation"/>
            </div>



            <div class="col-md-6 m-b-25 {!! ($unit) ? '' : 'hide' !!} tab-options-area" data-role="optionsetting" id="unit-data">
                {!! Form::model(@json_decode($field->json_data,true)) !!}
                    @if($unit)
                     {!! $unit->renderSettings($field->json_data ? ['settings' =>json_decode($field->json_data,true)] : []) !!}
                    @endif
                {!! Form::close() !!}
            </div>
        </div>

        <div class="col-md-6 live-prev-wrapper">
            <div class="live-preview">
                @if($unit)
                    {!! $unit->render($field->json_data ? ['settings' =>json_decode($field->json_data,true)] : []) !!}
                @endif
            </div>
        </div>

    </div>
    @include('resources::assests.magicModal')



    {{--<div class="tab-options-area hidden">--}}
    {{--<ul class="tabs">--}}
    {{--<li class="tab-link current" data-tab="tab-1">General</li>--}}
    {{--<li class="tab-link" data-tab="options">Options</li>--}}
    {{--<li class="tab-link" data-tab="tab-3">Extra</li>--}}
    {{--</ul>--}}

    {{--<div id="tab-1" class="tab-content current">--}}
    {{--<div class="row">--}}
    {{--<div class="form-group clearfix">--}}
    {{--<label class="col-md-3">Validation</label>--}}
    {{--<div class="col-md-9">--}}
    {{--{!! Form::text('validation',null,['class' => 'form-control']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group clearfix">--}}
    {{--<label class="col-md-3">Allow Guest</label>--}}
    {{--<div class="col-md-9">--}}
    {{--{!! Form::checkbox('allow_guest',1,null,['class' => 'form-control']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group clearfix">--}}
    {{--<label class="col-md-3">Allow Membership</label>--}}
    {{--<div class="col-md-9">--}}
    {{--{!! Form::checkbox('allow_membership',1,null,['class' => 'form-control allow_membership']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group clearfix memberships hide">--}}
    {{--<label class="col-md-3">Select Memberships</label>--}}
    {{--<div class="col-md-9">--}}
    {{--<div class="">--}}
    {{--{!! Form::select('allowed_memberships[]',BBGetMembershipsList(),--}}
    {{--null,['class' => 'form-control allowed_memberships','multiple' => true]) !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group clearfix">--}}
    {{--<label class="col-md-3">Allow Roles</label>--}}
    {{--<div class="col-md-9">--}}
    {{--{!! Form::select('allowed_roles[]',BBGetRolesList(['superadmin']),--}}
    {{--null,['class' => 'form-control allowed_roles','multiple' => true]) !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<label class="col-md-3">Validation</label>--}}
    {{--<div class="col-md-9">--}}
    {{--{!! Form::select('validation',['email','password','url','numeric','alpha','date','ip','custom' => 'Custom'],null,['class' => 'form-control field-validation']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group hide plugin_validations">--}}
    {{--<label class="col-md-3">Custom Validation</label>--}}
    {{--<div class="col-md-9">--}}
    {{--{!! Form::select('custom_validation',['' => 'Select Validation'],null,['class' => 'form-control ']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}






    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="options" class="tab-content" data-role="optionsetting">--}}

    {{--</div>--}}
    {{--<div id="tab-3" class="tab-content">--}}
    {{--<div class="col-md-12  m-t-15 m-b-15">--}}
    {{--{!! BBbutton('units',"unit",'Select unit',[--}}
    {{--'class'=>'select_style input-md btn btn-info form-control select-meta-unit',--}}
    {{--"data-type" => 'backend',--}}
    {{--'data-except' => json_encode([],true),--}}
    {{--'data-sub' => "fields"--}}
    {{--]) !!}--}}
    {{--</div>--}}
    {{--<div class="col-md-12 validation-preview">--}}

    {{--</div>--}}
    {{--<div class="form-group col-md-12 m-r-0">--}}
    {{--<label class="col-md-3">Field label</label>--}}
    {{--<div class="col-md-4 m-l-10">--}}
    {{--{!! Form::text('label',null,['class' => 'form-control ']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group col-md-12 m-r-0">--}}
    {{--<label class="col-md-3">Field icon</label>--}}
    {{--<div class="col-md-4 m-l-10">--}}
    {{--<button type="button" class="btn btn-info form-control">Select Icon</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group col-md-12 m-r-0">--}}
    {{--<label class="col-md-3">Placeholder</label>--}}
    {{--<div class="col-md-4 m-l-10">--}}
    {{--{!! Form::text('placeholder',null,['class' => 'form-control ']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group col-md-12 m-r-0">--}}
    {{--<label class="col-md-3">Tooltip icon</label>--}}
    {{--<div class="col-md-4 m-l-10">--}}
    {{--<button type="button" class="btn btn-info form-control">Select Icon</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group col-md-12 m-r-0">--}}
    {{--<label class="col-md-3">Tooltip message</label>--}}
    {{--<div class="col-md-4 m-l-10">--}}
    {{--{!! Form::textarea('tooltip_message',null,['class' => 'form-control ']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--</div>--}}
    {{--</div>--}}

@endsection
@section('CSS')
    <style>
        .validation-preview {
            height: 25px;
            border: 1px solid #ffaa36;
            color: #0A246A;
            font-size: 18px;
            text-align: center;
            margin-bottom: 15px;
        }
        ul.tabs{
            margin: 0px;
            padding: 0px;
            list-style: none;
        }
        ul.tabs li{
            background: none;
            color: #222;
            display: inline-block;
            padding: 10px 15px;
            cursor: pointer;
        }

        ul.tabs li.current{
            background: #ededed;
            color: #222;
        }

        .tab-content{
            display: none;
            padding: 15px;
        }

        .tab-content.current{
            display: inherit;
        }
        #add-new-fields{
            position: relative;
        }
        .live-prev-wrapper{
            position: absolute;
            top: 300px;
            right: -28px;
        }
        .live-preview{
            min-height: 247px;
            border: 1px solid #d0d1d3;
            padding: 20px;
            width: 90%;
            margin: 0 auto;
        }
    </style>
@stop
@section('JS')
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    <script>
        var dd = console.log;
        $(document).ready(function () {
            $("body").on('click','.allow_membership',function () {
                if($('.allow_membership:checkbox:checked').length > 0){
                    $('.memberships').removeClass('hide');
                }else{
                    $('.memberships').addClass('hide');
                }
            });

            $('ul.tabs li').click(function(){
                var tab_id = $(this).attr('data-tab');

                $('ul.tabs li').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#"+tab_id).addClass('current');
            });

            var elements = {
                checkbox: function (data, name, with_key) {
                    $('.additional-data').removeClass('hide');
                    $('[data-tab=tab-2]').click();
                    var text = '<div class="form-group"><label class="col-md-4 control-label" for="checkboxes"></label><div class="col-md-4">';
                    $.each(data, function (k, v) {
                        if(typeof with_key != "undefined" && with_key ==true){
                            text += '<div class="radio"><label><input type="radio" name="' + name + '" value="' + k + '">' + v + ' </label></div>';
                        }else{
                            text += '<div class="radio"><label><input type="radio" name="' + name + '" value="' + v + '">' + v + ' </label></div>';
                        }

                    })
                    text += '</div></div>';
                    return text;
                },
                radio: function (data, name,  with_key) {
                    $('.additional-data').removeClass('hide');
                    $('[data-tab=tab-2]').click();
                    var text = '<div class="form-group"><label class="col-md-4 control-label" for="checkboxes"></label><div class="col-md-4">';
                    $.each(data, function (k, v) {
                        if(typeof with_key != "undefined" && with_key ==true){
                            text += '<div class="checkbox"><label ><input type="checkbox" name="' + name + '"  value="' + k + '">' + v + ' </label></div>';
                        }else{
                            text += '<div class="checkbox"><label ><input type="checkbox" name="' + name + '"  value="' + v + '">' + v + ' </label></div>';
                        }

                    })
                    text += '</div></div>';
                    return text;
                },
                select: function (data, name, with_key) {
                    $('.additional-data').removeClass('hide');
                    $('[data-tab=tab-2]').click();
                    var text = '<div class="form-group"><label class="col-md-4 control-label" ></label><div class="col-md-4"><select  name="' + name + '" class="form-control">';
                    $.each(data, function (k, v) {
                        if(typeof with_key != "undefined" && with_key ==true){
                            text += ' <option value="' + k + '">' + v + '</option>';
                        }else{
                            text += ' <option value="' + v + '">' + v + '</option>';
                        }
                    });
                    text += '</select></div></div>';
                    return text;
                },
                multy_select: function (data, name,  with_key) {
                    $('.additional-data').removeClass('hide');
                    var text = '<div class="form-group"><label class="col-md-4 control-label" ></label><div class="col-md-4"><select  name="' + name + '"multiple="multiple" class="form-control">';
                    $.each(data, function (k, v) {
                        if(typeof with_key != "undefined" && with_key ==true){
                            text += ' <option value="' + k + '">' + v + '</option>';
                        }else{
                            text += ' <option value="' + v + '">' + v + '</option>';
                        }
                    });
                    text += '</select></div></div>';
                    return text;
                },
                text: function (data, name,  with_key) {

                    $('.additional-data').addClass('hide');
                    return '<div class="form-group"><label class="col-md-4 control-label" for="textinput"></label><div class="col-md-4"><input id="textinput" name="textinput" type="text" class="form-control input-md"></div></div>';
                },
                textarea: function (data, name,  with_key) {
                    $('.additional-data').addClass('hide');
                    return '<div class="form-group"><label class="col-md-4 control-label" for="textarea"></label><div class="col-md-4"><textarea class="form-control" id="textarea" name="textarea"></textarea> </div> </div>';
                }
            }


            function sendajaxvar(url, data, success) {
                $.ajax({
                    type: "post",
                    datatype: "json",
                    url: url,
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (success) {
                            success(data);
                        }
                        return data;
                    }
                });
            }

            var table;
            $("body").on('change', '.table-change', function () {
                var value = $(this).val();
                if (value != '') {
                    table = value;
                    var data = {}
                    data['table'] = value;
                    sendajaxvar('/admin/modules/bburl/get-table-columns', data, function (d) {
                        if (d) {
                            var option = ''
                            $('.table-columns').empty()
                            $.each(d, function (k, v) {
                                option += '<option value="' + k + '">' + v + '</option>';

                            })

                            $('.table-columns').append(option);
                            $('.columns').removeClass('hide')
                        }
                    })
                }
            });
            $("body").on('change', '.table-columns', function () {
                var data = {
                    'table': table,
                    'column': $(this).val()
                }
                sendajaxvar('/admin/modules/bburl/get-column-rules', data, function (d) {
                    if (d) {
                        $('.core-val').val(d);
                    }
                })
            });

            var input_type;
            $("body").on('change', '.field-type', function () {
                var value = $(this).val();
                console.log(value)
                if(typeof value != "undefined" && value != ''){
                    $('.tab-options-area').removeClass('hidden');
                    $('.live-preview').removeClass('hidden');

                    var data = {value : value}
                    sendajaxvar('/admin/modules/bburl/get-field-units', data, function (d) {
                        if (d) {
                            var option;
                            $('.field-type-units').empty();
                            option = '<option value="">Select Option</option>';
                            $.each(d.data, function (k, v) {
                                option += '<option value="' + k + '">' + v + '</option>';
                            });

                            $('.field-type-units').append(option);
                            $('.field-units').removeClass('hide')
                        }
                    })
                }else{
                    $('.field-units').addClass('hide');
                    $('.tab-options-area').addClass('hidden');
                    $('.live-preview').addClass('hidden');
                }
            });

            $("body").on('change', '.field-type-units', function () {
                var value = $(this).val();
                if(typeof value != "undefined" && value != ''){
                    var data = {value : value}
                    sendajaxvar('/admin/modules/bburl/get-field-unit', data, function (d) {
                        if (! d.error) {
                            $('.live-preview').html(d.html);
                            $('#unit-data').html(d.options);
                            $('#unit-data').removeClass('hide');
                            getoptiondata('noajax')
                        }
                    })
                }
            });
//            $('form').on('input', 'input[name=name]', function () {
//                var name = $(this).val();
//                if ($.isFunction(elements[input_type])) {
//                    var name = $('input[name=name]').val();
//                    $('.live-preview').html(elements[input_type]($('#data-source').val().split(","), name));
//                }
//            });

//            $('#data-source').on('input', function () {
//                var res = $(this).val().split(",");
//                var name = $('input[name=name]').val();
//                if ($.isFunction(elements[input_type])) {
//                    $('.live-preview').html(elements[input_type](res, name))
//                }
//
//            })

//            $("body").on('change', '.select-file-dropdown', function () {
//                var key = $('.file-key').val();
//                var value = $('.file-value').val();
//                var id = $('[data-name="file"]').val();
//                if (typeof key != "undefined" && typeof value != "undefined"
//                    && typeof id != "undefined" && key != '' && value != '' && id != '') {
//                    var data = {key : key, value : value, id : id};
//                    sendajaxvar('/admin/modules/bburl/get-file-list', data, function (d) {
//                        if(! d.error){
//                            var type = $('.field-type').val();
//                            var name = $('input[name=name]').val();
//
//                            if ($.isFunction(elements[type])) {
//                                $('.live-preview').html(elements[type](d.data, name,true))
//                            }
//                        }
//                    });
//                }
//            });

//            $("body").on('click', '.file-item-dynamic', function () {
//                var value = $(this).find('[data-value]').data('value');
//                var data = {value: value};
//                sendajaxvar('/admin/modules/bburl/get-file-data', data, function (d) {
//                    if (d) {
//                        var option;
//                        $('.file-key').empty();
//                        $('.file-value').empty();
//                        option = '<option value="">Select Option</option>';
//                        $.each(d.data, function (k, v) {
//                            option += '<option value="' + k + '">' + v + '</option>';
//                        });
//
//                        $('.file-key').append(option);
//                        $('.file-value').append(option);
//                        $('.file-data').removeClass('hide')
//                    }
//                })
//            })

            function getoptiondata (noajax){
                var optiondata = {};
                optiondata['options'] = {}
                $('[data-role="optionsetting"] select[name], [data-role="optionsetting"] input[name], [data-role="optionsetting"] textarea[name]').each(function(){
                    var name = $(this).attr('name');
                    if($(this).is('[type="radio"]')){
                        var	value = $('[data-role="optionsetting"] input[name="'+name+'"][type="radio"]:checked').val();
                    }else{
                        var	value = $(this).val();
                    }
                    optiondata['options'][name]= value;
                })



                optiondata['value'] = $('select[name="unit"]').val();
                $('[name="settings"]').val(JSON.stringify(optiondata['options']));
                if(!noajax){
                    sendajaxvar('/admin/modules/bburl/get-field-unit', optiondata, function (d) {
                        if (d) {
                            $('.live-preview').html(d.html);
                        }
                    })
                }
            }

            $('[data-role="optionsetting"]').on('change', 'select,   [type="checkbox"], [type="radio"]', function(){
                getoptiondata ()

            }).on('keyup', 'input, textarea', function(){
                getoptiondata ()

            })




            $('body').on('change','.field-validation', function () {
                var value = $(this).val();
                if(typeof value != "undefined" && value =='custom'){
                    $('.plugin_validations').removeClass('hide');
                }else{
                    $('.plugin_validations').addClass('hide');
                }
            })

        });
    </script>
@endsection