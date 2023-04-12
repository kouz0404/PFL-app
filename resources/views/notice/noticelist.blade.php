@extends('adminlte::page')

@section('title', 'お知らせ')

@section('content_header')
    <h1>お知らせ</h1>
@stop

<style>
        .user {
            font-size: 3px;
            text-align: right;
            margin: 0;
        }
</style>

@section('content')
<div class="card">
  <div class="card-header">
    <h5>{{$notice->title}}</h5>
  </div>
  <div class="card-body">
    <h5 class="card-title"></h5>
    <p class="card-text">{{$notice->content}}</p><br>
    <p class="user">投稿者:{{$notice->user->name}}</p>
  </div>
  <div class="card-footer text-muted">
    @if(Auth::id() == $notice->user_id)
    <a href="/notice/list/edit/{{$notice->id}}" class="btn btn-primary">編集</a>
    <a href="/notice/list/delete/{{$notice->id}}" class="btn btn-outline-danger">削除</a>
    @endif
  </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('js')
@stop



