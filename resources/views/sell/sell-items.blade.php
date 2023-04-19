@extends('adminlte::page')

@section('title', '販売商品一覧')

@section('content_header')
    <h1>販売した商品一覧</h1>
@stop

@section('content')

<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$d}}の販売した商品</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr class="sell-log">
                                <th>メーカー</th>
                                <th>商品名</th>
                                <th>単価</th>
                                <th>足数</th>
                                <th>追加日</th>
                                <th class="search"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($sells as $sell)
                                <tr>
                                    <td>{{ $sell->maker }}</td>
                                    <td>{{ $sell->item_name }}</td>
                                    <td>{{ $sell->price}}円</td>
                                    <td>{{ $sell->number}}</td>
                                    <td>{{$sell->created_at->format('Y-m-d')}}</td>
                                    <td><a href="/sell/sell_items/delete/{{$sell->id}}" class="btn btn-outline-danger">削除</a></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="7">{{ $sells->links() }}</td>
                            </tr>
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