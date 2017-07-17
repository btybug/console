@extends('layouts.mTabs',['index'=>'structure_console'])
@section('tab')

    <div class="row">
        <div class="col-md-12">
            <a href="{!! url('admin/console/structure/forms/create') !!}" class="btn btn-primary pull-right btnUploadWidgets"><i class="glyphicon glyphicon-plus module_upload_icon"></i><span class="upload_module_text">Create New</span></a>
            <a href="{!! url('admin/console/structure/forms/create-advanced') !!}" class="btn btn-danger pull-right btnUploadWidgets"><i class="glyphicon glyphicon-plus module_upload_icon"></i><span class="upload_module_text">Create Advanced</span></a>
        </div>
    </div>
    <div class="row m-b-10">
        <h3>All Forms</h3>

        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-black text-white">
                    <th>ID</th>
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Shortcode</th>
                    <th>Type</th>
                    <th>Created By</th>
                    <th>Fields type</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="field_list">
                @if(count($forms))
                    @foreach($forms as $count => $form)
                        <tr class="field-row">
                            <td>{!! $form->id !!}</td>
                            <td>{!! $form->slug !!}</td>
                            <td>{!! $form->name !!}</td>
                            <td>
                                <p>[edit-form slug={!! $form->slug !!}] </p>
                                <p> [edit-form id={!! $form->id !!}] </p>
                            </td>
                            <td>{!! $form->type !!}</td>
                            <td>{!! $form->created_by !!}</td>
                            <td>{!! $form->fields_type !!}</td>
                            <td>
                                <a href="{!! url('/admin/console/structure/forms/edit-custom',$form->id) !!}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                @if($form->created_by == 'custom')
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
@stop
@section('CSS')

@stop
@section('JS')
    {!! HTML::script("resources/assets/js/UiElements/bb_styles.js?v.5") !!}
@stop