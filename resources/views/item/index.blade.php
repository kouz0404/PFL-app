@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>メーカー</th>
                                <th>商品名</th>
                                <th class="search">
                                    <form method="GET" action="{{url('search')}}">
                                    <div class="input-group">
                                    <input type="text" id="txt-search" class="form-control input-group-prepend" name="search" placeholder="検索ワード"></input>
                                    <span class="input-group-btn input-group-append">
                                        <button type="submit" id="btn-search" class="btn btn-primary"><i class="fas fa-search"></i> 検索</buttom>
                                    </span>
                                    </div>
                                    </form>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items->unique('item_name') as $item)
                                <tr>
                                    <td>{{ $item->maker }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td><a href="items/detail/{{$item->item_name}}" class="btn btn-default">詳細画面</a></td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td colspan="3">{{ $items->links() }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">在庫数残りわずか</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>メーカー</th>
                                <th>商品名</th>
                                <th>在庫数</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items->unique('item_name') as $item)
                                <tr>
                                    @if($item->stock <= 5)
                                    <td>{{ $item->maker }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->stock }}</td>
                                    <td><a href="items/detail/{{$item->item_name}}" class="btn btn-default">詳細画面</a></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('js')
@stop
