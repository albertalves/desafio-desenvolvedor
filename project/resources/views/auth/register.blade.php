@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card my-5 p-5 shadow">
      <h1>Registre-se</h1>
      <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="mb-3">
          <label for="name">Nome</label>
          <input type="name" id="name" name="name" class="form-control">

          @error('name')
            <div>{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control">

          @error('email')
            <div>{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password">Senha</label>
          <input type="password" id="password" name="password" class="form-control">

          @error('password')
            <div>{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password_confirmation">Confirmar Senha</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">

          @error('password_confirmation')
            <div>{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <button type="submit" class="btn btn-primary mb-3">Registrar</button>
        </div>

        @if (session('status'))
          <div>{{ session('status') }}</div>
        @endif
  </div>
</div>
@endsection