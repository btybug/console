@extends( 'cms::layouts.admin' )
@section( 'content' )
    <div class="row">
        <div class="col-xs-12 ">
            {!! Form::model($form,['url' => '/admin/console/structure/forms/edit/'.$form->id, 'id'=>'formbuilderfrom']) !!}
            <div class="row m-b-15 ">
                <section class="content">
                    <div class="row toolbarNav  zindex9999">
                        <div class="col-md-8 p-b-10">
                            <label>Select HTML For
                                Form</label> {!! Form::select('form_builder', $builders , null,['class'=>'select-builder', 'data-btnrole'=>'formtype', 'title'=>'Select Builder']) !!}
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="btn btn-default btn-dblue m-r-5" data-action="setting"><i
                                        class="fa fa-cog"
                                        aria-hidden="true"></i>
                                Setting
                            </button> {{ Form::button('<i class="fa fa-check" aria-hidden="true"></i> Save', array('type' => 'submit', 'class' => 'btn btn-danger')) }}
                        </div>
                    </div>
                </section>
            </div>
            <textarea hidden="hidden" name="blade" class="form-control hide"
                      data-formslug="slug"></textarea>
            <textarea hidden="hidden" name="fields" class="form-control hide"
                      data-formfield="field">{!! $fields !!}</textarea> {!! Form::textarea('settings',null,['class' => 'form-control hide','data-formfield' => 'setting']) !!}
            <textarea hidden="hidden" name="blade_rendered" class="form-control hide"
                      data-formslug="bladerendered"></textarea>
           {!! Form::close() !!}
            
            <div data-formslug="slug" class="hide">
                @if(! \Request::exists('slug'))
                    {!! $blade !!}
                @endif
            </div>
            <div data-formslug="bladerendered" class="hide">
                @if(! \Request::exists('slug'))
                    {!! $bladeRendered !!}
                @endif
            </div>

            <div data-installbuilder>
                @if($file)
                    {!! $file !!}
                @endif
            </div>


            <input type="hidden" id="current_form_group_value" value="{!!  $form->fields_type !!}"/>
            <input type="hidden" id="current_form_id" value="{!! $form->id !!}"/>
        </div>
        <div id="settingModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Setting Modal</h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" class="form-horizontal " data-setting="builder">
                            <div class="form-group m-l-0 m-r-0">
                                <label for="success_message" class="col-sm-4 ">Success Message</label>
                                <div class="col-sm-8">
                                    <input class="form-control " placeholder="Custom" name="message"
                                           id="success_message" type="text">
                                </div>
                            </div>

                            <div class="form-group m-l-0 m-r-0">
                                <label for="" class="col-sm-4">Redirect Page</label>
                                <div class="col-sm-8">
                                    <select id="target" class="form-control" name="redirect_Page" title="Select Target">
                                        <option value="alert">BB get page</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group m-l-0 m-r-0">
                                <label for="" class="col-sm-4">Is Ajax</label>

                                <div class="col-sm-8">
                                    <div class="customelement radio-inline"><input name="is_ajax" id="is_ajax_yes"
                                                                                   value="yes" type="radio"> <label
                                                for="is_ajax_yes">Yes</label>
                                    </div>
                                    <div class="customelement radio-inline"><input name="is_ajax" id="is_ajax_no"
                                                                                   value="no" type="radio"> <label
                                                for="is_ajax_no">No</label>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        
        
        <div id="fieldModalcustom" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Fields</h4>
                </div>
                <div class="modal-body" >
               				<textarea name="fieldjson" class="hide">{!! $fieldJson !!}</textarea>
                			<div class="panel panel-default custompanel ">
							  <div class="panel-heading">Available Field</div>
							  <div class="panel-body  p-10">
							  			<div data-setting="fieldgroupcustom"></div>
							  </div>
							</div>
							
              				
               				<div class="panel panel-default custompanel m-t-10">
							  <div class="panel-heading">Used Field</div>
							  <div class="panel-body  p-10">
							  			<div data-setting="fieldgroupcustomused"></div>
							  </div>
							</div>
               				
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
        
    </div>
    @include('resources::assests.magicModal')
