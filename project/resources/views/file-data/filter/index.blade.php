@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card my-5 p-5 shadow">
      <form action="{{ route('file-data.list') }}" method="GET" class="row g-3 d-flex justify-content-end">
        <div class="col-auto">
          <input type="text" class="form-control" name="tckr_symb" value="{{$tckrSymb}}" placeholder="TckrSymb">
        </div>
        <div class="col-auto">
          <input type="date" class="form-control" name="rpt_dt" value="{{$rptDt}}" placeholder="RptDt">
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
            <th scope="col">RptDt</th>
            <th scope="col">TckrSymb</th>
            <th scope="col">MktNm</th>
            <th scope="col">SctyCtgyNm</th>
            <th scope="col">ISIN</th>
            <th scope="col">CrpnNm</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($fileData as $item)
            <tr>
              <td> {{ $item->rpt_dt }} </td>
              <td> {{ $item->tckr_symb }} </td>
              <td> {{ $item->mkt_nm }} </td>
              <td> {{ $item->scty_ctgy_nm }} </td>
              <td> {{ $item->isin }} </td>
              <td> {{ $item->crpn_mm }} </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <!-- Links de paginação -->
      <div class="d-flex justify-content-center mt-4">
          {{ $fileData->links('pagination::bootstrap-5') }}
      </div>
    </div>
</div>
@endsection