@extends('adminlte::page')

@section('title', '販売登録')

@section('content_header')
    <h1>販売登録</h1>
@stop

        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
            <div class="bg-primary text-white w-100">
                {{ session('flash_message') }}
            </div>
        @endif

@section('content')

    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif
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
                                    <form method="GET" action="{{url('search/sell')}}">
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
                                <tr data-widget="expandable-table" aria-expanded="false" >
                                    <td>{{ $item->maker }}</td>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td></td>
                                    <td><i class="fa fa-plus"></i><td>
                                </tr>
                                <tr class="expandable-body">
                                <td colspan="5">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th>サイズ</th>
                                        <th>値段</th>
                                        <th>足数</th>
                                        <th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($items as $detail)
                                        <form method="POST" action="{{url('sell/add')}}">
                                        @csrf
                                        <tr>
                                        @if ($detail['item_name'] === $item['item_name'])   
                                        <td>{{$detail->size}}</td>
                                        <td><input type="hidden" class="form-control w-25" id="number" name="price" value="{{$detail->price}}" placeholder="数量">{{$detail->price}}</td>
                                        <td><input type="text" class="form-control w-25" id="number" name="number" placeholder="数量"></td>
                                        <td><input type="hidden" name="item_id" value="{{$detail->id}}"></td>
                                        <td><button class="btn btn-primary" type="submit">登録</button></td>
                                    @endif
                                        </form>
                                        </tr>
                                    @endforeach
                                        
                                    </tbody>
                                    </table>
                                </td>
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