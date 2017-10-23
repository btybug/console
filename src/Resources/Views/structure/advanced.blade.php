@extends('cms::layouts.admin')
@section('content')

    @include('console::structure._partials.new_form_modal')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-list-alt"></i>Create Form</li>
    </ol>
    @if (session('flash.message') != null)
        <div class="flash alert {{ Session::has('flash.class') ? session('flash.class') : 'alert-success' }}"> {!! session('flash.message') !!} </div>
    @endif
    <div class="row">
        <aside class="right-side">
            <!--section ends-->
            <section class="content">
                <!--main content-->
                <div class="row hide"> {!! Form::open(['id' => 'createNewForm']) !!}
                    <div class="col-md-12 m-b-15">
                        <div class="col-md-6"> {!! Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Form Name', 'id' => 'form_name']) !!} </div>
                        <div class="col-md-6 text-right">
                            <input type="button" value="Save" class="btn btn-success create-new-form">
                            <a href="{!! url('admin/builders/forms') !!}" class="btn btn-default">Cancel</a></div>
                        {!! Form::close() !!} </div>
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissable visible-xs visible-md">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            May not work properly in touch enabled devices as it as requires drag and drop.
                        </div>
                        <!--form builder-->
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <div class="navbars">
                                        <ul class="nav nav-tabs navbar-tabs" style='border-bottom: 1px solid #337AB7; '>
                                            <li data-value='bulder-form' class="active"><a href="#">Drag & Drop
                                                    components</a></li>
                                            <li data-value='settings' class=""><a href="#">Settings</a></li>
                                            <li data-value='logic' class=""><a href="#">Logic</a></li>
                                        </ul>
                                    </div>
                                    <!--                                <i class="livicon" data-name="help" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                                    <a href='#' class="btn btn-primay">Drag & Drop components</a>-->
                                </h3>
                                <span class="pull-right clickable"></span></div>
                            <div class="panel-body">
                                <div class="row clearfix bulder-form">
                                    <!-- Components -->
                                    <div class="col-md-6">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs" id="formtabs">
                                                <!-- Tab nav -->
                                            </ul>
                                            <form class="form-horizontal" id="components" role="form">
                                                <fieldset>
                                                    <div class="tab-content">
                                                        <!-- Tabs of snippets go here --> </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- / Components -->
                                    <!-- Building Form. -->
                                    <div class="col-md-6">
                                        <div class="clearfix">
                                            <p class="padding_p">Drag elements here</p>
                                            <hr class="hr-ddd">
                                            <div id="build">
                                                <form id="target" class="form-horizontal">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='settings row clearfix'>
                                    <div class="table-responsive">
                                        <div class="col-md-10">
                                            <form class="form-horizontal">
                                                <fieldset>
                                                    <legend class="legend">E-mail Settings</legend>
                                                    <div class="form-group email-plase">
                                                        <div class="checkbox ">
                                                            <label class="checkbox">
                                                                <input type="checkbox" data-toggle="collapse"
                                                                       data-target="#collapseExample1"
                                                                       aria-expanded="false"
                                                                       aria-controls="collapseExample1">
                                                                Send admin confirmation Email </label>
                                                            <div id="collapseExample1" class="collapse">
                                                                <div class="well">
                                                                    <div>
                                                                        <label class="col-md-2 control-label"
                                                                               for="textinput">Admin email</label>
                                                                        <div class="col-md-4">
                                                                            <input id="textinput" name="textinput"
                                                                                   type="text" placeholder="placeholder"
                                                                                   class="form-control input-md">
                                                                        </div>
                                                                        <div class="col-md-2"><a href="#">Edit
                                                                                template</a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="checkbox ">
                                                            <label class="checkbox">
                                                                <input type="checkbox" data-toggle="collapse"
                                                                       data-target="#collapseExample2"
                                                                       aria-expanded="false"
                                                                       aria-controls="collapseExample2">
                                                                Send user confirmation Email </label>
                                                            <div id="collapseExample2" class="collapse">
                                                                <div class="well">
                                                                    <div>
                                                                        <div class="col-md-4">
                                                                            <div class="radio">
                                                                                <label for="send-0">
                                                                                    <input type="radio" name="send"
                                                                                           id="send-0" value="1"
                                                                                           checked="checked">
                                                                                    yes </label>
                                                                            </div>
                                                                            <div class="radio">
                                                                                <label for="send-1">
                                                                                    <input type="radio" name="send"
                                                                                           id="send-1" value="2">
                                                                                    no </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4"><a href="#">Edit
                                                                                template</a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <legend class="legend">After submitting</legend>
                                                    <div class="form-group">
                                                        <div class="checkbox ">
                                                            <label class="checkbox">
                                                                <input type="checkbox" data-toggle="collapse"
                                                                       data-target="#collapseExample3"
                                                                       aria-expanded="false"
                                                                       aria-controls="collapseExample3">
                                                                Show notifictaion message </label>
                                                            <div id="collapseExample3" class="collapse">
                                                                <div class="well">
                                                                    <div>
                                                                        <label class="col-md-4 control-label"
                                                                               for="textinput">Type your message</label>
                                                                        <div class="col-md-4">
                                                                            <input id="textinput" name="textinput"
                                                                                   type="text" placeholder="placeholder"
                                                                                   class="form-control input-md">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="checkbox ">
                                                            <label class="checkbox">
                                                                <input type="checkbox" data-toggle="collapse"
                                                                       data-target="#collapseExample4"
                                                                       aria-expanded="false"
                                                                       aria-controls="collapseExample4">
                                                                Redirect to page </label>
                                                            <div id="collapseExample4" class="collapse">
                                                                <div class="well">
                                                                    <div>
                                                                        <label class="col-md-4 control-label"
                                                                               for="textinput">Page url</label>
                                                                        <div class="col-md-4">
                                                                            <input id="textinput" name="textinput"
                                                                                   type="text" placeholder="placeholder"
                                                                                   class="form-control input-md">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="checkbox ">
                                                            <label class="checkbox">
                                                                <input type="checkbox" data-toggle="collapse"
                                                                       data-target="#collapseExample5"
                                                                       aria-expanded="false"
                                                                       aria-controls="collapseExample5">
                                                                Open new tab </label>
                                                            <div id="collapseExample5" class="collapse">
                                                                <div class="well">
                                                                    <div>
                                                                        <label class="col-md-4 control-label"
                                                                               for="textinput">Page url</label>
                                                                        <div class="col-md-4">
                                                                            <input id="textinput" name="textinput"
                                                                                   type="text" placeholder="placeholder"
                                                                                   class="form-control input-md">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <legend class="legend">Visibility</legend>
                                                    <div class="form-group">
                                                        <div class="checkbox ">
                                                            <label class="checkbox">
                                                                <input type="checkbox" data-toggle="collapse"
                                                                       data-target="#collapseExample6"
                                                                       aria-expanded="false"
                                                                       aria-controls="collapseExample6">
                                                                User Groups </label>
                                                            <div id="collapseExample6" class="collapse">
                                                                <div class="well">
                                                                    <div>
                                                                        <select class="form-control input-md">
                                                                            <option value="1"> Teacher</option>
                                                                            <option value="2"> Studets</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <legend class="legend">Hidden fields</legend>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class='logic row clearfix'></div>
                            </div>
                            <!-- / Building Form. --> </div>
                        <!-- / Components --> </div>

                    <!--form builder ends-->
                </div>
                <div class="row toolbarNav">
                    <div class="col-md-8">
                        <div class="form-horizontal">
                            <div class="form-group p-l-20">
                                <label for="formname" class="col-md-2 control-label text-left">Form Name</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Form Name" class="form-control" value=""
                                           id="formname" required="">
                                </div>
                                <a aria-controls="General" role="tab" data-toggle="tab"
                                   class="btn btn-default btn-dblue"> <i class="fa fa-gear"></i> Setting </a></div>
                        </div>
                    </div>
                    <div class="col-md-4 text-right"><a href="#" class="btn btn-default btn-default-gray"
                                                        data-action="converthtml">Convert HTML</a> <a href="#"
                                                                                                      class="btn btn-default btn-default-gray">Discard</a>
                        <a href="#" class="btn btn-danger btn-danger-red" data-value="{!!$form->id or null!!}"
                           data-save="form">Save</a>
                        <input type="hidden" id="panelID" value="">
                    </div>
                </div>
                <div class="row toolrowsection bootbox">
                    <div class="col-md-3 tooleditsection">
                        <select class="form-control customFormSelect" id="category" data-filter="components"
                                name="category">
                            <option value="basic" selected="selected">Basic Components</option>
                            <option value="advance">Advance Components</option>
                        </select>
                        <div class="category-list list-group">
                            <div class="list-group-item grid-stack-item green" data-fromtype="Singleline"
                                 data-components="basic" data-gs-auto-position="true">
                                <div class="grid-stack-item-content"><i class="fa fa-minus"></i> Single-line</div>
                            </div>
                            <div class="list-group-item grid-stack-item darkpink" data-fromtype="multiline"
                                 data-components="basic" data-gs-auto-position="true">
                                <div class="grid-stack-item-content"><i class="fa fa-bars"></i> Multi-line</div>
                            </div>
                            <div class="list-group-item grid-stack-item blue" data-fromtype="Select"
                                 data-components="basic" data-gs-auto-position="true">
                                <div class="grid-stack-item-content"><i class="fa fa-arrow-down"></i> Select</div>
                            </div>
                            <div class="list-group-item grid-stack-item yellow" data-fromtype="multiSelect"
                                 data-components="basic">
                                <div class="grid-stack-item-content"><i class="fa fa-sort-amount-desc"></i> Multi-Select
                                </div>
                            </div>
                            <div class="list-group-item grid-stack-item red" data-fromtype="rediobuttons"
                                 data-components="basic">
                                <div class="grid-stack-item-content"><i class="fa fa-dot-circle-o"></i> Redio-Buttons
                                </div>
                            </div>
                            <div class="list-group-item grid-stack-item red" data-fromtype="checkbuttons"
                                 data-components="basic">
                                <div class="grid-stack-item-content"><i class="fa fa-check-square-o"></i> Check Boxes
                                </div>
                            </div>
                            <div class="list-group-item grid-stack-item green" data-fromtype="slider"
                                 data-components="advance">
                                <div class="grid-stack-item-content"><i class="fa fa-sliders"></i> Slider</div>
                            </div>
                            <div class="list-group-item grid-stack-item green" data-fromtype="password"
                                 data-components="basic">
                                <div class="grid-stack-item-content"><i class="fa fa-key"></i> password</div>
                            </div>
                            <div class="list-group-item grid-stack-item green" data-fromtype="file"
                                 data-components="basic">
                                <div class="grid-stack-item-content"><i class="fa fa-upload"></i> File Upload</div>
                            </div>
                            <div class="list-group-item grid-stack-item green" data-fromtype="phone"
                                 data-components="basic">
                                <div class="grid-stack-item-content"><i class="fa fa-phone"></i> Phone Number</div>
                            </div>
                            <div class="list-group-item grid-stack-item blue" data-fromtype="email"
                                 data-components="basic" data-gs-auto-position="true">
                                <div class="grid-stack-item-content"><i class="fa fa-envelope"></i> Email</div>
                            </div>

                            <div class="list-group-item grid-stack-item blue" data-fromtype="button"
                                 data-components="basic" data-gs-auto-position="true">
                                <div class="grid-stack-item-content"><i class="fa fa-send"></i> Button</div>
                            </div>

                            <div class="list-group-item grid-stack-item darkpink" data-fromtype="rating"
                                 data-components="advance">
                                <div class="grid-stack-item-content"><i class="fa fa-star-half-o"></i> Star Rating</div>
                            </div>
                            <div class="list-group-item grid-stack-item blue" data-fromtype="spinner"
                                 data-components="advance">
                                <div class="grid-stack-item-content"><i class="fa fa-exchange"></i> Spinner</div>
                            </div>
                            <div class="list-group-item grid-stack-item darkpink" data-fromtype="time"
                                 data-components="advance">
                                <div class="grid-stack-item-content"><i class="fa fa-clock-o"></i> Time</div>
                            </div>
                            <div class="list-group-item grid-stack-item darkpink" data-fromtype="date"
                                 data-components="advance">
                                <div class="grid-stack-item-content"><i class="fa fa-calendar-o"></i> Date</div>
                            </div>
                            <div class="list-group-item grid-stack-item darkpink" data-fromtype="autocomplete"
                                 data-components="advance">
                                <div class="grid-stack-item-content"><i class="fa fa-pencil"></i> Autocomplete</div>
                            </div>

                            <div class="list-group-item grid-stack-item blue" data-fromtype="multithumb"
                                 data-components="advance">
                                <div class="grid-stack-item-content"><i class="fa fa-picture-o"></i> Multi-Thumbs</div>
                            </div>
                            <div class="list-group-item grid-stack-item yellow" data-fromtype="multithumbselect"
                                 data-components="advance">
                                <div class="grid-stack-item-content"><i class="fa fa-picture-o"></i> Thumb Select</div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-9 p-t-15 p-r-15">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="btn-group" role="group"><a aria-controls="General" role="tab"
                                                                       data-toggle="tab"
                                                                       class="btn btn-default btn-dblue"> <i
                                                class="fa fa-mobile"></i> </a> <a aria-controls="General" role="tab"
                                                                                  data-toggle="tab"
                                                                                  class="btn btn-default btn-dblue"> <i
                                                class="fa fa-tablet"></i> </a> <a aria-controls="General" role="tab"
                                                                                  data-toggle="tab"
                                                                                  class="btn btn-default btn-dblue"> <i
                                                class="fa fa-laptop"></i> </a> <a aria-controls="General" role="tab"
                                                                                  data-toggle="tab"
                                                                                  class="btn btn-default btn-dblue active">
                                        <i class="fa fa-desktop"></i> </a></div>
                                <div class="btn-group" role="group"><a aria-controls="General" role="tab"
                                                                       data-toggle="tab"
                                                                       class="btn btn-default btn-dblue"
                                                                       data-action="view"> <i class="fa fa-eye"></i>
                                    </a></div>
                            </div>
                            <div class="col-md-4 text-center">
                                <a aria-controls="General" href=".step1" role="tab" data-toggle="tab" data-step="step1"
                                   class="btn btn-default btn-dblue active">Step 1</a>
                                <a href="#" data-action="addnewstep" class="btn btn-default btn-dblue"> <i
                                            class="fa fa-plus"></i> </a>
                                <a data-toggle="modal" data-target="#formsetting" href="#"
                                   class="btn btn-default btn-dgreen"> <i class="fa fa-gear"></i> </a>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn btn-default btn-danger-red btn-dgreen"
                                        data-toggle="modal" data-target="#themes"><i class="fa fa-paint-brush"></i>
                                    Themes
                                </button>
                                <button type="button" class="btn customeBtn collapsed" data-toggle="collapse"
                                        href="#codeCss">Custom CSS <i class="arrowDown"></i></button>
                            </div>
                        </div>
                        <div class="tab-content" data-step-container="stepcontainer">
                            <div class="tab-pane preview step1 active" role="tabpanel">
                                <div class="grid-stack grid-stack-12" id="grid1">

                                </div>


                                <div class="p-container hide">
                                    <div class="p-leftsection"></div>
                                    <div class="p-rightsection"><a class="blue" data-action="edit"><i
                                                    class="fa fa-pencil"></i></a> <a class="yellow" data-action="clone"><i
                                                    class="fa fa-clone"></i></a> <a class="red" data-action="delete"><i
                                                    class="fa fa-trash"></i></a></div>
                                </div>

                                <div class="p-t-20 text-center">
                                    <button type="button" class="btn add-content-btn" data-action="addFullContainer"><i
                                                class="fa fa-plus"></i></button>
                                </div>

                            </div>
                        </div>


                        <div class="p-10 m-t-40" style="border-top:solid 1px #ccc;">
                            <h5>Output of json
                                <small>After complating json work remove this</small>
                            </h5>
                            <textarea class="form-control" data-json="formoutput"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div data-formElement="all" class="hide">
                        <div data-fromelement="Singleline">
                            <div class="form-group datafrom" data-type="Singleline" data-size="col-sm-12">
                                <div class="row">
                                    <label for="singleline" data-fcontrol="label" class="col-sm-12 control-label">Singleline</label>
                                    <div data-fcontrol="input" class="col-sm-12">
                                        <input type="text" class="form-control" id="singleline"
                                               placeholder="singleline">
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="multiline">
                            <div class="form-group  datafrom" data-type="multiline">
                                <div class="row">
                                    <label for="multiline" data-fcontrol="label" class="col-sm-12 control-label">Multiline</label>
                                    <div data-fcontrol="input" class="col-sm-12">
                                        <textarea name="multiline" id="multiline" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="Select">
                            <div class="form-group datafrom" data-type="Select">
                                <div class="row">
                                    <label for="Select" data-fcontrol="label"
                                           class="col-sm-12 control-label">Select</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <select name="Select" class="form-control"
                                                data-content="Please select an option">
                                            <option value="0" selected="selected">--- Select ---</option>
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="multiSelect">
                            <div class="form-group datafrom" data-type="multiSelect">
                                <div class="row">
                                    <label for="multiSelect" data-fcontrol="label" class="col-sm-12 control-label">Multi
                                        Select</label>
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
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="rediobuttons">
                            <div class="form-group  datafrom" data-type="rediobuttons">
                                <div class="row">
                                    <label for="optionsRadios" data-fcontrol="label" class="col-sm-12 control-label">Redio
                                        buttons</label>
                                    <div data-fcontrol="input" class="col-sm-12">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios1"
                                                       value="Redio 1" checked>
                                                Redio 1</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios2"
                                                       value="Redio 2">
                                                Redio 2 </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios3"
                                                       value="Redio 3">
                                                Redio 3 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="checkbuttons">
                            <div class="form-group datafrom" data-type="checkbuttons">
                                <div class="row">
                                    <label for="optionsrecheck" data-fcontrol="label" class="col-sm-12 control-label">Check
                                        buttons</label>
                                    <div data-fcontrol="input">
                                        <div class="checkbox">
                                            <input type="checkbox" value="checkbox 1">
                                            <label> checkbox 1 </label>
                                        </div>
                                        <div class="checkbox">
                                            <input type="checkbox" value="checkbox 2">
                                            <label> checkbox 1 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="slider">
                            <div class="form-group datafrom" data-type="slider">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label">Slider</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <div class="slider"></div>
                                        <input type="range" name="slider" class="form-control hide" id="slider"
                                               hidden="hidden" value="50" min="0" max="100" step="1">
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="password">
                            <div class="form-group datafrom" data-type="password">
                                <div class="row">
                                    <label data-fcontrol="label" for="password" class="col-sm-12 control-label ">Password</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <input type="password" name="password" class="form-control" id="password"
                                               placeholder="password">
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="file">
                            <div class="form-group datafrom" data-type="file">
                                <div class="row" data-fcontrol="input">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">File Upload</label>
                                    <div class="col-sm-12">
                                        <input type="file" name="fileToUpload" class="form-control" id="fileToUpload">
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="phone">
                            <div class="form-group datafrom" data-type="phone">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">Phone Number</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                            <input type="number" name="phoneNumber" class="form-control"
                                                   id="phoneNumber">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>


                        <div data-fromelement="email">
                            <div class="form-group datafrom" data-type="email">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">Email</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                            <input type="email" name="email" class="form-control" id="email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>

                        <div data-fromelement="spinner">
                            <div class="form-group datafrom" data-type="spinner">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">Spinner</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <div class="input-group">
                                            <input type="text" name="spinner" data-min="0" data-max="100" data-step="2"
                                                   data-decimals="0" value="0" class="form-control spinner">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="rating">
                            <div class="form-group datafrom" data-type="rating">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">Star Rating</label>
                                    <div class="col-sm-12 f-s-8" data-fcontrol="input">
                                        <input type="text" class="rating rating-loading form-control" min="0" max="5"
                                               step="1" data-stars="5" data-show-clear="false" data-show-caption="false"
                                               data-size="xl" value="0"
                                               data-empty-star="<i class='glyphicon glyphicon-star-empty'></i>"
                                               data-filled-star="<i class='glyphicon glyphicon-star'></i>">
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>

                        <div data-fromelement="time">
                            <div class="form-group datafrom" data-type="time">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">Time</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <div class="input-group date time" data-language="en" data-formats="LT">
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                            <input type="text" class="form-control" placeholder="12:00 AM">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>

                        <div data-fromelement="date">
                            <div class="form-group datafrom" data-type="date">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">Date</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <div class="input-group date datepicker" data-format="YYYY/MM/DD hh:mm A"
                                             data-language="en">
                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>

                        <div data-fromelement="autocomplete">
                            <div class="form-group datafrom" data-type="autocomplete">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label">Autocomplete</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <input type="text" class="form-control autocomplete" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>

                        <div data-fromelement="button">
                            <div class="form-group datafrom" data-type="button" data-buttontext="Submit">
                                <div class="row">
                                    <div class="col-sm-12" data-fcontrol="input">
                                        <button type="button" class="btn btn-default">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>

                        <div data-fromelement="multithumb">
                            <div class="form-group datafrom" data-type="multithumb">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">Multi Thumbs</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                <span class="img-thumbnail">
                    <input class="checkbox" type="checkbox" name="multithumb" id="multithumb-1" value="1">
                    <span class="labelcontianer">Multi Thumb 1<img src="/public/img/images-img.jpg"></span>
                </span>
                                        <span class="img-thumbnail">
                    <input class="checkbox" type="checkbox" name="multithumb" id="multithumb-1" value="1">
                    <span class="labelcontianer">Multi Thumb 1<img src="/public/img/images-img.jpg"></span>
                </span>
                                        <span class="img-thumbnail">
                    <input class="checkbox" type="checkbox" name="multithumb" id="multithumb-1" value="1">
                    <span class="labelcontianer">Multi Thumb 1<img src="/public/img/images-img.jpg"></span>
                </span>

                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                        <div data-fromelement="multithumbselect">
                            <div class="form-group datafrom" data-type="multithumbselect">
                                <div class="row">
                                    <label data-fcontrol="label" class="col-sm-12 control-label ">Thumb Select</label>
                                    <div class="col-sm-12" data-fcontrol="input">
                <span class="img-thumbnail">
                    <input class="checkbox" type="radio" name="thumbselect" id="radios-1" value="1">
                    <span class="labelcontianer">Thumb 1<img src="/public/img/images-img.jpg"></span>
                </span>
                                        <span class="img-thumbnail">
                    <input class="checkbox" type="radio" name="thumbselect" id="radios-2" value="2">
                   	<span class="labelcontianer">Thumb 1<img src="/public/img/images-img.jpg"></span>
                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-rightsection"><a class="blue" data-action="edit"><i class="fa fa-pencil"></i></a>
                                <a class="yellow" data-action="clone"><i class="fa fa-clone"></i></a> <a class="red"
                                                                                                         data-action="delete"><i
                                            class="fa fa-trash"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="infos">

                </div>
            </section>
            <!--main content ends-->
        </aside>
    </div>
    </div>
    <div class="modal fade custom-modal" tabindex="-1" role="dialog" id="settingModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row toolbarNav">
                        <div class="col-md-8">
                            <div class="form-horizontal">
                                <div class="btn-group btn-group-justified" role="group" aria-label="..."
                                     data-tool-tab="btnpanel">
                                    <div class="btn-group" role="group"><a href=".general" aria-controls="General"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue active">General</a>
                                    </div>
                                    <div class="btn-group" role="group"><a href=".validation" aria-controls="validation"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue">Validation</a>
                                    </div>
                                    <div class="btn-group" role="group"><a href=".themetab" aria-controls="themetab"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue">Theme</a>
                                    </div>
                                    <div class="btn-group hide" role="group"><a href=".csstab" aria-controls="csstab"
                                                                                role="tab" data-toggle="tab"
                                                                                class="btn btn-default btn-dblue">css</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right"><a data-dismiss="modal" aria-label="Close"
                                                            class="btn btn-default btn-default-gray"
                                                            data-action="discard">Discard</a> <a href="#"
                                                                                                 class="btn btn-danger btn-danger-red"
                                                                                                 data-action="apply">Apply</a>
                            <input type="hidden" id="panelID" value="">
                        </div>
                    </div>
                    <div class='row row-eq-height'>
                        <div class='col-xs-6 left-side'>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane general active p-10" id="general"
                                     data-formsetting="setting">
                                </div>
                                <div role="tabpanel" class="tab-pane validation p-10" id="validation">
                                    <div class="form-inline col-md-12 p-0">
                                        <label for="exampleInputEmail1"><i class="fa fa-play mr-5 f-12"></i>
                                            Required</label>
                                        <div class="checkbox radio ml-20">
                                            <input type="radio" name="required" id="required" value="Yes"
                                                   data-field="required">
                                            <label for="required" class="control-label">Yes</label>
                                        </div>
                                        <div class="checkbox radio ml-20">
                                            <input type="radio" name="required" id="required-no" value="No"
                                                   data-field="required">
                                            <label for="required-no" class="control-label">No</label>
                                        </div>
                                    </div>
                                    <div class="form-inline col-md-10  p-0">
                                        <label for="exampleInputEmail1">Indicator</label>
                                        <select class="form-control customFormSelect ml-20"
                                                data-field="validateindicator" data-width="auto">
                                            <option value="">Browser Icon</option>
                                            <option data-icon="glyphicon-asterisk" value="glyphicon-asterisk">asterisk
                                            </option>
                                            <option data-icon="glyphicon-star" value="glyphicon-star">Star</option>
                                            <option data-icon="glyphicon-star-empty" value="glyphicon-star-empty">Star
                                                Empty
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-inline col-md-10 p-0">
                                        <label for="exampleInputEmail1"><i class="fa fa-play mr-5 f-12"></i> Validate As</label>
                                        <select class="form-control customFormSelect ml-20" data-field="validateas"
                                                data-width="auto">
                                            <option selected="selected" value="">Any Format</option>
                                            <option value="email">Email</option>
                                            <option value="url">URL</option>
                                            <option value="phone_number">Phone Number</option>
                                            <option value="numbers_only">Numbers Only</option>
                                            <option value="text_only">Text Only</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-10  p-0">
                                        <label for="errorMessage"><i class="fa fa-play mr-5 f-12"></i> Error
                                            Message</label>
                                        <input type="email" class="form-control" id="errorMessage"
                                               placeholder="Please enter a value" data-field="errorMessage">
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane themetab " id="themetab">
                                    <div class="form-inline col-md-12 p-0">
                                        <div class="dib wid-50">
                                            <label for="editClassname"><i class="fa fa-play mr-5 f-12"></i> Class
                                                Name</label>
                                        </div>
                                        <input type="text" class="form-control" id="editClassname"
                                               data-field="classname" placeholder="Default">
                                    </div>
                                    <div class="form-inline col-md-12 p-0">
                                        <div class="dib wid-50">
                                            <label for="loadsetting"><i class="fa fa-play mr-5 f-12"></i> Load
                                                Setting</label>
                                        </div>
                                        <select class="form-control customFormSelect" data-field="loadsetting"
                                                data-width="auto">
                                            <option value="default">Default</option>
                                            <option value="theme1">Setting 1</option>
                                            <option value="theme2">Setting 2</option>
                                        </select>
                                    </div>
                                    <div class="form-inline col-md-12 p-0">
                                        <div class="dib wid-50">
                                            <label for="labelposition"><i class="fa fa-play mr-5 f-12"></i> Label
                                                Position</label>
                                        </div>
                                        <div class="btn-group theme-btn-group label-Position" role="group"
                                             aria-label="...">
                                            <button type="button" class="btn btn-default left"><i
                                                        class="fa fa-arrow-left"></i></button>
                                            <button type="button" class="btn btn-default top"><i
                                                        class="fa fa-arrow-up"></i></button>
                                            <button type="button" class="btn btn-default right"><i
                                                        class="fa fa-arrow-right"></i></button>
                                            <button type="button" class="btn btn-default none"><i
                                                        class="fa fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-inline col-md-12 p-0">
                                        <div class="dib wid-50">
                                            <label for="TextAlignment"><i class="fa fa-play mr-5 f-12"></i> Text
                                                Alignment</label>
                                        </div>
                                        <div class="btn-group align-label" role="group" aria-label="...">
                                            <button type="button" class="btn btn-default left"><i
                                                        class="fa fa-align-left"></i></button>
                                            <button type="button" class="btn btn-default center"><i
                                                        class="fa fa-align-center"></i></button>
                                            <button type="button" class="btn btn-default right"><i
                                                        class="fa fa-align-right"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-inline col-md-12 p-0">
                                        <div class="dib wid-50">
                                            <label for="Textsize"><i class="fa fa-play mr-5 f-12"></i> Text Size</label>
                                        </div>
                                        <select class="form-control customFormSelect" data-field="textsize"
                                                data-width="auto">
                                            <option value="f-s-15">Meduim</option>
                                            <option value="f-s-12">Small</option>
                                        </select>
                                    </div>
                                    <div class="form-inline col-md-12 p-0">
                                        <div class="dib wid-50">
                                            <label for="inputColor"><i class="fa fa-play mr-5 f-12"></i> Input
                                                Color</label>
                                        </div>
                                        <div class="dib vt mr-5">Background</div>
                                        <div class="dib vt mr-5">
                                            <div class="input-group input-color csscolor-picker"
                                                 data-colortype="input-background">
                                                <input type="text" class="form-control hide" id="editbackground"
                                                       data-field="input-background" placeholder="Text here" value="">
                                                <div class="input-group-addon"><i></i></div>
                                            </div>
                                        </div>
                                        <div class="dib vt mr-5">Border</div>
                                        <div class="dib vt mr-5">
                                            <div class="input-group input-color csscolor-picker"
                                                 data-colortype="input-border-color">
                                                <input type="text" class="form-control hide" id="editbordercolor"
                                                       data-field="input-border-color" placeholder="Text here" value="">
                                                <div class="input-group-addon"><i></i></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-inline col-md-12 p-0">
                                        <div class="dib wid-50">
                                            <label for="Textsize"><i class="fa fa-play mr-5 f-12"></i> Input text Color</label>
                                        </div>
                                        <div class="dib vt mr-5">Color</div>
                                        <div class="dib vt mr-5">
                                            <div class="input-group input-color csscolor-picker"
                                                 data-colortype="input-color">
                                                <input type="text" class="form-control hide" id="editcolor"
                                                       data-field="input-color" placeholder="Text here" value="">
                                                <div class="input-group-addon"><i></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline col-md-12 p-0">
                                        <div class="dib wid-50">
                                            <label for="inputanimation"><i class="fa fa-play mr-5 f-12"></i>
                                                Animation</label>
                                        </div>

                                        <select class="form-control customFormSelect" data-field="animation-name"
                                                data-width="auto">
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
                                        <input type="text" class="form-control small-theme-text" id=""
                                               data-field="animation-delay" placeholder="0.1" value="0.1">
                                        <label for="animationDuration" class="ml-20">Duration</label>
                                        <input type="text" class="form-control small-theme-text" id=""
                                               data-field="animation-duration" placeholder="0.1" value="0.9">
                                    </div>
                                    <hr class="p-t-10">
                                    <div class="form-inline col-md-12 p-0 text-right">

                                        <button type="button" class="btn btn-default btn-success"
                                                data-action="saveassetting">Save as new Setting
                                        </button>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane csstab  p-10" id="csstab">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editbackground" class="width-150"><i
                                                        class="fa fa-play mr-5 f-12"></i>Background Color</label>
                                            <div class="input-group input-color csscolor-picker"
                                                 data-colortype="background">
                                                <input type="text" class="form-control hide" id="editbackground"
                                                       data-field="background" placeholder="Text here" value="">
                                                <div class="input-group-addon"><i></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editcolor" class="width-150"><i
                                                        class="fa fa-play mr-5 f-12"></i>Color</label>
                                            <div class="input-group input-color csscolor-picker" data-colortype="color">
                                                <input type="text" class="form-control hide" id="editcolor"
                                                       data-field="color" placeholder="Text here" value="">
                                                <div class="input-group-addon"><i></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editBackgound" class="width-150"><i
                                                        class="fa fa-play mr-5 f-12"></i>Border Color</label>
                                            <div class="input-group input-color csscolor-picker"
                                                 data-colortype="border-color">
                                                <input type="text" class="form-control hide" id="editBackgound"
                                                       data-field="border-color" placeholder="Text here" value="">
                                                <div class="input-group-addon"><i></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editpadding" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>Padding</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="padding-top"></div>
                                                <input type="text" class="form-control hide" id="editpadding"
                                                       data-field="padding-top" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editpaddingbottom" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>Padding-bottom</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="padding-bottom"></div>
                                                <input type="text" class="form-control hide" id="editpaddingbottom"
                                                       data-field="padding-bottom" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editpaddingleft" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>Padding-Left</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="padding-left"></div>
                                                <input type="text" class="form-control hide" id="editpaddingleft"
                                                       data-field="padding-left" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editpaddingright" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>Padding-right</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="padding-right"></div>
                                                <input type="text" class="form-control hide" id="editpaddingright"
                                                       data-field="padding-right" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-xs-6 right-side popuppreview p-t-40'>
                            <div data-frompre='preview'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>

    <div class="modal fade custom-modal rowedit" tabindex="-1" role="dialog" id="rowedit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row toolbarNav">
                        <div class="col-md-8">
                            <div class="form-horizontal">
                                <div class="btn-group btn-group-justified" role="group" aria-label="..."
                                     data-tool-tab="btnpanel">
                                    <div class="btn-group" role="group"><a href=".rowbackground" aria-controls="General"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue active">Background</a>
                                    </div>
                                    <div class="btn-group" role="group"><a href=".margins" aria-controls="margins"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue">Margins</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right"><a data-dismiss="modal" aria-label="Close"
                                                            class="btn btn-default btn-default-gray"
                                                            data-action="discard">Discard</a> <a href="#"
                                                                                                 class="btn btn-danger btn-danger-red"
                                                                                                 data-action="applyrow">Apply</a>

                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xs-6 left-side'>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane rowbackground active p-10" id="rowbackground">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editbackground" class="width-150"><i
                                                        class="fa fa-play mr-5 f-12"></i>Background Color</label>
                                            <div class="input-group input-color csscolor-picker"
                                                 data-colortype="background">
                                                <input type="text" class="form-control hide" id="editbackground"
                                                       data-field="background" placeholder="Text here" value="">
                                                <div class="input-group-addon"><i></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editBackgound" class="width-150"><i
                                                        class="fa fa-play mr-5 f-12"></i>Border Color</label>
                                            <div class="input-group input-color csscolor-picker"
                                                 data-colortype="border-color">
                                                <input type="text" class="form-control hide" id="editBackgound"
                                                       data-field="border-color" placeholder="Text here" value="">
                                                <div class="input-group-addon"><i></i></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane margins  p-10" id="csstab">
                                    <h5>Edges Margins:</h5>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editpadding" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>From Top</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="editfromtop" data-slidertype="from-top"></div>
                                                <input type="text" class="form-control hide" id="editfromtop"
                                                       data-field="from-top" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editfrombottom" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>From-bottom</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="from-bottom"></div>
                                                <input type="text" class="form-control hide" id="editfrombottom"
                                                       data-field="from-bottom" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editfromright" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>From-Right</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="from-right"></div>
                                                <input type="text" class="form-control hide" id="editfromright"
                                                       data-field="from-right" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editFromleft" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>From-Left</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="from-left"></div>
                                                <input type="text" class="form-control hide" id="editFromleft"
                                                       data-field="from-left" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <h5>Inner Margins:</h5>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="edithorizontal" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>horizontal</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="horizontal"></div>
                                                <input type="text" class="form-control hide" id="edithorizontal"
                                                       data-field="horizontal" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label for="editvertical" class="col-xs-6 width-150 p-l-0 "><i
                                                        class="fa fa-play mr-5 f-12"></i>Vertical</label>
                                            <div class="col-xs-6 p-t-10">
                                                <div class="filedSlider" data-slidertype="vertical"></div>
                                                <input type="text" class="form-control hide" id="editvertical"
                                                       data-field="vertical" placeholder="Text here" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-xs-6 right-side popuppreview p-t-40'>
                            <div data-frompre='rowpreview' class="boxpreivewRow row" style="padding:0;">
                                <div class="col-xs-6" style="padding:0;">
                                    <div class="boxpreivew bg-blue-lighter"></div>
                                </div>
                                <div class="col-xs-6" style="padding:0;">
                                    <div class="boxpreivew bg-black-lighter"></div>
                                </div>
                                <div class="col-xs-6" style="padding:0;">
                                    <div class="boxpreivew bg-red-lighter"></div>
                                </div>
                                <div class="col-xs-6" style="padding:0;">
                                    <div class="boxpreivew bg-green-lighter"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->


    <div class="modal fade custom-modal formsetting" tabindex="-1" role="dialog" id="formsetting">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row toolbarNav">
                        <div class="col-md-8">
                            <div class="form-horizontal">
                                <div class="btn-group btn-group-justified" role="group" aria-label="..."
                                     data-tool-tab="btnpanel">
                                    <div class="btn-group" role="group"><a href=".onSubmitFrom" aria-controls="General"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue active">On
                                            submit</a></div>
                                    <div class="btn-group" role="group"><a href=".hiddenfields" aria-controls="margins"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue">Hidden
                                            Fields</a></div>
                                    <div class="btn-group" role="group"><a href=".formRule" aria-controls="margins"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue">Rule</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right"><a data-dismiss="modal" aria-label="Close"
                                                            class="btn btn-default btn-default-gray"
                                                            data-action="discard">Discard</a> <a href="#"
                                                                                                 class="btn btn-danger btn-danger-red"
                                                                                                 data-action="applysetpssetting"
                                                                                                 data-dismiss="modal">Apply</a>

                        </div>
                    </div>
                    <div class='row'>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane onSubmitFrom active p-10" id="onSubmitFrom">
                                <div class="form-horizontal">
                                    <div class="form-group m-0">
                                        <label for="postaction" class="col-xs-3 control-label">Post Action</label>
                                        <div class="col-sm-9 form-inline">
                                            <div class="checkbox radio">
                                                <input type="radio" name="postactions" id="postactions1"
                                                       data-post-action="postaction" value="ajax" checked> <label
                                                        for="postactions1"> Ajax</label>
                                            </div>
                                            <div class="checkbox radio">
                                                <input type="radio" name="postactions" id="postactions2"
                                                       data-post-action="postaction" value="custom"> <label
                                                        for="postactions2"> Custom</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="hide" data-postaction-container="ajax">
                                        <div class="form-group m-0">
                                            <label for="postaction" class="col-xs-3 control-label">After Submit</label>
                                            <div class="col-sm-9 form-inline">
                                                <div class="checkbox radio">
                                                    <input type="radio" name="afterSubmit" id="afterSubmit1"
                                                           data-post-action="afterSubmit" value="showMessage" checked>
                                                    <label for="afterSubmit1"> Show Message</label>
                                                </div>
                                                <div class="checkbox radio">
                                                    <input type="radio" name="afterSubmit" id="afterSubmit2"
                                                           data-post-action="afterSubmit" value="redirect"> <label
                                                            for="afterSubmit2"> Redirect</label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group m-0 hide" data-afterSubmit-container="redirect">
                                            <label for="postaction" class="col-xs-3 control-label">Redirect to</label>
                                            <div class="col-sm-9">

                                                <input type="text" class="form-control" id="redirectto"
                                                       name="redirectto" placeholder="Redirect to">

                                            </div>
                                        </div>

                                        <div class="form-group m-0 hide" data-afterSubmit-container="showMessage">
                                            <label for="postaction" class="col-xs-3 control-label">On-screen
                                                confirmation message</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control"
                                                          placeholder="On-screen confirmation message"></textarea>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="hide" data-postaction-container="custom">
                                        <div class="form-group m-0">
                                            <label for="postaction" class="col-xs-3 control-label">Submmision
                                                method</label>
                                            <div class="col-sm-9 form-inline">
                                                <div class="checkbox radio">
                                                    <input type="radio" name="submmisionmethod" id="submmisionmethod1"
                                                           value="post" checked> <label for="submmisionmethod1">
                                                        Post</label>
                                                </div>
                                                <div class="checkbox radio">
                                                    <input type="radio" name="submmisionmethod" id="submmisionmethod2"
                                                           value="get"> <label for="submmisionmethod2">Get</label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="postaction" class="col-xs-3 control-label">Submit form
                                                to</label>
                                            <div class="col-sm-9">

                                                <input type="text" class="form-control" name="submitfromto"
                                                       id="submitfromto" placeholder="Submit form to">

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane hiddenfields  p-10" id="hiddenfields">
                                <div data-container="addHiddenField">

                                </div>
                                <button class="btn btn-default btn-default-gray" type="button"
                                        data-action="addHiddenField"><i class="fa fa-plus"></i> Add Hidden Field
                                </button>

                            </div>
                            <div role="tabpanel" class="tab-pane formRule  p-10" id="formRule">
                                <div data-container="addnewrule">

                                </div>
                                <button class="btn btn-default btn-default-gray" type="button"
                                        data-action="addruleField"><i class="fa fa-plus"></i> Add New Rule
                                </button>
                                <div class="hide">
                                    <div class="row" data-html="newCondition">
                                        <div class="form-group col-xs-4 p-0 p-r-5">
                                            <label for="FieldName" class="sr-only">Field Name</label>
                                            <select class="form-control" name="conditions">
                                                <option selected="selected" value="any"> Field</option>
                                            </select></div>
                                        <div class="form-group col-xs-4 p-0 p-r-5">
                                            <label for="FieldName" class="sr-only">Condition</label>
                                            <select class="form-control" name="conditions">
                                                <option selected="selected" value="any"> Condition</option>
                                            </select></div>
                                        <div class="form-group col-xs-2 p-0 p-r-5">
                                            <label for="FieldName" class="sr-only">Value</label>
                                            <input class="form-control" placeholder="value"/>
                                        </div>
                                        <div class="form-group col-xs-2 p-0">
                                            <button class="btn btn-default" type="button" data-action="removeField"><i
                                                        class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="panel panel-default" data-html="newrule">
                                        <div class="panel-heading">
                                            <button class="btn btn-default pull-right btn-xs" type="button"
                                                    data-action="removeRule"><i class="fa fa-times"></i></button>
                                            Rule
                                        </div>
                                        <div class="panel-body p-l-0 p-r-0">
                                            <div class="col-xs-6">
                                                <h6>
                                                    IF
                                                    <select class="form-control" name="selector"
                                                            style="width:20%; float:none !important; display: inline">
                                                        <option selected="selected" value="any"> any</option>
                                                        <option value="all"> all</option>
                                                    </select>
                                                    of these conditions are true
                                                </h6>
                                                <div data-container="newCondition"></div>
                                                <button class="btn btn-default" type="button"
                                                        data-action="addCondition"><i class="fa fa-plus"></i> Add
                                                    Condition
                                                </button>
                                            </div>
                                            <div class="col-xs-6">
                                                <h6>THEN</h6>
                                                <button class="btn btn-default" type="button" data-action="addAction"><i
                                                            class="fa fa-plus"></i> Add Action
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>

    <div class="modal fade custom-modal" tabindex="-1" role="dialog" id="themes">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row toolbarNav">
                        <div class="col-md-8">
                            <div class="form-horizontal">
                                <div class="btn-group btn-group-justified" role="group" aria-label="..."
                                     data-tool-tab="btnpanel">
                                    <div class="btn-group" role="group"><a href=".themesetting" aria-controls="General"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue active">Themes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right"><a data-dismiss="modal" aria-label="Close"
                                                            class="btn btn-default btn-default-gray"
                                                            data-action="discard">Discard</a> <a href="#"
                                                                                                 class="btn btn-danger btn-danger-red"
                                                                                                 data-action="applythemes"
                                                                                                 data-dismiss="modal">Apply</a>

                        </div>
                    </div>
                    <div class='row'>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane themesetting active  p-10" id="themesetting">
                                <div class="form-group">
                                    <label for="ChooseColorScheme"><i class="fa fa-play mr-5 f-12"></i> Choose Color
                                        Theme </label>
                                    <select class="form-control customFormSelect" data-width="auto"
                                            data-field="choosetheme">
                                        <option value="default">Boostrap (default)</option>
                                    </select>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>

    </div>
    <input value="{!! config('config.MODULE_PATH') !!}" hidden="hidden" data-path="module">


    <!-- /.modal -->
@section('CSS')

    {!! HTML::style('js/bootstrap-select/css/bootstrap-select.min.css') !!}
    {!! HTML::style('js/Bootstrap-Form-Builder3/assets/css/custom.css') !!}
    {!! HTML::style('js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}
    {!! HTML::style('js/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css') !!}
    {!! HTML::style('js/bootstrap-star-rating/css/star-rating.css') !!}
    {!! HTML::style('js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
    {!! HTML::style('js/gridstack/css/gridstack.min.css') !!}
    {!! HTML::style('js/animate/css/animate.css') !!}

    {!! HTML::style('css/form-builder.css?v=4.82') !!}
    <style data-css="load"></style>
@stop
@section('JS')
    {!! HTML::script('js/bootstrap-select/js/bootstrap-select.min.js') !!}
    {!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/lodash.js/3.5.0/lodash.min.js') !!}
    {!! HTML::script('js/gridstack/js/gridstack2.min.js') !!}
    {!! HTML::script('js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('js/bootstrap-touchspin/js/jquery.bootstrap-touchspin.js') !!}
    {!! HTML::script('js/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') !!}
    {!! HTML::script('js/bootstrap-datetimepicker/js/moment.min.js') !!}
    {!! HTML::script('js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('js/bootstrap-validator/js/validator.js') !!}
    {!! HTML::script('js/bootstrap-star-rating/js/star-rating.js') !!}
    <script>
        var form ={!!$form_json or null!!};

        if (form.form_data) {
            $('[data-json="formoutput"]').val(form.form_data)
            $('#formname').val(form.name)
        }
        console.log(form);
    </script>
    {!! HTML::script('js/form-builder.js?v=6.83') !!}
    <script>
        $("document").ready(function () {

            $(document).on('click', '#fapencil', function (event) {
                $('#settingModal').modal('show')
            });
//            $("#build").html('<form class="form-horizontal"><fieldset><legend>Form Name</legend></fieldset><button id="singlebutton" name="singlebutton" class="btn btn-primary">Button</button></form>');
            $('body').on('click', '.create-new-form', function () {
                var form_name = $('#form_name').val();
                var html = $('#build').html();
                $.ajax({
                    type: "post",
                    url: "/admin/builders/forms/new",
                    cache: false,
                    datatype: "json",
                    data: {name: form_name, html: html},
                    headers: {
                        'X-CSRF-TOKEN': $("#token").val()
                    },
                    success: function (data, response) {
                        if (!data.error) {
                            window.location.href = "/admin/builders/forms";
                        }
                    }
                });
            });
            $('.navbar-tabs').on('click', 'li', function () {
                $('.bulder-form').hide();
                $('.settings').hide();
                $('.logic').hide();
                var className = $(this).attr('data-value');
                $('.' + className).show();
                console.log(className);
            });
        });
    </script>
@stop

@stop
