@extends('layout')

@section('title', 'Pedidos')

@section('content')



@foreach($user as $user)
<h2>Bienvenido, {{ $user['name'] ?? 'Usuario' }}</h2>
@endforeach

<form method="POST" action="{{ route('logout') }}" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-danger m-2" style="float: right;">
        Cerrar sesión
    </button>
</form>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if ($errors->has('cancel'))
<div class="alert alert-danger">
    {{ $errors->first('cancel') }}
</div>
@endif


<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Fecha</th>
            <th>Artículos</th>
            <th>Monto</th>
            <th>Cliente</th>
            <th>Teléfono</th>
            <th>Prime</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order['id'] }}</td>
            <td>{{ $order['status'] }}</td>
            <td>{{ $order['sale_date'] }}</td>
            <td>{{ $order['articles_id'] }}</td>
            <td>{{ $order['amount'] }}</td>
            <td>{{ $order['client']['name'] ?? 'N/A' }}</td>
            <td>{{ $order['client']['phone'] ?? 'N/A' }}</td>
            <td>{{ $order['client']['prime'] ? 'Sí' : 'No' }}</td>
            <td>
                @if ($order['status'] === 'CREATED')
                <form action="{{ route('cancel', $order['id']) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar este pedido?');">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                </form>
                @else
                <span class="text-muted">No disponible</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a class="btn btn-primary" href="{{ route('create') }}">Crear Pedido</a>
@endsection