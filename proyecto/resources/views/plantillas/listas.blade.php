{{-- {{ dd($datos) }} --}}
@extends('plantillas.master')
@section('titulo', Auth::user()->name)

@section('central')
    <crear-lista listaid="{{ $id }}" userid="{{ auth()->user()->id }}" id="btn-lista"></crear-lista>
    {{-- @for ($i = 0; $i < count($datos); $i++)
        <a href="/lista/{{ $datos[$i]->lista_id }}">
            <div class="lista proyectos">
                <p>{{ $datos[$i]->nombre }} <span class="numero-tareas"></span></p>
                <hr>
                <p>{{ $datos[$i]->descripcion }}</p>
            </div>
        </a>
        <div class="acciones">
        <span><compartir-elemento listaid="{{ $id }}" opcion="1" class="share"></compartir-elemento></span>
        <span><borrar-componente proyectoid="{{ $datos[$i]->lista_id }}" opcion="1" class="delete"></borrar-componente></span>
    </div>
    @endfor --}}
    <listas-proyectos listaid="{{ $id }}"></listas-proyectos>
@endsection
