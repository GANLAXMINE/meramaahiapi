<div class="form-group{{ $errors->has('question') ? ' has-error' : ''}}">
    {!! Form::label('question', 'Question: ', ['class' => 'control-label']) !!}
    {!! Form::text('question', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('question', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('answer') ? ' has-error' : ''}}">
    {!! Form::label('answer', 'Answer: ', ['class' => 'control-label']) !!}
    {!! Form::textarea('answer', null, ['class' => 'ckeditor form-control', 'required' => 'required']) !!}
    {!! $errors->first('answer', '<p class="help-block">:message</p>') !!}
</div>

<!-- Additional language-specific fields -->

<!-- @php
$languages = ['hi','ja', 'es', 'fr', 'it', 'ru', 'de'];
@endphp

@foreach ($languages as $lang)
<div class="form-group{{ $errors->has('question_' . $lang) ? ' has-error' : ''}}">
    {!! Form::label('question_' . $lang, 'Question (' . strtoupper($lang) . '): ', ['class' => 'control-label']) !!}
    {!! Form::text('question_' . $lang, null, ['class' => 'form-control']) !!}
    {!! $errors->first('question_' . $lang, '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('answer_' . $lang) ? ' has-error' : ''}}">
    {!! Form::label('answer_' . $lang, 'Answer (' . strtoupper($lang) . '): ', ['class' => 'control-label']) !!}
    {!! Form::textarea('answer_' . $lang, null, ['class' => 'ckeditor form-control']) !!}
    {!! $errors->first('answer_' . $lang, '<p class="help-block">:message</p>') !!}
</div>
@endforeach -->

<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });
</script>