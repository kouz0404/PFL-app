@extends('adminlte::page')

@section('title', '売上目標登録')

@section('content_header')
    <h1>売上目標編集</h1>
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
                <form method="POST" action="{{url('sell/myhistory/edit')}}"  enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="goal">目標金額</label>
                            <input type="text" class="form-control" id="goal" name="goal" placeholder="目標金額" value="{{$history_detail->goal}}">
                        </div>

                        <div class="form-group">
                            <label for="date">目標年月</label>
                            <input type="month" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::parse($history_detail->date)->format('Y-m') }}" readonly>
                        </div>
                        

                        <div class="form-group">
                            <label for="class">区分</label>
                            <select class="form-control" id="class" name="class" readonly >
                                @if($history_detail->class === 1)
                                <option hidden  >個人</option>
                                @elseif($history_detail->class === 0)
                                <option hidden  >店舗</option>
                                @endif

                            </select>
                        </div>

                        <input type="hidden" class="form-control" id="id" name="id"  value="{{$history_detail->id}}">

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