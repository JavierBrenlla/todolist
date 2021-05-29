{{-- {{ dd($datos) }} --}}
@extends('plantillas.master')
@section('titulo', Auth::user()->name)

@section('central')
    <crear-lista listaid="{{ $id }}" userid="{{ auth()->user()->id }}"></crear-lista>
    @for ($i = 0; $i < count($datos); $i++)
        <a href="/lista/{{ $datos[$i]->lista_id }}">
            <div class="lista proyectos">
                <p>{{ $datos[$i]->nombre }} <span class="numero-tareas"></span></p>
                <hr>
                <p>{{ $datos[$i]->descripcion }}</p>
            </div>
        </a>
        <compartir-elemento listaid="{{ $id }}" opcion="1"></compartir-elemento>
    @endfor
@endsection
