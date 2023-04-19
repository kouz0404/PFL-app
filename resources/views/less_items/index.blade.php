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
                                <th>サイズ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($less_items as $less_item)
                                <tr>
                                    @if($less_item->stock <= 5)
                                    <td>{{ $less_item->maker }}</td>
                                    <td>{{ $less_item->item_name }}</td>
                                    <td>{{ $less_item->stock }}</td>
                                    <td>{{ $less_item->size }}</td>
                                    <td><a href="items/detail/{{$less_item->item_name}}" class="btn btn-default">詳細画面</a></td>
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
