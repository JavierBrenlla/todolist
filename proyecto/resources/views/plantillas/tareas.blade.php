{{-- {{ dd($tareas) }} --}}
@extends('plantillas.master')

@section('titulo', Auth::user()->name)

@section('central')
    <crear-tarea listaid="{{ $tareas }}"></crear-tarea>
    <listar-tareas listaid="{{ $tareas }}"></listar-tareas>
@endsection

{{-- @if (sizeof($tareas) != 0)

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
                        <td>
                            <div><button id="completar{{ $tareas[$i]->id }}"><span class="material-icons-outlined">
                                        done
                                    </span></button>
                                <button id="borrar{{ $tareas[$i]->id }}"><span class="material-icons-outlined">
                                        delete_forever
                                    </span></button>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endfor
        </table>
        <input type="hidden" name="listaId" id="listaId" value="{{ $tareas[0]->lista_id }}">
        @endsection
    @endif --}}
    @section('scripts')
        <script src="{{ asset('js/tareas.js') }}"></script>
    @endsection
