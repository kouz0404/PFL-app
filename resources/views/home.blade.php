@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop

@section('content')


<div class="first-view"></div>

<div class="img-frame">
   <div class="img-01"></div>
   <div class="img-02"></div>
   <div class="img-03"></div>
</div>

<div class="wrapper">
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="http://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/move02/3-2-3-1/js/3-2-3-1.js"></script>

    <div class="information">
        <h2>Information</h2>
        <div class="topicks">
            <ul>
                @foreach($notices as $notice)
                <a href="/notice/list/{{$notice->id}}"><li>{{$notice->title}}/{{ \Carbon\Carbon::parse($notice->updated_at)->format('m月d日') }}更新</li></a>
                @endforeach
            </ul>
        </div>
    </div>


   <div class="newarrival">
        <h2>NewArrival</h2>
        <div class="newarrive-box">
            <div class=" new-item-1">
                <a href="https://www.nike.com/jp/w/jordan-shoes-37eefzy7ok"> <img src="img/jordan.jpg"></a>
                <p>Nike/Ari jordan</p>
            </div>

            <div class="new-item-1">
                <a href="https://www.nike.com/jp/w/air-force-1-shoes-5sj3yzy7ok?vst=Air%20Force%201"><img src="img/force.jpg"></a>
                <p>Nike/Air Force</p>
            </div>

            <div class="new-item-1">
                <a href="https://www.nike.com/jp/w?q=blazer&vst=blazer"><img src="img/brazer.jpg"></a>
                <p>Nike/Blazer</p>
            </div>
        </div>
   </div>


    <div class="tools">
    <h2>Tools</h2>
        <div class="tool-list">
            <div class="tool">
                <div class="tool-1">
                    <img src="img/stock.jpg" alt="商品一覧" />
                    <a href="/items">
                    <div class="hover-mask">
                    <p>商品一覧</p>
                    </div>
                    </a>
                </div>
            <p>商品一覧</p>
            </div>



            <div class="tool">
                <div class="tool-1">
                    <img src="img/register.jpg" alt="販売管理" />
                    <a href="/sell">
                    <div class="hover-mask">
                    <p>販売管理</p>
                    </div>
                    </a>
                </div>
            <p>販売管理</p>
            </div>
        </div>

    </div>
    
</div>


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="{{ asset('js/home.js') }}"  ></script>
@stop

