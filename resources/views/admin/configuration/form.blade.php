<div class="form-group{{ $errors->has('terms_of_use') ? ' has-error' : '' }}">
    {!! Form::label('terms_of_use', 'Term and Conditions', ['class' => 'control-label']) !!}
    {!! Form::textarea('terms_of_use', null, ['class' => 'form-control summernote_tos', 'required' => ($formMode === 'edit' ? 'required' : '')]) !!}
    {!! $errors->first('terms_of_use', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('privacy_policy') ? ' has-error' : '' }}">
    {!! Form::label('privacy_policy', 'Privacy Policy', ['class' => 'control-label']) !!}
    {!! Form::textarea('privacy_policy', null, ['class' => 'form-control summernote_pp', 'required' => ($formMode === 'edit' ? 'required' : '')]) !!}
    {!! $errors->first('privacy_policy', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('about_us') ? ' has-error' : '' }}">
    {!! Form::label('about_us', 'About Us', ['class' => 'control-label']) !!}
    {!! Form::textarea('about_us', null, ['class' => 'form-control summernote_au', 'required' => ($formMode === 'edit' ? 'required' : '')]) !!}
    {!! $errors->first('about_us', '<p class="help-block">:message</p>') !!}
</div>

<!-- @php
$languages = ['hi','ja', 'es', 'fr', 'it', 'ru', 'de'];
@endphp

@foreach ($languages as $lang)
<div class="form-group{{ $errors->has('terms_of_use_' . $lang) ? ' has-error' : '' }}">
    {!! Form::label('terms_of_use_' . $lang, 'Term and Conditions (' . strtoupper($lang) . '): ', ['class' => 'control-label']) !!}
    {!! Form::textarea('terms_of_use_' . $lang, null, ['class' => 'form-control summernote_tos', '' => ($formMode === 'edit' ? 'required' : '')]) !!}
    {!! $errors->first('terms_of_use_' . $lang, '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('privacy_policy_' . $lang) ? ' has-error' : '' }}">
    {!! Form::label('privacy_policy_' . $lang, 'Privacy Policy (' . strtoupper($lang) . '): ', ['class' => 'control-label']) !!}
    {!! Form::textarea('privacy_policy_' . $lang, null, ['class' => 'form-control summernote_pp', '' => ($formMode === 'edit' ? 'required' : '')]) !!}
    {!! $errors->first('privacy_policy_' . $lang, '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('about_us_' . $lang) ? ' has-error' : '' }}">
    {!! Form::label('about_us_' . $lang, 'About Us (' . strtoupper($lang) . '): ', ['class' => 'control-label']) !!}
    {!! Form::textarea('about_us_' . $lang, null, ['class' => 'form-control summernote_au', '' => ($formMode === 'edit' ? 'required' : '')]) !!}
    {!! $errors->first('about_us_' . $lang, '<p class="help-block">:message</p>') !!}
</div>
@endforeach -->

<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>