@extends('btybug::layouts.mTabs',['index'=>'structure_console'])
@section('tab')
    <div class="col-md-12">
        <h3>All Tables</h3>
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Table</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($tables))
                    @foreach($tables as $k=>$table)
                        <tr class="clickable-row">
                            <td>
                                {!! $table !!}
                            </td>
                            <td>
                                <a href="{!! url('/admin/modules/tables/edit',$table) !!}" class="btn btn-info"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
@stop