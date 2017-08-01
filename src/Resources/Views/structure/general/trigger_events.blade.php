@extends('cms::layouts.mTabs',['index'=>'console_general'])
@section('tab')
    <div class="row m-b-10">

    </div>
    @include('resources::assests.magicModal')
@stop
@section('CSS')

@stop
@section('JS')
    {!! HTML::script("resources/assets/js/UiElements/bb_styles.js?v.5") !!}
@stop