@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>販売管理</h1>
@stop

@section('content')
<div class="col-md-6 col-sm-6">
      <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">

            <p class="card-category">本日総売上</p>
            
            <h3 class="card-title">{{$proceeds_d}}円</h3>
            
          </div>
          <div class="card-footer">
              <div class="stats ">
              <button type="button" onclick="location.href='sell/add'" class="btn btn-outline-success w-100">販売登録</button>
              </div>
          </div>
      </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">個人売上</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <div class="input-group-append mx-1">
                        <a href="{{ url('sell/myhistory') }}" class="btn btn-default">履歴</a>
                    </div>
                    <div class="input-group-append">
                        <a href="{{ url('sell/goal') }}" class="btn btn-default">売上目標登録</a>
                    </div>
                </div>
            </div>
    </div>
    <div class="chart-container" >
        <canvas id="myChart"></canvas>
    </div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['前々月','前月', '今月', ],
            datasets: [{
                label: '個人売上（円）',
                data: [ <?php echo $proceeds_2m;?> , <?php echo $proceeds_1m;?>, <?php echo $proceeds_m;?>,],
                backgroundColor: 'rgba(0,123,255,0.5)',
                
            },{
                label: '目標売上（円）',
                data: [ <?php echo $own_goal_2m;?> , <?php echo $own_goal_1m;?>, <?php echo $own_goal_m;?>,],
                backgroundColor: 'rgba(255,0,0,0.5)',
                
            }]
        },
        options: {
  
            scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],           
             xAxes: [{
               categoryPercentage: 0.5, 
               barPercentage: 0.5,      
                   }]
        }
        }
    });

</script>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">店舗売上</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <div class="input-group-append mx-1">
                        <a href="{{ url('sell/allhistory') }}" class="btn btn-default">履歴</a>
                    </div>
                    <div class="input-group-append">
                        <a href="{{ url('sell/goal') }}" class="btn btn-default">売上目標登録</a>
                    </div>
                </div>
            </div>
    </div>
    <div class="chart-container" >
        <canvas id="allChart"></canvas>
    </div>
</div>

<script>
    var ctx = document.getElementById('allChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['前々月','前月', '今月', ],
            datasets: [{
                label: '店舗売上（円）',
                data: [ <?php echo $all_proceeds_2m;?> , <?php echo $all_proceeds_1m;?>, <?php echo $all_proceeds_m;?>,],
                backgroundColor: 'rgba(0,123,255,0.5)',
                
            },{
                label: '店舗目標売上（円）',
                data: [ <?php echo $all_goal_2m;?> , <?php echo $all_goal_1m;?>, <?php echo $all_goal_m;?>,],
                backgroundColor: 'rgba(255,0,0,0.5)',
                
            }]
        },
        options: {
  
            scales: {
            yAxes: [{
                    ticks: {
                    beginAtZero: true
                            }
                    }],
            xAxes: [{
               categoryPercentage: 0.5, 
               barPercentage: 0.5,      
                   }]
        }
        }
    });

</script>

<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">販売した商品　(最新10件)</h3>
                </div>

                <div class="tab-wrap">

                    <input id="TAB-01" type="radio" name="TAB" class="tab-switch" checked="checked" /><label class="tab-label" for="TAB-01">日</label>

                    <div class="tab-content">
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
                                        <td>{{ $sell->item->maker }}</td>
                                        <td>{{ $sell->item->item_name }}</td>
                                        <td>{{ $sell->price}}円</td>
                                        <td>{{ $sell->number}}</td>
                                        <td>{{ $sell->created_at->format('Y-m-d')}}</td>
                                        <td><a href="items/detail/{{$sell->item->item_name}}" class="btn btn-default">詳細画面</a></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6"><button type="button" onclick="location.href='sell/sell_items/1'" class="btn btn-block btn-outline-primary btn-xs w-100">more</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    
                    <input id="TAB-02" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-02">月</label>
                    <div class="tab-content">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr class="sell-log">
                                    <th>メーカー</th>
                                    <th>商品名</th>
                                    <th>単価</th>
                                    <th>足数</th>
                                    <th>追加日</th>
                                    <th class="search">
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($sells_m as $sell_m)
                                    <tr>
                                        <td>{{ $sell_m->item->maker }}</td>
                                        <td>{{ $sell_m->item->item_name }}</td>
                                        <td>{{ $sell_m->price}}円</td>
                                        <td>{{ $sell_m->number}}</td>
                                        <td>{{$sell_m->created_at->format('Y-m-d')}}</td>
                                        <td><a href="items/detail/{{$sell_m->item->item_name}}" class="btn btn-default">詳細画面</a></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6"><button type="button" onclick="location.href='sell/sell_items/2'" class="btn btn-block btn-outline-primary btn-xs w-100">more</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>

                    <input id="TAB-03" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-03"> 年 </label>
                    <div class="tab-content">
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
                                @foreach ($sells_y as $sell_y)
                                    <tr>
                                        <td>{{ $sell_y->item->maker }}</td>
                                        <td>{{ $sell_y->item->item_name }}</td>
                                        <td>{{ $sell_y->price}}円</td>
                                        <td>{{ $sell_y->number}}</td>
                                        <td>{{$sell_y->created_at->format('Y-m-d')}}</td>
                                        <td><a href="items/detail/{{$sell_y->item->item_name}}" class="btn btn-default">詳細画面</a></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6"><button type="button" onclick="location.href='sell/sell_items/3'" class="btn btn-block btn-outline-primary btn-xs w-100">more</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
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
