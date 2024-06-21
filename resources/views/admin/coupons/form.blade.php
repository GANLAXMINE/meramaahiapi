<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('name', ' Name: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('name', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('description') ? ' has-error' : ''}}">
    {!! Form::label('description', 'Description: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('description', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required']) !!}
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
    {!! Form::label('type', ' Type: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::select('type', $types, null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => 'required', 'placeholder' => 'Select a types']) !!}
    {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('code') ? ' has-error' : ''}}">
    {!! Form::label('code', 'Coupon Code: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('code', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => '' ]) !!}
    {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('discount_amount') ? ' has-error' : ''}}">
    {!! Form::label('discount_amount', 'Discount Amount: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::number('discount_amount', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => '']) !!}
    {!! $errors->first('discount_amount', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('min_amount') ? ' has-error' : ''}}">
    {!! Form::label('min_amount', 'Min Amount: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::number('min_amount', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => '']) !!}
    {!! $errors->first('min_amount', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('start_date') ? ' has-error' : ''}}">
    {!! Form::label('start_date', 'Start Date: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('start_date', null, ['class' => 'form-control border border-2 p-2 bg-light', 'id' => 'start_date']) !!}
    {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('end_date') ? ' has-error' : ''}}">
    {!! Form::label('end_date', 'End Date: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::text('end_date', null, ['class' => 'form-control border border-2 p-2 bg-light', 'id' => 'end_date']) !!}
    {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('usage_limit') ? ' has-error' : ''}}">
    {!! Form::label('usage_limit', 'Usage Limit: ', ['class' => 'control-label text-dark font-weight-bold pt-3']) !!}
    {!! Form::number('usage_limit', null, ['class' => 'form-control border border-2 p-2 bg-light', 'required' => '']) !!}
    {!! $errors->first('usage_limit', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group" style="margin-top:28px;">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

<script>
    $(document).ready(function() {
        $('#start_date').datetimepicker({
            format: 'Y-m-d H:i:s',
            step: 30,
            onChangeDateTime: function(selectedDate) {
                $('#end_date').datetimepicker('setOptions', {
                    minDate: selectedDate
                });
            }
        });
        $('#end_date').datetimepicker({
            format: 'Y-m-d H:i:s',
            step: 30,
            onChangeDateTime: function(selectedDate) {
                $('#start_date').datetimepicker('setOptions', {
                    maxDate: selectedDate
                });
            }
        });
    });
</script>