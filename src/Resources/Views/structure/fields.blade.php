@extends('layouts.mTabs',['index'=>'structure_console'])
@section('tab')
    <div class="row m-b-10">
        <h3>All Fields</h3>
        <div class="col-md-12">
            <a href="{!! url('/admin/console/structure/fields/create') !!}" class="btn btn-primary"><i class="fa fa-plus"></i> Create New</a>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-black text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Created By</th>
                    <th>Table</th>
                    <th>Column</th>
                    <th>Validation</th>
                    <th>Input</th>
                    <th>Field HTML</th>
                    <th>Shortcode</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="field_list">
                @if(count($fields))
                    @foreach($fields as $count => $field)
                        <tr class="field-row">
                            <td>{!! $field->id !!}</td>
                            <td> {!! $field->name !!}</td>
                            <td> {!! BBGetUser($field->created_by,'username') !!}</td>
                            <td> {!! $field->table_name !!}</td>
                            <td> {!! $field->column_name !!}</td>
                            <td> {!! $field->validation !!}</td>
                            <td class="field-unit-column">
                                {!! $field->getFieldSelectedUnitName() !!}
                            </td>
                            <td class="field-unit-column">
                                {!! $field->getFieldSelectedHTMLUnitName() !!}
                            </td>
                            <td>{!!"[field slug=$field->slug]"!!}</td>
                            <td>
                                <input type="checkbox" @if($field->status){!! 'checked' !!} @endif data-toggle="toggle" data-slug="{!! $field->slug !!}" class="field-status" data-url="{!! url('/admin/console/structure/fields/change-status') !!}">

                                    <a href="{!! url('/admin/console/structure/fields/edit',[$field->id]) !!}" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                @if($field->structured_by == 'custom')
                                    <a data-href="{!! url('/admin/modules/tables/field/delete') !!}" data-key="{!! isset($field) && isset($field->id) ? $field->id : '' !!}" data-type="Field"
                                       class="{!! isset($field) && isset($field->id) ? 'delete-button' : 'delete-new-field' !!} btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    @include('resources::assests.magicModal')
    @include('_partials.delete_modal')
@stop
@section('CSS')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@stop
@section('JS')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    {!! HTML::script("resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                }
            });

            $('body').on('change', '.field-status', function() {
                console.debug($(this).prop('checked'));
                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: {
                        slug: $(this).data('slug'),
                        status: $(this).prop('checked')
                    }
                }).done(function(data) {
                    if(data.success) {
                        location.reload();
                    }
                }).fail(function() {
                    alert('Could not change field status. Please try again');
                });
            });

            function sendajaxvar(url, data, success){
                $.ajax({
                    type: "post",
                    datatype: "json",
                    url: url,
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    success: function (data) {
                        if(success){
                            success(data);
                        }
                        return data;
                    }
                });
            }

           $('body').on('click','.add-new-fields',function () {
               $("#add-new-fields").modal();
           })


        });
    </script>
@stop