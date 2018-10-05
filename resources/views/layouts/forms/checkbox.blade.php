
{{-- error class --}}
@section('errorClass')
    {{$errorClass}}
@overwrite

{{-- error message --}}
@section('errorMessage')
    @if($errorMgs != "")
        @include('layouts.forms.errors')
    @endif
@overwrite

{{-- label --}}
@section('label')
    {!! Form::label($field, $label) !!} @if($required) <span class="required">*</span> @endif
@overwrite

{{-- input --}}
@section('input')
    {!! Form::checkbox($field, '1', $value, ['id' => $field]) !!}
    {!! Form::label($field, $label) !!}
@overwrite

{{-- input extra classes --}}
@section('input_class')
    switch round
@overwrite

@include('layouts.forms.row')
