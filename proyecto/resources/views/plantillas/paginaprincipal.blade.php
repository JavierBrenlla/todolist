@extends('plantillas.master')
@section('titulo',Auth::user()->name)

@section('central')
<example-component></example-component>
@endsection
    