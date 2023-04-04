@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>販売管理</h1>
@stop

@section('content')
<div class="col-md-6 col-sm-6">
      <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">

            <p class="card-category">総売上</p>
            
            <h3 class="card-title">{{$proceeds}}円</h3>
            
          </div>
          <div class="card-footer">
              <div class="stats ">
              <button type="button" onclick="location.href='sell/add'" class="btn btn-outline-success w-100">販売登録</button>
              </div>
          </div>
      </div>
  </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">販売管理</h3>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-6">

<div class="card card-primary card-outline">
<div class="card-header">
<h3 class="card-title">
<i class="far fa-chart-bar"></i>
Bar Chart
</h3>
<div class="card-tools">
<button type="button" class="btn btn-tool" data-card-widget="collapse">
<i class="fas fa-minus"></i>
</button>
<button type="button" class="btn btn-tool" data-card-widget="remove">
<i class="fas fa-times"></i>
</button>
</div>
</div>
<div class="card-body">
<div id="bar-chart" style="height: 300px;"></div>
</div>

</div>
 

<div class="card card-primary card-outline">
<div class="card-header">
<h3 class="card-title">
@stop


@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('js')
@stop
