@extends('adminlte::page')

@section('title', 'お知らせ入力')

@section('content_header')
    <h1>お知らせ入力</h1>
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
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="goal">タイトル</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="タイトル">
                        </div>

                        <div class="form-group">
                            <label for="date">内容</label>
                            <textarea class="form-control" id="content" name="content"></textarea>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
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