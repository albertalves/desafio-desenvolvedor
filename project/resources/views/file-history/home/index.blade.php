@extends('layouts.app')

@section('content')
  <div class="container">
	<div class="card my-5 p-5 shadow">
		<form action="{{ route('file-history.index') }}" method="GET" class="row g-3 d-flex justify-content-end">
			<div class="col-auto">
			<input type="text" class="form-control" name="name" value="{{ $name }}" placeholder="Nome">
			</div>
			<div class="col-auto">
			<input type="date" class="form-control" name="created_at" value="{{ $createdAt }}" placeholder="Data de referência">
			</div>
			<div class="col-auto">
			<button type="submit" class="btn btn-primary mb-3">Buscar</button>
			</div>
			<div class="col-auto">
			<a href="{{ route('file-data.index') }}" class="btn btn-secondary">
				Voltar para a home
			</a>
			</div>
		</form>
		<table class="table table-sm">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Nome</th>
					<th scope="col">Data</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($fileHistory as $item)
					<tr>
						<td> {{ $item->id }} </td>
						<td> {{ $item->name }} </td>
						<td> {{ $item->created_at }} </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
  </div>
@endsection