
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
    {!! Form::label($field, $label) !!}
    @if($required) <span class="required">*</span> @endif
    @if($info)
        <span data-toggle='tooltip' data-placement='top' title='{{$info}}'>
         <i class="ft icon-info"></i>
      </span>
    @endif
@overwrite

{{-- input --}}
@section('input')
    <div class="input-group date">
        <input id="{{$field}}" name="{{$field}}" type="text" class="form-control" value="{{$value}}"><span class="input-group-addon"><i class="ft icon-calendar"></i></span>
    </div>
@overwrite

{{-- input extra classes --}}
@section('input_class')

@overwrite

@include('layouts.forms.row')
