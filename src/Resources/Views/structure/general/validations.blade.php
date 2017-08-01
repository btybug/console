@extends('cms::layouts.mTabs',['index'=>'console_general'])
@section('tab')

    <div class="row">

    </div>
    <div class="row m-b-10">
        <h3>All Validations</h3>

        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-black text-white">
                    <th>Name</th>
                    <th>Rules</th>
                </tr>
                </thead>
                <tbody id="field_list">
                @if(count($validations))
                    @foreach($validations as $key => $value)
                        <tr class="field-row">
                            <td>{!! $value !!}</td>
                            <td>{!! $key !!}</td>
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