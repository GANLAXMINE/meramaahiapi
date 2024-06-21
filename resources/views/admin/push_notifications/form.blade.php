<div class="form-group{{ $errors->has('title') ? ' has-error' : ''}}">
    {!! Form::label('title', 'Title:', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('title', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('body') ? ' has-error' : ''}}">
    {!! Form::label('body', 'Body:', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('body', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('body', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group" style="margin-top:28px;">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Send', ['class' => 'btn btn-primary','id' => 'sendButton']) !!}
</div>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
            </div>
            <div class="modal-body">
                Notifications sent successfully!
            </div>
        </div>
    </div>
</div>
<script>
    // Wait for document to be ready
    $(document).ready(function() {
        // Add click event listener to the send button
        $('#sendButton').click(function() {
            // Show the success modal
            $('#successModal').modal('show');
        });
    });
</script>