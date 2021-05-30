{{-- {{ dd($listas) }} --}}
@extends('plantillas.master')
@section('titulo', Auth::user()->name)

@section('central')
<example-component id="btn-crear"></example-component>
{{-- @for ($i = 0; $i < count($listas); $i++)
<a href="/lista/{{ $listas[$i]['lista_id'] }}">
    <div class="lista proyectos">
        <p>{{ $listas[$i]['nombre'] }} <span class="numero-tareas"></span></p>
        <hr>
        <p>{{ $listas[$i]['descripcion'] }}</p>
    </div>
</a>
<div class="acciones">
<span><compartir-elemento listaid="{{ $listas[$i]['lista_id'] }}" opcion="1" class="share"></compartir-elemento></span>
<span><borrar-componente proyectoid="{{ $listas[$i]['lista_id'] }}" opcion="1" class="delete"></borrar-componente></span>
</div>
@endfor --}}
<listar-listas id="listar-listas"></listar-listas>
@endsection