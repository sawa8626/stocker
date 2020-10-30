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
                    <li class="list-group-item">使用中：{{ $item->using_number }}個</li>
                    <li class="list-group-item">在庫（未使用）：{{ $item->stock_number }}個</li>
                    <li class="list-group-item">平均使用日数：{{ $item->use_term_avg }}日</li>
                    <li class="list-group-item">推定残量：
                        @if(!isset($item->remaining_amount))
                            初使用のため算出不可
                        @elseif($item->remaining_amount < 0)
                            平均使用日数を超過
                        @else
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $item->remaining_amount }}%;" aria-valuenow="{{ $item->remaining_amount }}" aria-valuemin="0" aria-valuemax="100">{{ $item->remaining_amount }}%</div>
                        </div>
                        @endif
                    </li>
                </ul>
                <div class="card-body">
                    @if($item->stock_number !== 0)
                        <a class="btn btn-outline-primary" href="{{ $item->id }}/start" role="button">使用開始</a>
                    @endif
                    @if($item->using_number !== 0)
                        <a class="btn btn-outline-dark" href="{{ $item->id }}/end" role="button">使切り</a>
                    @endif
                    <a class="btn btn-outline-success" href="{{ $item->id }}/add" role="button">在庫追加</a>
                    @if($item->using_number !== 0 && $item->stock_number !== 0)
                        <a class="btn btn-outline-secondary" href="{{ $item->id }}/exchange" role="button">交換</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
