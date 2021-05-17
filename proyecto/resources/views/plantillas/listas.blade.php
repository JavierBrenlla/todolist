{{-- {{ dd($datos) }} --}}
@extends('plantillas.master')
@section('titulo',Auth::user()->name)

@section('central')
<crear-lista listaid="{{ $id }}"></crear-lista>
@for ($i = 0; $i < count($datos); $i++)
    <div class="lista">
        <p>{{ $datos[$i]->nombre }} <span class="numero-tareas"></span></p>
        <hr>
        <p>{{ $datos[$i]->descripcion }}</p>
    </div>
@endfor
@endsection