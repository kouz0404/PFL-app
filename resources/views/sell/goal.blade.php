@extends('adminlte::page')

@section('title', '売上目標登録')

@section('content_header')
    <h1>売上目標</h1>
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
                            <label for="goal">目標金額</label>
                            <input type="text" class="form-control" id="goal" name="goal" placeholder="目標金額">
                        </div>

                        <div class="form-group">
                            <label for="date">目標年月</label>
                            <input type="month" class="form-control" id="date" name="date">
                        </div>
                        

                        <div class="form-group">
                            <label for="class">区分</label>
                            <select class="form-control" id="class" name="class" >
                                <option hidden hidden value="">区分</option>
                                <option value="0">店舗</option>
                                <option value="1">個人</option>
                            </select>
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