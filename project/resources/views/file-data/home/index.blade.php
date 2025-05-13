@extends('layouts.app')

@section('content')
  <div class="container">
    @if(auth()->check())
      <div class="mt-5 text-center">
        <h1>Olá {{ auth()->user()->name }}, Bem-vindo ao sistema de importação de dados!</h1>
        <p>
          Este sistema permite importar arquivos CSV e visualizar os dados
          importados.
        </p>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-outline-danger">Sair</button>
        </form>
      </div>
    @endif
    <div class="card my-5 p-5 shadow">
      <div class="d-flex justify-content-between">
        <h3>Importar Arquivo</h3>
        <a href="{{ route('file-data.list') }}" class="btn btn-primary">
          Listar Dados
        </a>
        <a href="{{ route('file-history.index') }}" class="btn btn-secondary">
          Ver histórico de uploads
        </a>
      </div>
      <form action="{{ route('file-data.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group my-4">
          <input type="file" class="form-control" id="file" name="file">
          <button type="submit" class="btn btn-outline-success">
            Importar
          </button>
        </div>
      </form>

      @if ($errors->any())
        <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
            {{ $errors->first() }}
          @endforeach
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif
    </div>
  </div>
@endsection