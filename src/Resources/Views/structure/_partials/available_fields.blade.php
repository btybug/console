<div class="form-group m-l-0 m-r-0">
    <label for="" class="col-sm-4">Available Fields</label>

    <div class="col-sm-8">
        <table class="table">
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Options
                </th>
            </tr>
            @if(count($fields))
                @foreach($fields as $field)
                    <tr>
                        <th>
                            {!! $field->name !!}
                        </th>
                        <th>
                            {!! Form::select('field_required',['' => 'Select','required' => 'Required','not-required' => 'Not Required'],null,['class' =>'']) !!}
                            {!! Form::select('field_type',['' => 'Select','normal' => 'Normal','hidden' => 'Hidden'],null,['class' =>'']) !!}
                        </th>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>