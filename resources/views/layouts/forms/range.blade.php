
<?php
$to = $to == "9999" ? date("Y") : $to;
$range = [];
for($x=$from; $x<=$to; $x++)
{
    $range[$x] = $x;
}
?>


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
    {!! Form::select($field, array('' => 'select ...') + $range, $value, ['class'=>'form-control']) !!}
@overwrite

{{-- input extra classes --}}
@section('input_class')

@overwrite

{{-- input extra classes --}}
@section('input_class')

@overwrite

@include('layouts.forms.row')
