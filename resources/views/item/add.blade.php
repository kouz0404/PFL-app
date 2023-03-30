<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
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
                            <label for="maker">メーカー</label>
                            <select  class="form-control" id="maker" name="maker" placeholder="メーカー">
                                <option hidden>メーカーを選択してください</option>
                                <option value="Nike">Nike</option>
                                <option value="adidas">adidas</option>
                                <option value="new balance">new balance</option>
                                <option value="VANS">VANS</option>
                                <option value="converse">converse</option>
                                <option value="Reebok">Reebok</option>
                                <option value="asics">asics</option>
                                <option value="puma">puma</option>
                                <option value="FILA">FILA</option>
                                <option value="Dr.Martiens">Dr.Martiens</option>
                                <option value="Timberland">Timberland</option>
                                <option value="UGG">UGG</option>
                                <option value="GUCCI">GUCCI</option>
                                <option value="BALENCIAGA">BALENCIAGA</option>
                                <option value="LOUIS VUITTON">LOUIS VUITTON</option>
                                <option value="PRADA">PRADA</option>
                                <option value="DIOR">DIOR</option>
                                <option value="crocs">crocs</option>
                                <option value="Mizuno">Mizuno</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="item_name">商品名</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" placeholder="商品名">
                        </div>

                        <div class="form-group">
                            <label for="size">サイズ</label>
                            <select class="form-control" id="size" name="size" >
                                <option hidden>サイズを選択してください</option>
                                <option value="21">21cm</option>
                                <option value="21.5">21.5cm</option>
                                <option value="22">22cm</option>
                                <option value="22.5">22.5cm</option>
                                <option value="23">23cm</option>
                                <option value="23.5">23.5cm</option>
                                <option value="24">24cm</option>
                                <option value="24.5">24.5cm</option>
                                <option value="25">25cm</option>
                                <option value="25.5">25.5cm</option>
                                <option value="26">26cm</option>
                                <option value="26.5">26.5cm</option>
                                <option value="27">27cm</option>
                                <option value="27.5">27.5cm</option>
                                <option value="28">28cm</option>
                                <option value="28.5">28.5cm</option>
                                <option value="29">29cm</option>
                                <option value="29.5">29.5cm</option>
                                <option value="30">30cm</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">値段</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="値段">
                        </div>

                        <div class="form-group">
                            <label for="stock">在庫数</label>
                            <input type="text" class="form-control" id="stock" name="stock" placeholder="在庫数">
                        </div>

                        <div class="form-group">
                            <label for="remarks">備考</label>
                            <textarea type="text" class="form-control" id="remarks" name="remarks" placeholder="備考"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="item_image">商品画像</label>
                            <div class="form-control-img">
                            <input type="file" class="" id="inputFile" name="item_image">
                            </div>
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
@stop

@section('js')
@stop
