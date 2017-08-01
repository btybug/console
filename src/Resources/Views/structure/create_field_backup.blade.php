@extends('cms::layouts.admin')
@section('content')
    <div class="col-md-12" id="add-new-fields">
        {!! Form::open(['url'=>'/admin/console/structure/fields/new','class' => 'form-horizontal']) !!}
        <div class="col-md-12">  {!! Form::submit('Create',['class' => 'btn btn-success pull-right m-r-25']) !!}</div>
        <div class="col-md-12">
            <h3 class="modal-title m-b-20 text-center" id="myModalLabel">Create New Field</h3>
        </div>
        <div class="row">
            <div class="form-group col-md-6 m-r-0">
                <label class="col-md-3">Field Name</label>
                <div class="col-md-9">
                    {!! Form::text('name',null,['class' => 'form-control ']) !!}
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="col-md-3">Group</label>
                <div class="col-md-9  p-r-0">
                    {!! Form::select('form_group',['' => 'Select Group'] +BBGetFromGroups(),null,['class' => 'form-control table-change']) !!}
                </div>
            </div>

            <div class="form-group col-md-12">
                <div class="col-md-6">
                    <label class="col-md-3 p-l-0">Saving Target</label>
                    <div class="col-md-9">
                        {!! Form::select('table_name',['' => 'Select table'] +BBGetTables(),null,['class' => 'form-control table-change']) !!}
                    </div>
                </div>
                <div class="columns hide col-md-6">
                    {{--<label class="col-md-3">Column Name</label>--}}
                    <div class="col-md-12">
                        {!! Form::select('column_name',[],null,['class' => 'form-control table-columns get-table-rules']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-md-12">
                <div class="col-md-12">
                    <label class="col-md-3 p-l-0">Core Validation</label>
                    <div class="col-md-9">
                        {!! Form::text('validation',null,['class' => 'form-control core-val']) !!}
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group col-md-12">
            <label class="col-md-3">Field Type</label>
            <div class="col-md-9">
                {!! Form::select('type',[null=>'Select Field']+$types,null,['class' => 'form-control field-type']) !!}
            </div>
        </div>
       
        <div class="form-group hide field-units  col-md-12">
            <label class="col-md-3">Select unit</label>
            <div class="col-md-9">
                {!! Form::select('unit',[null=>'Select unit']+$types,null,['class' => 'form-control field-type-units']) !!}
            </div>
        </div>


        <input type="hidden" name="settings">
        <input type="text" class="hide" data-fieldtype="form" name="fieldhtmltype" value="no">
        <input type="text" class="hide" data-fieldtype="formdefutl" name="custom_field_html" value="no">
        
        {!! Form::close() !!}
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="minimum_validation" id="field_minimum_validation"/>
            </div>


            <div class="col-md-6 m-b-25 hide tab-options-area" data-role="optionsetting" id="unit-data">

            </div>
        </div>

        <div class="col-md-6 live-prev-wrapper">
          	 <div class="row hidden" data-previewoption>
           	 <div class="form-group col-sm-12">
				<label class="col-sm-3">Field Html</label>
				<div class="col-sm-6">
					<div class="for_button_1 ">
						<select class="form-control" name="fieldhtmltype" data-selectcustomfield>
							<option value="no">No Html</option>
							<option value="default">default html</option>
							<option value="custom">custom html</option>
						</select>
					</div>
				</div>
				<div class="col-sm-3" data-selectcustomfieldhtml="custom">
						{!! BBbutton('units','default_field_html','Select Field Html',[
							'class' => 'form-control input-md btn-success',
							"data-type" => 'frontend',
							'data-sub' => "component",
							'model' => $defaultFieldHtml->val
						]) !!}
				 </div>
			</div>
			
			</div>
            <div class="m-b-20 live-preview hidden"></div>
            <div class=" hidden" data-previewoption="" data-fieldsetting="setting">
            	
            </div>
        </div>

    </div>
    @include('resources::assests.magicModal')
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

        ul.tabs {
            margin: 0px;
            padding: 0px;
            list-style: none;
        }

        ul.tabs li {
            background: none;
            color: #222;
            display: inline-block;
            padding: 10px 15px;
            cursor: pointer;
        }

        ul.tabs li.current {
            background: #ededed;
            color: #222;
        }

        .tab-content {
            display: none;
            padding: 15px;
        }

        .tab-content.current {
            display: inherit;
        }

        #add-new-fields {
            position: relative;
        }

        .live-prev-wrapper {
            position: absolute;
            top: 450px;
            right: -28px;
        }

        .live-preview {
            min-height: 247px;
            border: 1px solid #d0d1d3;
            padding: 20px;
            width: 90%;
            margin: 0 auto;
        }
    </style>
@stop
@section('JS')
    {!! HTML::script("resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    <script>
        var dd = console.log;
		var activefieldtype = ''
		var htmlsdata = {default:'', custom:'' , field:''}
		
        $(document).ready(function () {

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

            $("body").on('click', '.allow_membership', function () {
                if ($('.allow_membership:checkbox:checked').length > 0) {
                    $('.memberships').removeClass('hide');
                } else {
                    $('.memberships').addClass('hide');
                }
            });

            $('ul.tabs li').click(function () {
                var tab_id = $(this).attr('data-tab');

                $('ul.tabs li').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            });

            var elements = {
                checkbox: function (data, name, with_key) {
                    $('.additional-data').removeClass('hide');
                    $('[data-tab=tab-2]').click();
                    var text = '<div class="form-group"><label class="col-md-4 control-label" for="checkboxes"></label><div class="col-md-4">';
                    $.each(data, function (k, v) {
                        if (typeof with_key != "undefined" && with_key == true) {
                            text += '<div class="radio"><label><input type="radio" name="' + name + '" value="' + k + '">' + v + ' </label></div>';
                        } else {
                            text += '<div class="radio"><label><input type="radio" name="' + name + '" value="' + v + '">' + v + ' </label></div>';
                        }

                    })
                    text += '</div></div>';
                    return text;
                },
                radio: function (data, name, with_key) {
                    $('.additional-data').removeClass('hide');
                    $('[data-tab=tab-2]').click();
                    var text = '<div class="form-group"><label class="col-md-4 control-label" for="checkboxes"></label><div class="col-md-4">';
                    $.each(data, function (k, v) {
                        if (typeof with_key != "undefined" && with_key == true) {
                            text += '<div class="checkbox"><label ><input type="checkbox" name="' + name + '"  value="' + k + '">' + v + ' </label></div>';
                        } else {
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
                        if (typeof with_key != "undefined" && with_key == true) {
                            text += ' <option value="' + k + '">' + v + '</option>';
                        } else {
                            text += ' <option value="' + v + '">' + v + '</option>';
                        }
                    });
                    text += '</select></div></div>';
                    return text;
                },
                multy_select: function (data, name, with_key) {
                    $('.additional-data').removeClass('hide');
                    var text = '<div class="form-group"><label class="col-md-4 control-label" ></label><div class="col-md-4"><select  name="' + name + '"multiple="multiple" class="form-control">';
                    $.each(data, function (k, v) {
                        if (typeof with_key != "undefined" && with_key == true) {
                            text += ' <option value="' + k + '">' + v + '</option>';
                        } else {
                            text += ' <option value="' + v + '">' + v + '</option>';
                        }
                    });
                    text += '</select></div></div>';
                    return text;
                },
                text: function (data, name, with_key) {

                    $('.additional-data').addClass('hide');
                    return '<div class="form-group"><label class="col-md-4 control-label" for="textinput"></label><div class="col-md-4"><input id="textinput" name="textinput" type="text" class="form-control input-md"></div></div>';
                },
                textarea: function (data, name, with_key) {
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
			
			function getajaxvar(url, data, success) {
                $.ajax({
                    type: "GET",
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


            var input_type;
            $("body").on('change', '.field-type', function () {
                var value = $(this).val();
                console.log(value)
                if (typeof value != "undefined" && value != '') {
                    $('.tab-options-area').removeClass('hidden');
                    $('.live-preview').removeClass('hidden');
					$('[data-previewoption]').removeClass('hidden');

                    var data = {value: value}
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
                } else {
                    $('.field-units').addClass('hide');
                    $('.tab-options-area').addClass('hidden');
                    $('.live-preview').addClass('hidden');
					$('[data-previewoption]').addClass('hidden');
                }
            });

            $("body").on('change', '.field-type-units', function () {
                var value = $(this).val();
                if (typeof value != "undefined" && value != '') {
                    var data = {value: value}
                    sendajaxvar('/admin/modules/bburl/get-field-unit', data, function (d) {
                        if (!d.error) {
							htmlsdata['field'] = d.html
                            htmlpreview()
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

            function getoptiondata(noajax) {
                var optiondata = {};
                optiondata['options'] = {}
                $('[data-role="optionsetting"] select[name], [data-role="optionsetting"] input[name], [data-role="optionsetting"] textarea[name]').each(function () {
                    var name = $(this).attr('name');
                    if ($(this).is('[type="radio"]')) {
                        var value = $('[data-role="optionsetting"] input[name="' + name + '"][type="radio"]:checked').val();
                    } else {
                        var value = $(this).val();
                    }
                    optiondata['options'][name] = value;
                })


                optiondata['value'] = $('select[name="unit"]').val();
                $('[name="settings"]').val(JSON.stringify(optiondata['options']));
                if (!noajax) {
                    sendajaxvar('/admin/modules/bburl/get-field-unit', optiondata, function (d) {
                        if (d) {
                           htmlsdata['field'] = d.html;
							htmlpreview()
                        }
                    })
                }
            }

            $('[data-role="optionsetting"]').on('change', 'select,   [type="checkbox"], [type="radio"]', function () {
                getoptiondata()

            }).on('keyup', 'input, textarea', function () {
                getoptiondata()

            })


            $('body').on('change', '.field-validation', function () {
                var value = $(this).val();
                if (typeof value != "undefined" && value == 'custom') {
                    $('.plugin_validations').removeClass('hide');
                } else {
                    $('.plugin_validations').addClass('hide');
                }
            })
			
			function htmlpreview (){
				$('[data-fieldsetting="setting"]').html('')
				if(htmlsdata[activefieldtype]){
					var htmlsfidl = $('<div></div>')
					htmlsfidl.html(htmlsdata[activefieldtype].html)
					if(htmlsdata['field']){
						htmlsfidl.find('[data-fcontrol="input"]').html(htmlsdata['field'])
					}
					if(htmlsdata[activefieldtype].settings){
						$('[data-fieldsetting="setting"]').html(htmlsdata[activefieldtype].settings)
					}
					$('.live-preview').html(htmlsfidl.html());
				}else{
					$('.live-preview').html(htmlsdata['field']);
				}
			}
			
			function selecthtmls (){
				var gethtmlv = $('[data-selectcustomfield]').val()
				
				$('[data-fieldtype="form"]').val(gethtmlv)
				activefieldtype = gethtmlv
				$('[data-selectcustomfieldhtml]').addClass('hide')
				$('[data-selectcustomfieldhtml="'+gethtmlv+'"]').removeClass('hide')
				htmlpreview ()
			}
			
			var fieldhtmlsty = $('[data-fieldtype="form"]').val()
			
			$('[data-selectcustomfield]').val(fieldhtmlsty)
			selecthtmls ()
			
			$('[data-selectcustomfield]').change(function(){
				selecthtmls()
			})
			
			$('body').on('click', '.item-unit[data-key="default_field_html"]', function(){
				var gtid = $(this).find('input').data('value')
				$('[data-fieldtype="formdefutl"]').val(gtid)
				var data = {'slug':gtid}
				sendajaxvar('/admin/console/structure/get-custom-html', data, function (d) {
					if(d){
						htmlsdata['custom'] = d;
						 htmlpreview ()
					}
				});
			})
			
			getajaxvar('/admin/console/structure/get-default-html', {}, function (d) {
					if(d){
						htmlsdata['default'] = d;
					}
				});

        });
    </script>
@endsection