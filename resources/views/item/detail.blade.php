@extends('adminlte::page')

@section('content_header')
    <h1>商品詳細</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            
            <div class="row row-cols-2 row-cols-md-2 g-4">
            @foreach($items as $item)
            <div class="col">
                <div class="card">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <label for="maker">メーカー</label>
                    <p class="card-text">{{$item->maker}}</p>
                    <label for="maker">商品名</label>
                    <p class="card-text">{{$item->item_name}}</p>
                    <label for="maker">サイズ</label>
                    <p class="card-text">{{$item->size}}</p>
                    <label for="maker">値段</label>
                    <p class="card-text">{{$item->price}}円</p>
                    <label for="maker">在庫数</label>
                    <p class="card-text">{{$item->stock}}</p>
                    <label for="maker">備考</label>
                    <p class="card-text">{{$item->remarks}}</p>                    
                </div>
                <a href="edit/{{$item->id}}" class="btn btn-default">編集</a>
                <a href="{{ url('items/delete') }}" class="btn btn-outline-danger">削除</a>
                </div>
            </div>
            @endforeach
            </div>
            
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
