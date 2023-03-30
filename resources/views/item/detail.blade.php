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

            @foreach($items as $item)
            <div class="card card-primary">

                    <div class="card-body">

                        <div class="form-group">
                            <label for="maker">メーカー</label>
                            <p>{{$item->maker}}</p>
                        </div>

                        <div class="form-group">
                            <label for="item_name">商品名</label>
                            <p>{{$item->item_name}}</p>
                        </div>

                        <div class="form-group">
                            <label for="item_name">サイズ</label>
                            <p>{{$item->size}}</p>
                        </div>

                        <div class="form-group">
                            <label for="price">値段</label>
                            <p>{{$item->price}}</p>
                        </div>

                        <div class="form-group">
                            <label for="stock">在庫数</label>
                            <p>{{$item->stock}}</p>
                        </div>

                        <div class="form-group">
                            <label for="remarks">備考</label>
                            <p>{{$item->remarks}}</p>
                        </div>

                        <div class="form-group">
                            <label for="item_image">商品画像</label>
                            <image src="/storage/{{$item->item_image}}" alt=""></image>
                        </div>


                    </div>


            </div>
            @endforeach
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
