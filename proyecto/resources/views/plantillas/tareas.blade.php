{{-- {{ dd($listaID) }} --}}
@extends('plantillas.master')
@section('titulo',Auth::user()->name)

@section('central')
<crear-tarea listaid="{{ $listaID }}"></crear-tarea>
@php
    $cabeceras = array("nombre", "descripcion") 
@endphp
<table class="table table-striped table-dark">
    <tr>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Acciones</th>
    </tr>
    @for ($i = 0; $i < count($tareas); $i++)
        <tr>
            @foreach ($cabeceras as $cabecera)
                <td>{{ $tareas[$i]->$cabecera }}</td>
            @endforeach
        </tr>
    @endfor
</table>
@endsection