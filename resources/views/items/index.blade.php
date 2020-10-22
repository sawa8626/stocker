@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach($items as $item)
        <div class="col-md-4 p-3 mb-3">
            <div class="card shadow rounded">
                <div class="card-header">
                    {{ $item->name }}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">価格：{{ $item->price }}円</li>
                    <li class="list-group-item">使用中：個</li>
                    <li class="list-group-item">在庫（未使用）：個</li>
                    <li class="list-group-item">平均使用日数：日</li>
                </ul>
                <div class="card-body">
                    <a class="btn btn-outline-primary" href="#" role="button">使用開始</a>
                    <a class="btn btn-outline-success" href="#" role="button">在庫追加</a>
                    <a class="btn btn-outline-secondary" href="#" role="button">交換</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
