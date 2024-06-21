<div class="form-group{{ $errors->has('category') ? ' has-error' : ''}}">
    {!! Form::label('category', ' Category: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('category', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('questions') ? ' has-error' : ''}}">
    {!! Form::label('questions', 'Questions: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('questions', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('questions', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('description') ? ' has-error' : ''}}">
    {!! Form::label('description', 'Description: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('option_1') ? ' has-error' : ''}}">
    {!! Form::label('option_1', 'Option 1: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('option_1', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => '' ]) !!}
    {!! $errors->first('option_1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('option_2') ? ' has-error' : ''}}">
    {!! Form::label('option_2', 'Option 2: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('option_2', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => '']) !!}
    {!! $errors->first('option_2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('option_3') ? ' has-error' : ''}}">
    {!! Form::label('option_3', 'Option 3: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('option_3', null, ['class' => 'form-control border border-2 p-2 bg-light',]) !!}
    {!! $errors->first('option_3', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('option_4') ? ' has-error' : ''}}">
    {!! Form::label('option_4', 'Option 4: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('option_4', null, ['class' => 'form-control border border-2 p-2 bg-light']) !!}
    {!! $errors->first('option_4', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('option_5') ? ' has-error' : ''}}">
    {!! Form::label('option_5', 'Option 5: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('option_5', null, ['class' => 'form-control border border-2 p-2 bg-light']) !!}
    {!! $errors->first('option_5', '<p class="help-block">:message</p>') !!}
</div>
<!-- <div class="form-group{{ $errors->has('question_types') ? ' has-error' : ''}}">
    {!! Form::label('question_types', 'Question Types: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('question_types', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('question_types', '<p class="help-block">:message</p>') !!}
</div> -->
<div class="form-group{{ $errors->has('option_types') ? ' has-error' : '' }}">
    {!! Form::label('option_types', ' Question Types: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::select('option_types', $questionTypes, null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required', 'placeholder' => 'Select a question types']) !!}
    {!! $errors->first('option_types', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group" style="margin-top:28px;">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
<!-- <script>
    function limitInput() {
        var inputField = document.getElementById("quantity");
        if (inputField.value.length >= 8) {
            inputField.value = inputField.value.slice(0, 8); // Limit to 8 digits
            inputField.blur(); // Remove focus from the input field
        }
    }
</script> -->