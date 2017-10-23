<div class="row toolbarNav">
    <div class="col-md-8">
        <div class="form-horizontal">
            <div class="btn-group btn-group-justified" role="group" aria-label="..." data-tool-tab="btnpanel">
                <div class="btn-group" role="group"><a href=".general" aria-controls="General" role="tab"
                                                       data-toggle="tab" class="btn btn-default btn-dblue active">General</a>
                </div>
                <div class="btn-group" role="group"><a href=".validation" aria-controls="validation" role="tab"
                                                       data-toggle="tab"
                                                       class="btn btn-default btn-dblue">Validation</a></div>
                <div class="btn-group" role="group"><a href=".themetab" aria-controls="themetab" role="tab"
                                                       data-toggle="tab" class="btn btn-default btn-dblue">Theme</a>
                </div>
                <div class="btn-group hide" role="group"><a href=".csstab" aria-controls="csstab" role="tab"
                                                            data-toggle="tab" class="btn btn-default btn-dblue">css</a>
                </div>
                <div class="btn-group" role="group"><a href=".input" aria-controls="Input" role="tab" data-toggle="tab"
                                                       class="btn btn-default btn-dblue">Input</a></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-right"><a data-dismiss="modal" aria-label="Close" class="btn btn-default btn-default-gray"
                                        data-action="discard">Discard</a> <a href="#"
                                                                             class="btn btn-danger btn-danger-red"
                                                                             data-action="apply">Apply</a>
        <input id="panelID" value="" type="hidden">
    </div>