@stop
@section( 'CSS' )

    {!!HTML::style( '/resources/assets/css/create_pages.css' ) !!}
    {!!HTML::style( '/resources/assets/js/bootstrap-select/css/bootstrap-select.min.css' ) !!}
    {!!HTML::style( '/resources/assets/css/form-builder.css?v=4.89' ) !!}
    
    {!! HTML::style("/js/select2/css/select2.css") !!}
    <style>
        .btnCtrls {
            position: absolute;
            top: 0px;
            right: 15px;
            display: none;
        }

        .bbfieldpalce:hover .btnCtrls {
            display: block;
        }

        .bbfieldpalce {
            position: relative;
        }
		
		
		
		.zindex9999{ z-index: 10;}

    </style>

@stop


@section( 'JS' )

    {!! HTML::script("js/UiElements/bb_styles.js") !!}

   {!!HTML::script( '/resources/assets/js/bootstrap-select/js/bootstrap-select.min.js' ) !!}
    {!!HTML::script( '/resources/assets/js/underscore-min.js' ) !!}
    {!!HTML::script( '/resources/assets/js/form-setting.js' ) !!}
    
    {!! HTML::script("js/select2/js/select2.js") !!}
    <script>
        $(document).ready(function () {
			
		
			
			
            var allowed_memberships = $('.allowed_memberships').select2({tags: true});
			var allowMeber = $('#allowed_memberships_defaults').val();
			if(allowMeber){
				 var allowed_memberships_defaults = JSON.parse(allowMeber);
				allowed_memberships.val(allowed_memberships_defaults).trigger("change");
			}
           
			$('.select-builder').selectpicker();
            

            $("body").on('click','.allow_membership',function () {
                if($('.allow_membership:checkbox:checked').length > 0){
                    $('.memberships').removeClass('hide');
                }else{
                    $('.memberships').addClass('hide');
                }
            });


            var oldstduio = $('.select-builder').val()

            function savedata(newbuilder) {
                var datafrom = {
                    'new_builder': newbuilder,
                    'form_builder': oldstduio,
                    'blade': $('[data-formslug="slug"]').val(),
                    'fields': $('[data-formfield="field"]').val(),
					'settings': $('[data-formfield="setting"]').val()
                }
                $.ajax({
                    url: $('#formbuilderfrom').attr('url'),
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: datafrom,
                    success: function (data) {
                        if (!data.error) {
                            //here is builder
                           // $('.select-builder').val(newbuilder);
                           // $('[data-installbuilder]').html(data.builder);
							loadbuidler(newbuilder);
                            

                        }
                    }
                });
            }


            $("body").on('change', '.select-builder', function () {
                var nerbuilder = $(this).val();
				var ifnfield = $('[data-formslug="slug"]').val('')
				
				if(oldstduio!=''){
					
					if(ifnfield!=' '){
						
					
						bootbox.confirm({
							message: "You want to keep last changed",
							buttons: {
								confirm: {
									label: 'Yes',
									className: 'btn-success'
								},
								cancel: {
									label: 'No',
									className: 'btn-danger'
								}
							},
							callback: function (result) {
								if (result) {
									//$('.select-builder').val(oldstduio);
									savedata(nerbuilder);


								} else {
									
									oldstduio = nerbuilder;
									loadbuidler(oldstduio);
								}
							}
						});
						}else{
							$('[data-formslug="slug"]').val('')
									
									oldstduio = nerbuilder;
									loadbuidler(oldstduio);
						}
					}else{
						$('[data-formslug="slug"]').val('')
								
									oldstduio = nerbuilder;
									loadbuidler(oldstduio);
					}

            })

            function loadbuidler(builder) {
				var value = builder;
				var url = '?slug='+builder
                var form = "{!! $form->id !!}";
				
				 window.location.assign(url)
				
               /* $('[data-installbuilder] script').remove();
                $('[data-installbuilder]').empty();
                $.ajax({
                    url: "{!! url('/admin/console/structure/forms/get-builder-render') !!}",
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {
                        slug: value,
                        form: form,
                    },
                    success: function (data) {
                        if (!data.error) {
                            //here is builder
                            $('[data-installbuilder]').html(data.builder);
                          

                        }
                    }
                });*/
            }
			
//            loadbuidler(oldstduio);


        })
    </script>
@stop