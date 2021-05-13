{{ dd($datos) }}
@extends('plantillas.master')
@section('titulo',Auth::user()->name)

@section('central')
<example-component id="btn-crear"></example-component>
@endsection