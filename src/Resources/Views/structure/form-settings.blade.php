@extends( 'cms::layouts.admin' )
@section( 'content' )
    <div class="row">
        {!! Form::model($form,['class' => 'form-horizontal']) !!}
        <div class="form-group m-l-0 m-r-0">
            <label for="success_message" class="col-sm-4 ">Form type</label>
            <div class="col-sm-8">
                {!! Form::select('form_type',['admin' => 'Admin','user' => 'User'],null,['class' => 'form-control form_type']) !!}
            </div>
        </div>

        <div class="form-group m-l-0 m-r-0">
            <label for="success_message" class="col-sm-4 ">Table</label>
            <div class="col-sm-8">
                {!! Form::select('fields_type',BBGetTables(),null,['class' => 'form-control fields_type']) !!}
            </div>
        </div>

        <div class="form-group m-l-0 m-r-0">
            <label for="success_message" class="col-sm-4 ">Success Message</label>
            <div class="col-sm-8">
                {!! Form::text('message',(isset($settings['message'])) ? $settings['message'] : null ,['class' =>'form-control']) !!}
            </div>
        </div>

        <div class="form-group m-l-0 m-r-0">
            <label for="success_message" class="col-sm-4 ">Event/Trigger</label>
            <div class="col-sm-8">
                {!! Form::select('event',['' => 'Select Event'] + \Subscriber::getEvents(true), (isset($settings['event'])) ? $settings['event'] : null ,['class' =>'form-control']) !!}
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
                <div class="customelement radio-inline">
                    <input name="is_ajax" id="is_ajax_yes" <?php echo (isset($settings['is_ajax']) && $settings['is_ajax'] == 'yes') ? 'checked' : '' ?> value="yes" type="radio">
                    <label for="is_ajax_yes">Yes</label>
                </div>
                <div class="customelement radio-inline"><input name="is_ajax" id="is_ajax_no" <?php echo (isset($settings['is_ajax'])
                        && $settings['is_ajax'] == 'no') ? 'checked' : (isset($settings['is_ajax']) && $settings['is_ajax'] == 'yes') ? '' : 'checked' ?>
                                                               value="no" type="radio"> <label
                            for="is_ajax_no">No</label>
                </div>
            </div>
        </div>
		<div class="form-group m-l-0 m-r-0">
			<label for="" class="col-sm-4"></label>	
			<div class="col-sm-4 p-10">
				<div class="panel panel-default custompanel ">
				  <div class="panel-heading">Available Fields</div>
				  <div class="panel-body">
				  		<ul class="list-group" data-sortables="avalable"  style="min-height: 200px;">
				  			 @if(count($fields))
                      			  @foreach($fields as $field)
				  						<li class="list-group-item"> {!! $field->name !!}</li>
									 @endforeach
							@endif
				  		</ul>
				  	
				  </div>
				</div>
				
			</div>
			<div class="col-sm-4  p-10">
				<div class="panel panel-default custompanel ">
				  <div class="panel-heading">Used Fields</div>
				  <div class="panel-body">
				  		<ul class="list-group" data-sortables="usedfield" style="min-height: 200px;">
				  			
					  	</ul>
				  	
				  	
				  </div>
				</div>
			</div>
			
		</div>
        <div>
            {!! Form::submit('Save',['class' => 'btn btn-success']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    @include('resources::assests.magicModal')
@stop
@section( 'CSS' )

    {!!HTML::style( '/resources/assets/css/create_pages.css' ) !!}
       {!!HTML::style( '/resources/assets/css/form-builder.css?v=4.89' ) !!}
    {!! HTML::style("resources/assets/js/select2/css/select2.css") !!}
@stop


@section( 'JS' )
    {!! HTML::script("resources/assets/js/select2/js/select2.js") !!}
    <script>

        $(document).ready(function () {
            $('body').on('change','.fields_type',function () { 
                var table = $(this).val();

                $.ajax({
                    url: "/admin/console/structure/forms/get-available-fields-settings",
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {table:table},
                    success: function (data) {
                        if (!data.error) {
                            $('.available-fields').html(data.html);
                        }
                    }
                })
            })
        })

			$(function(){
					$('[data-sortables="avalable"]').sortable({
						connectWith: '[data-sortables="usedfield"]',
					   forcePlaceholderSize: true,
					   forceHelperSize: true,
					   tolerance: "pointer",
			 			placeholder: "ui-state-highlight  list-group-item",
					   start: function(event, ui){
						   //getlnt = $('.target  > [data-id]').length;
							//$(ui.item).width($('.source li').width());
					   }
					}).disableSelection();
				
					$('[data-sortables="usedfield"]').sortable({
						connectWith: '[data-sortables="avalable"]',
					   forcePlaceholderSize: true,
					   forceHelperSize: true,
					   tolerance: "pointer",
			 			placeholder: "ui-state-highlight  list-group-item",
					   start: function(event, ui){
						   //getlnt = $('.target  > [data-id]').length;
							//$(ui.item).width($('.source li').width());
					   }
					}).disableSelection();
				
			})

    </script>
@stop