<div id="add_field_modal" class="modal fade fullscreenModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn pull-right save_item" data-btnrole="addfield"><i class="fa fa-save m-r-10"></i>Save
                </button>
                <button type="button" class="close" data-dismiss="modal" style="top: 52px;">&times;</button>

                <h4 class="modal-title">Field unit</h4>
            </div>
            <div class="modal-body" style="padding: 0px;">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 cms_module_list">
                        <ul class="list-unstyled menuList unit-list" id="components-list"
                            data-dragable="item"
                            data-variation-url="{!! url('/admin/console/structure/forms/get-unit-variations') !!}">
                            @if(count($fields))
                                @foreach($fields as $ui)
                                    @if($field)
                                        @if($field->slug == $ui->slug)
                                            <li class="field-unit-item active"
                                                data-unit-slug="{!! $ui->slug !!}"
                                                data-type="{!! $ui->type !!}"
                                                data-item="field-unit">
                                        @else
                                            <li class="field-unit-item"
                                                data-unit-slug="{!! $ui->slug !!}"
                                                data-type="{!! $ui->type !!}"
                                                data-item="field-unit">
                                        @endif
                                    @else
                                        @if($fields[0]->slug == $ui->slug)
                                            <li class="field-unit-item active"
                                                data-unit-slug="{!! $ui->slug !!}"
                                                data-type="{!! $ui->type !!}"
                                                data-item="field-unit">
                                        @else
                                            <li class="field-unit-item"
                                                data-unit-slug="{!! $ui->slug !!}"
                                                data-type="{!! $ui->type !!}"
                                                data-item="field-unit">
                                                @endif
                                                @endif
                                                <a data-setting-url="{!! url('/admin/console/structure/forms/get-unit-settings') !!}"
                                                   href="javascript:void(0);"
                                                   data-href="?p={!! $ui->slug !!}"
                                                   rel="unit" data-slug="{{ $ui->slug }}"
                                                   class="tpl-left-items">
                                                    <span class="module_icon"></span> {{ $ui->name }}
                                                </a>
                                                <input type="hidden" data-bladefield
                                                       value="">
                                                <textarea name="{!! $ui->slug !!}" data-htmlsfield
                                                          class="hide">render</textarea>
                                            </li>
                                            @endforeach
                                            @else
                                                No Units
                                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 variation-list">
                        {{--@include('console::structure._partials.variation_list')--}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>