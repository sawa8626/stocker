@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    アイテム登録フォーム
                </div>
                <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('items.store') }}">
                @csrf
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">アイテム名</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="inputName" placeholder="アイテム名">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputGenre" class="col-sm-3 col-form-label">ジャンル</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" name="genre" id="inputGenre" placeholder="ジャンル">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPrice" class="col-sm-3 col-form-label">価格(¥)</label>
                        <div class="col-sm-9">
                        <input type="number" class="form-control" name="price" id="inputPrice" placeholder="価格">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputDate" class="col-sm-3 col-form-label">使用開始日</label>
                        <div class="col-sm-9">
                        <input type="date" class="form-control" name="start_day" id="inputDate">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">登録する</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
