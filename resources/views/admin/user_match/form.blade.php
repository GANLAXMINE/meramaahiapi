<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('name', ' Name: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('name', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
    {!! Form::label('email', 'Email: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::email('email', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('gender') ? ' has-error' : ''}}">
    {!! Form::label('gender', 'Gender: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('gender', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required', 'maxlength' => 8]) !!}
    {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
</div>


 <div class="form-group{{ $errors->has('dob') ? ' has-error' : ''}}">
    {!! Form::label('dob', 'DOB: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    @if(isset($user))
    {!! Form::text('dob', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required' , 'autocomplete'=>'off']) !!}
    @else
    {!! Form::text('dob', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required' , 'autocomplete'=>'off']) !!}
    @endif
    {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
    {!! Form::label('password', 'Password: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    @php
        $passwordOptions = ['class' => 'form-control border border-2 p-2 bg-light'];
        if ($formMode === 'create') {
            $passwordOptions = array_merge($passwordOptions, ['required' => 'required']);
        }
    @endphp
    {!! Form::password('password', $passwordOptions) !!}
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group" style="margin-top:28px;">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
<script>
    function limitInput() {
        var inputField = document.getElementById("quantity");
        if (inputField.value.length >= 8) {
            inputField.value = inputField.value.slice(0, 8); // Limit to 8 digits
            inputField.blur(); // Remove focus from the input field
        }
    }
</script>

