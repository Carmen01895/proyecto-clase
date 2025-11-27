@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Generación de Reportes</h2>

    <form action="{{ route('reportes.pdf') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-4">
                <label>Estatus</label>
                <select name="estatus_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($estatus as $e)
                        <option value="{{ $e->id }}">{{ $e->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Auxiliar</label>
                <select name="auxiliar_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($auxiliares as $a)
                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Departamento</label>
                <select name="departamento_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($departamentos as $d)
                        <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-primary mt-4">
            Generar PDF
        </button>
    </form>
</div>
@endsection

