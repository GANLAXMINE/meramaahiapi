<div class="form-group{{ $errors->has('slug') ? ' has-error' : ''}}">
    {!! Form::label('slug', ' Personality Type: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('slug', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('short_description_en') ? ' has-error' : ''}}">
    {!! Form::label('short_description_en', 'Short Description: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::textarea('short_description_en', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('short_description_en', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('description_en') ? ' has-error' : ''}}">
    {!! Form::label('description_en', 'Description: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::textarea('description_en', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('description_en', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group" style="margin-top:28px;">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
