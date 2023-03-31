@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品編集</h1>
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

            <div class="card card-primary">
                <form action="{{url('items/edit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <input type="hidden" class="form-control" id="maker" name="id" value="{{$item->id}}" >

                        <div class="form-group">
                            <label for="maker">メーカー</label>
                            <input type="text" class="form-control" id="maker" name="maker" value="{{$item->maker}}" >
                        </div>

                        <div class="form-group">
                            <label for="item_name">商品名</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" value="{{$item->item_name}}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="size">サイズ</label>
                            <input type="text" class="form-control" id="size" name="size" value="{{$item->size}}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="price">値段</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{$item->price}}" >
                        </div>

                        <div class="form-group">
                            <label for="stock">在庫数</label>
                            <input type="text" class="form-control" id="stock" name="stock" value="{{$item->stock}}">
                        </div>

                        <div class="form-group">
                            <label for="remarks">備考</label>
                            <textarea type="text" class="form-control" id="remarks" name="remarks" placeholder="備考"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="item_image">商品画像</label>
                            <div class="form-control-img">
                            <input type="file" class="" id="inputFile" name="item_image">
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">編集</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('js')
@stop
