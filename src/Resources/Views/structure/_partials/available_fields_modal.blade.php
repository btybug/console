<div id="available_fields_modal" class="modal fade fullscreenModal" tabindex="-1" role="dialog"
     aria-labelledby="availableFieldModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <button class="btn pull-right save_item" data-btnrole="addfield"><i class="fa fa-save m-r-10"></i>Save
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="top: 52px;"><span
                                aria-hidden="true">&times;</span></button>
                </div>


                <ul class="field_tabs">
                    <li class="tab-link current" data-tab="tab-1">Fields settings</li>
                    <li class="tab-link" data-tab="tab-2">Available Fields</li>
                </ul>

            </div>
            <div class="available-fields-modal-body modal-body p-0">


                <div class="row row-eq-height">
                    <div class="col-xs-6 tooleditsection p-0 popupeditleft">
                        <div id="tab-1" class="tab-content current p-0">
                            <div class="row toolbarNav m-b-15">
                                <div class=" col-md-12 text-right p-b-10 ">
                                    {!! BBbutton('units','unit_default','Change Html',['class'=>'btn btn-default btn-dblue','data-type'=>'frontend', 'data-targetappend'=>'changehtml']) !!}</div>
                            </div>
                            <div class="collapse" data-bbbuttonappend="changehtml">
                                <button type="button" class="btn btn-default btn-dblue pull-right" data-bbclick="close"
                                        data-targetopen="setting"><i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                                <div data-targetput></div>

                            </div>
                            <div class="collapse in" data-bbbuttonappend="setting">

                                <form data-form="fieldsetting">


                                    {!! $defaultRenderedSettingsHtml !!}
                                </form>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-content">
                            <ul class="formlisting">
                                @if($availableFields)
                                    @foreach($availableFields as $field)
                                        <li>
                                            <a href="javascript:void(0)" class="btn text-center item m-item"
                                               data-btnrole="addavailableField" data-value="{!! $field->slug !!}">
                                                <img src="/resources/assets/images/form-list2.jpg">
                                                <input type="hidden" class="current-available-field"
                                                       data-extra='{!! json_encode($field->json_data) !!}'
                                                       data-field-shortcode='[field slug={!! $field->slug !!}]'/>
                                            </a>
                                            <span>{!! $field->name !!}</span>
                                            <div class="hide"
                                                 data-rendered="html">{!! BBField(['form' => $form->slug, 'field' => $field->slug]) !!}</div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="col-xs-6  p-15">

                        <div class="p-b-10">
                            {{--{!! BBbutton('units','unit_default','Change Html',['class'=>'form-control input-md','data-type'=>'frontend']) !!}--}}
                            {{--{!! BBbutton('units','field_unit','Change Html',['class'=>'form-control input-md','data-type'=>'fill']) !!}--}}
                        </div>
                        <div data-previewselected="input" id="previewselected">

                        </div>

                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->