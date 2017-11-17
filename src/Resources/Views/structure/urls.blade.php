@extends('btybug::layouts.mTabs',['index'=>'structure_console'])
@section('tab')
    <div class="col-md-6 m-t-15 m-b-15">
        {!! Form::select('method',
            ['all' => 'Get & Post','GET' => 'GET only','POST' => 'POST only'],
            $method,['class' => 'form-control select-method']) !!}
    </div>
    <div class="col-md-12">
        @if(isset($data['GET']))
            <div class="col-md-6">
                <h3>GET Routes</h3>
                <div class="col-md-12 jstree_demo_div">
                    @foreach($data['GET'] as $key => $route)
                        {!! $route->html() !!}
                    @endforeach
                </div>
            </div>
        @endif

        @if(isset($data['POST']))
            <div class="col-md-6">
                <h3>POST Routes</h3>
                <div class="col-md-12 jstree_demo_div">
                    @foreach($data['POST'] as $key => $route)
                        {!! $route->html() !!}
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@stop
@section('CSS')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
@stop
@section('JS')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script>
        $(function () {
            $('.jstree_demo_div').jstree();

            $('body').on("change", ".select-method", function () {
                var val = $(this).val();
                var url = window.location.pathname + "?method=" + val;

                window.location = url;
            });
        });
    </script>
@stop