</div>
<div class="row row-eq-height">
    <div class="col-xs-6 left-side">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane general p-10 active" id="general" data-formsetting="setting">
                <div class="form-group"><label for="EditFieldTitle"><i class="fa fa-play mr-5 f-12"></i> Field
                        Title</label><input class="form-control" id="EditFieldTitle" data-field="lable"
                                            placeholder="Text here" value="Multi Select" type="text">
                </div>
                <div class="form-group"><label for="EditFieldOption">Set Options</label><textarea class="form-control"
                                                                                                  name="EditFieldOption"
                                                                                                  id="EditFieldOption"
                                                                                                  data-field="selectoption"></textarea>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane validation p-10" id="validation">
                <div class="form-inline col-md-12 p-0">
                    <label for="exampleInputEmail1"><i class="fa fa-play mr-5 f-12"></i> Required</label>
                    <div class="checkbox radio ml-20">
                        <input name="required" id="required" value="Yes" data-field="required" type="radio">
                        <label for="required" class="control-label">Yes</label>
                    </div>
                    <div class="checkbox radio ml-20">
                        <input name="required" id="required-no" value="No" data-field="required" type="radio">
                        <label for="required-no" class="control-label">No</label>
                    </div>
                </div>
                <div class="form-inline col-md-10  p-0">
                    <label for="exampleInputEmail1">Indicator</label>
                    <select class="form-control customFormSelect ml-20" data-field="validateindicator" data-width="auto"
                            style="display: none;">
                        <option value="">Browser Icon</option>
                        <option data-icon="glyphicon-asterisk" value="glyphicon-asterisk">asterisk</option>
                        <option data-icon="glyphicon-star" value="glyphicon-star">Star</option>
                        <option data-icon="glyphicon-star-empty" value="glyphicon-star-empty">Star Empty</option>
                    </select>
                </div>
                <div class="form-inline col-md-10 p-0">
                    <label for="exampleInputEmail1"><i class="fa fa-play mr-5 f-12"></i> Validate As</label>
                    {!! Form::select('validation',$validationRules,null,['data-width'=>'auto','data-field'=>'validateas','class' => 'form-control customFormSelect ml-20']) !!}
                </div>
                <div class="form-group col-md-10  p-0">
                    <label for="errorMessage"><i class="fa fa-play mr-5 f-12"></i> Error Message</label>
                    <input class="form-control" id="errorMessage" placeholder="Please enter a value"
                           data-field="errorMessage" type="email">
                </div>
            </div>
            <div role="tabpanel" class="tab-pane themetab " id="themetab">
                <div class="form-inline col-md-12 p-0">
                    <div class="dib wid-50">
                        <label for="editClassname"><i class="fa fa-play mr-5 f-12"></i> Class Name</label>
                    </div>
                    <input class="form-control" id="editClassname" data-field="classname" placeholder="Default"
                           type="text">
                </div>
                <div class="form-inline col-md-12 p-0">
                    <div class="dib wid-50">
                        <label for="loadsetting"><i class="fa fa-play mr-5 f-12"></i> Load Setting</label>
                    </div>
                    <select class="form-control customFormSelect" data-field="loadsetting" data-width="auto"
                            style="display: none;">
                        <option value="default">Default</option>
                        <option value="theme1">Setting 1</option>
                        <option value="theme2">Setting 2</option>
                    </select>
                </div>
                <div class="form-inline col-md-12 p-0">
                    <div class="dib wid-50">
                        <label for="labelposition"><i class="fa fa-play mr-5 f-12"></i> Label Position</label>
                    </div>
                    <div class="btn-group theme-btn-group label-Position" role="group" aria-label="...">
                        <button type="button" class="btn btn-default left"><i class="fa fa-arrow-left"></i></button>
                        <button type="button" class="btn btn-default top"><i class="fa fa-arrow-up"></i></button>
                        <button type="button" class="btn btn-default right"><i class="fa fa-arrow-right"></i></button>
                        <button type="button" class="btn btn-default none"><i class="fa fa-eye-slash"></i></button>
                    </div>
                </div>
                <div class="form-inline col-md-12 p-0">
                    <div class="dib wid-50">
                        <label for="TextAlignment"><i class="fa fa-play mr-5 f-12"></i> Text Alignment</label>
                    </div>
                    <div class="btn-group align-label" role="group" aria-label="...">
                        <button type="button" class="btn btn-default left"><i class="fa fa-align-left"></i></button>
                        <button type="button" class="btn btn-default center"><i class="fa fa-align-center"></i></button>
                        <button type="button" class="btn btn-default right"><i class="fa fa-align-right"></i></button>
                    </div>
                </div>
                <div class="form-inline col-md-12 p-0">
                    <div class="dib wid-50">
                        <label for="Textsize"><i class="fa fa-play mr-5 f-12"></i> Text Size</label>
                    </div>
                    <select class="form-control customFormSelect" data-field="textsize" data-width="auto"
                            style="display: none;">
                        <option value="f-s-15">Meduim</option>
                        <option value="f-s-12">Small</option>
                    </select>
                </div>
                <div class="form-inline col-md-12 p-0">
                    <div class="dib wid-50">
                        <label for="inputColor"><i class="fa fa-play mr-5 f-12"></i> Input Color</label>
                    </div>
                    <div class="dib vt mr-5">Background</div>
                    <div class="dib vt mr-5">
                        <div class="input-group input-color csscolor-picker colorpicker-element"
                             data-colortype="input-background">
                            <input class="form-control hide" id="editbackground" data-field="input-background"
                                   placeholder="Text here" value="" type="text">
                            <div class="input-group-addon"><i></i>
                            </div>
                        </div>
                    </div>
                    <div class="dib vt mr-5">Border</div>
                    <div class="dib vt mr-5">
                        <div class="input-group input-color csscolor-picker colorpicker-element"
                             data-colortype="input-border-color">
                            <input class="form-control hide" id="editbordercolor" data-field="input-border-color"
                                   placeholder="Text here" value="" type="text">
                            <div class="input-group-addon"><i></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-inline col-md-12 p-0">
                    <div class="dib wid-50">
                        <label for="Textsize"><i class="fa fa-play mr-5 f-12"></i> Input text Color</label>
                    </div>
                    <div class="dib vt mr-5">Color</div>
                    <div class="dib vt mr-5">
                        <div class="input-group input-color csscolor-picker colorpicker-element"
                             data-colortype="input-color">
                            <input class="form-control hide" id="editcolor" data-field="input-color"
                                   placeholder="Text here" value="" type="text">
                            <div class="input-group-addon"><i></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline col-md-12 p-0">
                    <div class="dib wid-50">
                        <label for="inputanimation"><i class="fa fa-play mr-5 f-12"></i> Animation</label>
                    </div>

                    <select class="form-control customFormSelect" data-field="animation-name" data-width="auto">
                        <option value="none">No Animation</option>
                        <option value="bounce">bounce</option>
                        <option value="flash">flash</option>
                        <option value="pulse">pulse</option>
                        <option value="rubberBand">rubberBand</option>
                        <option value="shake">shake</option>
                        <option value="headShake">headShake</option>
                        <option value="swing">swing</option>
                        <option value="tada">tada</option>
                        <option value="wobble">wobble</option>
                        <option value="jello">jello</option>
                        <option value="bounceIn">bounceIn</option>
                        <option value="bounceInDown">bounceInDown</option>
                        <option value="bounceInLeft">bounceInLeft</option>
                        <option value="bounceInRight">bounceInRight</option>
                        <option value="bounceInUp">bounceInUp</option>
                        <option value="bounceOut">bounceOut</option>
                        <option value="bounceOutDown">bounceOutDown</option>
                        <option value="bounceOutLeft">bounceOutLeft</option>
                        <option value="bounceOutRight">bounceOutRight</option>
                        <option value="bounceOutUp">bounceOutUp</option>
                        <option value="fadeIn">fadeIn</option>
                        <option value="fadeInDown">fadeInDown</option>
                        <option value="fadeInDownBig">fadeInDownBig</option>
                        <option value="fadeInLeft">fadeInLeft</option>
                        <option value="fadeInLeftBig">fadeInLeftBig</option>
                        <option value="fadeInRight">fadeInRight</option>
                        <option value="fadeInRightBig">fadeInRightBig</option>
                        <option value="fadeInUp">fadeInUp</option>
                        <option value="fadeInUpBig">fadeInUpBig</option>
                        <option value="fadeOut">fadeOut</option>
                        <option value="fadeOutDown">fadeOutDown</option>
                        <option value="fadeOutDownBig">fadeOutDownBig</option>
                        <option value="fadeOutLeft">fadeOutLeft</option>
                        <option value="fadeOutLeftBig">fadeOutLeftBig</option>
                        <option value="fadeOutRight">fadeOutRight</option>
                        <option value="fadeOutRightBig">fadeOutRightBig</option>
                        <option value="fadeOutUp">fadeOutUp</option>
                        <option value="fadeOutUpBig">fadeOutUpBig</option>
                        <option value="flip">flip</option>
                        <option value="flipInX">flipInX</option>
                        <option value="flipInY">flipInY</option>
                        <option value="flipOutX">flipOutX</option>
                        <option value="flipOutY">flipOutY</option>
                        <option value="lightSpeedIn">lightSpeedIn</option>
                        <option value="lightSpeedOut">lightSpeedOut</option>
                        <option value="rotateIn">rotateIn</option>
                        <option value="rotateInDownLeft">rotateInDownLeft</option>
                        <option value="rotateInDownRight">rotateInDownRight</option>
                        <option value="rotateInUpLeft">rotateInUpLeft</option>
                        <option value="rotateInUpRight">rotateInUpRight</option>
                        <option value="rotateOut">rotateOut</option>
                        <option value="rotateOutDownLeft">rotateOutDownLeft</option>
                        <option value="rotateOutDownRight">rotateOutDownRight</option>
                        <option value="rotateOutUpLeft">rotateOutUpLeft</option>
                        <option value="rotateOutUpRight">rotateOutUpRight</option>
                        <option value="hinge">hinge</option>
                        <option value="rollIn">rollIn</option>
                        <option value="rollOut">rollOut</option>
                        <option value="zoomIn">zoomIn</option>
                        <option value="zoomInDown">zoomInDown</option>
                        <option value="zoomInLeft">zoomInLeft</option>
                        <option value="zoomInRight">zoomInRight</option>
                        <option value="zoomInUp">zoomInUp</option>
                        <option value="zoomOut">zoomOut</option>
                        <option value="zoomOutDown">zoomOutDown</option>
                        <option value="zoomOutLeft">zoomOutLeft</option>
                        <option value="zoomOutRight">zoomOutRight</option>
                        <option value="zoomOutUp">zoomOutUp</option>
                        <option value="slideInDown">slideInDown</option>
                        <option value="slideInLeft">slideInLeft</option>
                        <option value="slideInRight">slideInRight</option>
                        <option value="slideInUp">slideInUp</option>
                        <option value="slideOutDown">slideOutDown</option>
                        <option value="slideOutLeft">slideOutLeft</option>
                        <option value="slideOutRight">slideOutRight</option>
                        <option value="slideOutUp">slideOutUp</option>
                    </select>

                </div>
                <div class="form-inline col-md-12 p-0">
                    <label for="animationDelay" class="ml-20">Delay</label>
                    <input class="form-control small-theme-text" id="" data-field="animation-delay" placeholder="0.1"
                           value="0.1" type="text">
                    <label for="animationDuration" class="ml-20">Duration</label>
                    <input class="form-control small-theme-text" id="" data-field="animation-duration" placeholder="0.1"
                           value="0.9" type="text">
                </div>
                <hr class="p-t-10">
                <div class="form-inline col-md-12 p-0 text-right">

                    <button type="button" class="btn btn-default btn-success" data-action="saveassetting">Save as new
                        Setting
                    </button>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane csstab  p-10" id="csstab">
                <div class="form-inline">
                    <div class="form-group">
                        <label for="editbackground" class="width-150"><i class="fa fa-play mr-5 f-12"></i>Background
                            Color</label>
                        <div class="input-group input-color csscolor-picker colorpicker-element"
                             data-colortype="background">
                            <input class="form-control hide" id="editbackground" data-field="background"
                                   placeholder="Text here" value="" type="text">
                            <div class="input-group-addon"><i></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="editcolor" class="width-150"><i class="fa fa-play mr-5 f-12"></i>Color</label>
                        <div class="input-group input-color csscolor-picker colorpicker-element" data-colortype="color">
                            <input class="form-control hide" id="editcolor" data-field="color" placeholder="Text here"
                                   value="" type="text">
                            <div class="input-group-addon"><i></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="editBackgound" class="width-150"><i class="fa fa-play mr-5 f-12"></i>Border
                            Color</label>
                        <div class="input-group input-color csscolor-picker colorpicker-element"
                             data-colortype="border-color">
                            <input class="form-control hide" id="editBackgound" data-field="border-color"
                                   placeholder="Text here" value="" type="text">
                            <div class="input-group-addon"><i></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="editpadding" class="col-xs-6 width-150 p-l-0 "><i class="fa fa-play mr-5 f-12"></i>Padding</label>
                        <div class="col-xs-6 p-t-10">
                            <div class="filedSlider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                 data-slidertype="padding-top"><span
                                        class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"
                                        style="left: 0%;"></span>
                            </div>
                            <input class="form-control hide" id="editpadding" data-field="padding-top"
                                   placeholder="Text here" value="0" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="editpaddingbottom" class="col-xs-6 width-150 p-l-0 "><i
                                    class="fa fa-play mr-5 f-12"></i>Padding-bottom</label>
                        <div class="col-xs-6 p-t-10">
                            <div class="filedSlider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                 data-slidertype="padding-bottom"><span
                                        class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"
                                        style="left: 0%;"></span>
                            </div>
                            <input class="form-control hide" id="editpaddingbottom" data-field="padding-bottom"
                                   placeholder="Text here" value="0" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="editpaddingleft" class="col-xs-6 width-150 p-l-0 "><i
                                    class="fa fa-play mr-5 f-12"></i>Padding-Left</label>
                        <div class="col-xs-6 p-t-10">
                            <div class="filedSlider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                 data-slidertype="padding-left"><span
                                        class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"
                                        style="left: 0%;"></span>
                            </div>
                            <input class="form-control hide" id="editpaddingleft" data-field="padding-left"
                                   placeholder="Text here" value="0" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="form-group">
                        <label for="editpaddingright" class="col-xs-6 width-150 p-l-0 "><i
                                    class="fa fa-play mr-5 f-12"></i>Padding-right</label>
                        <div class="col-xs-6 p-t-10">
                            <div class="filedSlider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                 data-slidertype="padding-right"><span
                                        class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"
                                        style="left: 0%;"></span>
                            </div>
                            <input class="form-control hide" id="editpaddingright" data-field="padding-right"
                                   placeholder="Text here" value="0" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane input p-10" id="input">
                @if(count($units))
                    <div class="col-md-4">
                        <ul class="filedcolumntype list-group listdatagroup" role="tablist">
                            @foreach($units as $tpl)
                                <li class="">
                                    <a href="javascript:void(0)" type="button" data-id="{!! $tpl->slug !!}"
                                       data-action="units" class="item-settings">
                                        <img src="/resources/assets/images/form-list.jpg">
                                        <span>{!! $tpl->title !!}</span></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-8 variations-box">
                        @include("console::structure._partials.variation_list")
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xs-6 right-side popuppreview p-t-40">
        <div data-frompre="preview">
            <div class="form-group datafrom" data-type="multiSelect">
                <div class="row">
                    <label for="multiSelect" data-fcontrol="label" class="col-sm-12 control-label">Multi Select</label>
                    <div class="col-sm-12" data-fcontrol="input">
                        <select name="multiSelect" multiple="" class="form-control"
                                data-content="Please select an option">
                            <option value="0" selected="selected">--- Select ---</option>
                            <option>Option 1</option>
                            <option>Option 2</option>
                            <option>Option 3</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a> <a
                        class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                              data-action="delete"><i
                            class="fa fa-trash"></i></a></div>
        </div>
    </div>
</div>