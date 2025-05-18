@extends('layout')

@section('content')
<div class="container">
    <h2>Crear Pedido</h2>
    <form method="POST" action="{{ route('store') }}">
        @csrf
        <div class="mb-3">
            <label for="client_id" class="form-label">Cliente</label>
            <input type="number" class="form-control" name="client_id" required>
        </div>
        <div class="mb-3">
            <label for="sale_date" class="form-label">Sale Date</label>
            <input type="date" class="form-control" name="sale_date" required>
        </div>
        <div class="mb-3">
            <label for="articles_id" class="form-label">Artículos </label>
            <input type="text" class="form-control" name="articles_id" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Monto</label>
            <input type="number" class="form-control" name="amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Pedido</button>
    </form>
</div>
@endsection
