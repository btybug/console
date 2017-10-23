@if($tpl)
    <div class="layout clearfix">
        <img src="/app/Modules/Resources/Resources/assets/img/layout-img.jpg" alt="" class="layoutImg">
        <div class="layoutData">
            <div class="layoutCol">
                <h4>{!! $tpl->title !!}</h4>
                <p>{!! @$tpl->description !!}</p>

                @if($tpl && !$tpl->is_core)
                    <a data-href="{!! url('/admin/uploads/gears/h-f/delete') !!}" data-key="{!! $tpl->slug !!}"
                       data-type="H&F" class="delete-button btn btn-danger p-a-r-10-t-0"><i
                                class="fa fa-trash-o"></i></a>
                @endif
            </div>
            <div class="layoutFooter row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 ">
                    <span class="textWrap"><a href="{!! @$tpl->author_site !!}"
                                              class="link"><i>{!! @$tpl->author_site !!}</i></a></span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4  centerText">
                    <span class="iconRefresh"><i class="fa fa-refresh"></i></span> {!! @$tpl->version !!}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 rightText">
                    <i class="fa fa-user"></i> {!! @$tpl->author !!}, {!! BBgetDateFormat(@$tpl->created_at) !!}
                </div>

            </div>
        </div>
    </div>
@endif
