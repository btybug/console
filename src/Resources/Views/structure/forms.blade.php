@extends('cms::layouts.mTabs',['index'=>'structure_console'])
@section('tab')

    <div class="row">

    </div>
    <div class="row m-b-10">
        <h3>All Forms</h3>

        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-black text-white">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Shortcode</th>
                    <th>Created By</th>
                    <th>Table</th>
                    <th>Form Type</th>
                    <th>Required Fields</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="field_list">
                @if(count($forms))
                    @foreach($forms as $count => $form)
                        <tr class="field-row">
                            <td>{!! $form->id !!}</td>
                            <td>{!! $form->name !!}</td>
                            <td>
                                <p>[form slug={!! $form->slug !!}] </p>
                                <p> [form id={!! $form->id !!}] </p>
                            </td>
                            <td>{!! $form->created_by !!}</td>
                            <td>{!! $form->fields_type !!}</td>
                            <td>{!! $form->form_type !!}</td>
                            <td>
                                @if($form->required_fields)
                                    {!! implode(', ',json_decode($form->required_fields,true)) !!}
                                @else
                                    No Reqired Fields
                                @endif
                            </td>
                            <td>
                                <a href="{!! url('/admin/console/structure/forms/entries',$form->id) !!}"
                                   class="btn btn-success"><i class="fa fa-line-chart"></i></a>

                                <a href="{!! url('/admin/console/structure/forms/settings',$form->id) !!}"
                                   class="btn btn-primary"><i class="fa fa-cog"></i></a>

                                <a href="{!! url('/admin/console/structure/forms/edit',$form->id) !!}"
                                   class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                @if($form->created_by == 'custom')
                                    <a data-href="{!! url('/admin/modules/tables/field/delete') !!}"
                                       data-key="{!! isset($field) && isset($field->id) ? $field->id : '' !!}"
                                       data-type="Field"
                                       class="{!! isset($field) && isset($field->id) ? 'delete-button' : 'delete-new-field' !!} btn btn-danger"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('CSS')

@stop
@section('JS')
    {!! HTML::script("public/js/UiElements/bb_styles.js?v.5") !!}
@stop