@extends('btybug::layouts.mTabs',['index'=>'structure_console'])
@section('tab')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <article>
            <div class="col-md-8 col-md-offset-2">
                {!! hierarchyAdminPagesListHierarchy($pageGrouped) !!}
            </div>
        </article>
    </div>

    @include('cms::_partials.delete_modal')
@stop
{{--@include('tools::common_inc')--}}
@section('CSS')
    {!! HTML::style('/css/create_pages.css') !!}
    {!! HTML::style('/css/menu.css?v=0.16') !!}
    {!! HTML::style('/css/tool-css.css?v=0.23') !!}
    {!! HTML::style('/css/page.css?v=0.15') !!}
    {!! HTML::style('/css/admin_pages.css') !!}
    {!! HTML::style('/css/jquery.tagit.css') !!}
    {!! HTML::style('/css/select2/select2.min.css') !!}

@stop

@section('JS')
    {!! HTML::script('/js/create_pages.js') !!}
    {!! HTML::script("/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('/js/admin_pages.js') !!}
    {!! HTML::script('/js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('/js/bootbox/bootbox.min.js') !!}
    {!! HTML::script('/js/icon-plugin.js?v=0.4') !!}
    {!! HTML::script('/js/tag-it/tag-it.js') !!}
    {!! HTML::script('/js/select2/select2.full.min.js') !!}
    <script>

        $(document).ready(function () {

            $("body").on('click', '[data-collapse]', function () {
                var id = $(this).attr('data-collapse');
                $('li[data-id=' + id + '] ol').slideToggle();
                $(this).toggleClass('fa-minus fa-plus');
            });

            $("body").on('click', 'li[data-id] .listinginfo', function () {
                var item_id = $(this).parent('li[data-id]').attr('data-id');
                $('.pagelisting .listinginfo.active_class').removeClass('active_class');
                $('li[data-id=' + item_id + '] > .listinginfo').addClass('active_class');

            });

            fixbar()

            function fixbar() {
                var targetselector = $('.vertical-text');
                if (targetselector.length > 0) {
                    var getwith = targetselector.width()
                    var left = 0 - getwith / 2 - 15;
                    targetselector.css({'left': left, 'top': getwith / 2})
                }
            }
        });
    </script>
@stop