<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create new form</h4>
            </div>
            <div class="modal-body">

                {!!Form::open(['class'=>'form-horizontal','id'=>'new-form-form'])!!}
                <fieldset>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">Form name</label>  
                        <div class="col-md-4">
                            <input id="form-name" name="name" type="text" placeholder="placeholder" class="form-control input-md">
                        </div>
                    </div>
                </fieldset>
                {!!Form::close()!!}
                <ol id='form-messages'>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary " id='create-form'>Save changes</button>
            </div>
        </div>
    </div>
</div>
