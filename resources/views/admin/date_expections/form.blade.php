<div class="form-group{{ $errors->has('questions') ? ' has-error' : ''}}">
    {!! Form::label('questions', ' Questions: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('questions', $question->questions, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('questions', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('option_1') ? ' has-error' : ''}}">
    {!! Form::label('option_1', 'Option 1: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::textarea('option_1', $question->options[0]->option, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('option_1', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('option_2') ? ' has-error' : ''}}">
    {!! Form::label('option_2', 'Option 2: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::textarea('option_2', $question->options[1]->option, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('option_2', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('option_3') ? ' has-error' : ''}}">
    {!! Form::label('option_3', 'Option 3: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::textarea('option_3', $question->options[2]->option, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('option_3', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group" style="margin-top:28px;">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>