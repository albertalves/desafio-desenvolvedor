@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card my-5 p-5 shadow">
      <h1>Login</h1>
      <form method="POST" action="{{ route('login.store') }}" name="login">
        @csrf

        <div class="mb-3">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control">

          @error('email')
            <div>{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" class="form-control">

          @error('password')
            <div>{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <button type="submit" class="btn btn-primary mb-3">Login</button>
        </div>
        
        <div>
          <p>
            Não tem uma conta? <a href="{{ route('register') }}">Registre-se</a>
          </p>
        </div>
        @if (session('status'))
          <div>{{ session('status') }}</div>
        @endif
  </div>
</div>
@endsection