{{-- {{ dd(sizeof($tareas)) }} --}}
@extends('plantillas.master')

@section('titulo', Auth::user()->name)

@section('central')
<crear-tarea listaid="{{ $listaID }}"></crear-tarea>
@endsection
    
@if (sizeof($tareas)!=0)

@section('contenido')
    @php
    $cabeceras = ['nombre'];
    @endphp
    <table class="table table-striped table-dark">
        <tr>
            <th>Tarea</th>
            <th>Acciones</th>
        </tr>
        @for ($i = 0; $i < count($tareas); $i++)
            <tr>
                @foreach ($cabeceras as $cabecera)
                    <td>{{ $tareas[$i]->$cabecera }}</td>
                    <td><div><button id="{{ $tareas[$i]->id }}"><span class="material-icons-outlined">
                        done
                    </span></button></div></td>
                @endforeach
            </tr>
        @endfor
    </table>
    <input type="hidden" name="listaId" id="listaId" value="{{ $tareas[0]->lista_id }}">
    @endif
    @section('scripts')
    <script src="{{ asset('js/tareas.js') }}"></script>
    @endsection
    @endsection
