@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>売上目標履歴</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">個人売上目標</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('sell/goal') }}" class="btn btn-default">売上目標登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>年月</th>
                                <th>目標金額</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historys as $history)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($history->date)->format('Y年m月') }}</td>
                                    <td>{{ $history->goal }}円</td>
                                    <td><a href="/sell/myhistory/edit/{{$history->id}}" class="btn btn-default">編集</a></td>
                                    <td><a href="/sell/myhistory/delete/{{$history->id}}" class="btn btn-outline-danger">削除</a></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">{{ $historys->links() }}</td>
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