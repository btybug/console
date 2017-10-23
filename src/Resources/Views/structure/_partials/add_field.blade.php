<div id="add_field_modal" class="modal fade fullscreenModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn pull-right save_item" data-btnrole="addfield"><i class="fa fa-save m-r-10"></i>Save
                </button>
                <button type="button" class="close" data-dismiss="modal" style="top: 52px;">&times;</button>

                <h4 class="modal-title">Defult Field HTML</h4>
                {!! BBbutton('units','component','Change',[
                'class' => 'btn btn-success',
                "data-type" => 'frontend',
                'data-sub' => "component",
                'model' => (isset($model['uislug'])) ? $model['uislug'] : null
                ]) !!}

                <input type="text" data-inputfidid value="" readonly>
            </div>
            <div class="modal-body" style="padding: 0px;">
                <div class="row">
                    <div class="col-xs-6 p-10">
                        <div data-tab="general" data-previewselected="input" id="previewselected">
                            @if(isset($data['html']))
                                {!! $data['html'] !!}
                            @endif
                            {{--{!! Form::open(['id' => 'generalTabForm']) !!}--}}
                            {{--<div class="blade-inputsetting datafrom " data-class="setting"  data-type="Singleline" data-size="col-sm-12">--}}
                            {{--<div class="row">--}}
                            {{--<label for="singleline" data-fcontrol="label" class="col-sm-4"><i class="fa fa-star"></i> label</label>--}}
                            {{--<div data-fcontrol="input" class="col-sm-8" > {!! Form::text('singleline',null,['id'=>'singleline','placeholder'=>'placeholder']) !!}<button type="button" data-toggle="tooltip" data-placement="top" title="{tooltipmessage}"><i class="fa fa-question"></i></button></div>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                        </div>

                        <textarea class="form-control " style="margin-top: 200px;" data-exportjson></textarea>
                        <h4>Code</h4>
                        <textarea class="form-control " data-exporthtmlcode></textarea>
                        <h4>Rendered HTML</h4>
                        <textarea class="form-control " data-exporthtmlreal></textarea>
                    </div>

                    <div class="col-xs-6 bordercontainerleft p-0">
                        <ul class="nav nav-tabs nav-justified navtabbar" role="tablist">
                            <li class="active"><a href="#generaltab" aria-controls="home" role="tab" data-toggle="tab">General</a>
                            </li>
                            <li><a href="#optionstab" aria-controls="home" role="tab" data-toggle="tab">Options</a></li>
                        </ul>
                        <div class="tab-content p-10">
                            <div role="tabpanel" class="tab-pane active" id="generaltab">
                                {!! Form::model($model,['id' => 'generalTabForm']) !!}
                                @if(isset($uiUnit) && $uiUnit)
                                    {!! $uiUnit->renderSettings($model) !!}
                                @endif
                                {!! Form::close() !!}
                            </div>
                            <div role="tabpanel" class="tab-pane" id="optionstab">
                                <form class="form-horizontal">
                                    <div class="panel panel-default p-0">
                                        <div class="panel-heading">Field data</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="savetargettabe"
                                                       class="col-sm-4 control-label m-0">Name</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('field_name',$unit->title,['class' => 'form-control', 'id' => 'savetargetname','readonly' => 'readonly']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default p-0">
                                        <div class="panel-heading">Save Target</div>
                                        <div class="panel-body">
                                            @if(isset($unit->options['table']))
                                                <div class="form-group">
                                                    <label for="savetargettabe"
                                                           class="col-sm-4 control-label m-0">Table</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('table',$unit->options['table'],['class' => 'form-control', 'id' => 'savetargettabe','readonly' => 'readonly']) !!}
                                                    </div>
                                                </div>
                                                @if(isset($unit->options['column']))
                                                    <div class="form-group" data-selectoption="columns">
                                                        <label for="savetargetcolumn"
                                                               class="col-sm-4 control-label m-0">Columns</label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('columns',$unit->options['column'],['class' => 'form-control', 'id' => 'savetargetcolumn','readonly' => 'readonly']) !!}
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="form-group">
                                                    <label for="savetargettabe"
                                                           class="col-sm-4 control-label m-0">Table</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="savetargettabe" name="table"
                                                                data-ajaxselect="table">

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group hide" data-selectoption="columns">
                                                    <label for="savetargetcolumn"
                                                           class="col-sm-4 control-label m-0">Columns</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="savetargetcolumn"
                                                                name="columns"
                                                                data-ajaxselect="columns">

                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="panel panel-default p-0">
                                        <div class="panel-heading">Validation</div>
                                        <div class="panel-body">
                                            @if(isset($unit->options['validation']))
                                                <div class="form-group" data-selectoption="columns">
                                                    <label for="validationas"
                                                           class="col-sm-4 control-label m-0">Validation</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('validation',$unit->options['validation'],['class' => 'form-control', 'id' => 'validationas','readonly' => 'readonly']) !!}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="form-group">
                                                    <label for="validationas"
                                                           class="col-sm-4 control-label m-0 customFormSelect ">Validate
                                                        As</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="validationas" name="table">
                                                            <option selected="selected" value="">Any Format</option>
                                                            <option value="email">Email</option>
                                                            <option value="url">URL</option>
                                                            <option value="phone_number">Phone Number</option>
                                                            <option value="numbers_only">Numbers Only</option>
                                                            <option value="text_only">Text Only</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group hide" data-selectoption="validation">
                                                    <label for="validationasadmin"
                                                           class="col-sm-4 control-label m-0 customFormSelect ">Validate </label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" disabled id="validationasadmin"
                                                                name="vlidation" data-ajaxselect="validation">

                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
</div>