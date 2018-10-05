
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
    {!! Form::textarea($field, $value, ['class'=>'form-control','rows'=>'3']) !!}
@overwrite

{{-- input extra classes --}}
@section('input_class')

@overwrite

@include('layouts.forms.row')
