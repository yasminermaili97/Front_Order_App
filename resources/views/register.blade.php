@extends('layout')

@section('title', 'Register')

@section('content')
<h2>Registro</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Contraseña</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button class="btn btn-success">Registrarse</button>
</form>
@endsection
