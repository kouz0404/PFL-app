<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Sell;
use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class SellController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $month = date('m');
        $lastmonth = date('m', strtotime('-1 month'));
        $lasttwomonths = date('m', strtotime('-2 months'));
        $year = date('Y');


        // そのユーザーが売った商品一覧取得
        $sells = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $month)->whereDate('created_at', $today)->orderByDesc('created_at')
        ->with('item')->get();

        $sells_m = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderByDesc('created_at')
        ->with('item')->get();

        $sells_y = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->orderByDesc('created_at')
        ->with('item')->get();

        //個人の売上について
        //日の売上を取得
        $proceeds_d =Sell::where('user_id',Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $month)->whereDate('created_at', $today)
        ->selectRaw('sum(number * price) as total')
                    ->value('total');
        
        //月の売上を取得
        $proceeds_m =Sell::where('user_id',Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $month)
        ->selectRaw('sum(number * price) as total')
                    ->value('total');

        //月の目標を取得
        $own_goal_m =Goal::where('class',1)->where('user_id',Auth::id())->whereYear('date', $year)->whereMonth('date', $month)
        ->value('goal');

        //前月の売上を取得
        $proceeds_1m =Sell::where('user_id',Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $lastmonth)
        ->selectRaw('sum(number * price) as total')
                    ->value('total');

        //前月の目標を取得
        $own_goal_1m =Goal::where('class',1)->where('user_id',Auth::id())->whereYear('date', $year)->whereMonth('date', $lastmonth)
        ->value('goal');

        //前々月の売上を取得
        $proceeds_2m =Sell::where('user_id',Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $lasttwomonths)
        ->selectRaw('sum(number * price) as total')
                    ->value('total');

        //前々月の目標を取得
        $own_goal_2m =Goal::where('class',1)->where('user_id',Auth::id())->whereYear('date', $year)->whereMonth('date', $lasttwomonths)
        ->value('goal');

        //年の売上を取得(今回は使っていないが準備だけ)
        //$proceeds_y =Sell::where('user_id',Auth::id())->whereYear('created_at', $year)
        //->selectRaw('sum(number * price) as total')
                    //->value('total');

        
        //店舗の売上について
        //月の売上を取得
        $all_proceeds_m =Sell::whereYear('created_at', $year)->whereMonth('created_at', $month)
        ->selectRaw('sum(number * price) as total')
                    ->value('total');
        //月の目標を取得
         $all_goal_m =Goal::where('class',0)->whereYear('date', $year)->whereMonth('date', $month)
        ->value('goal');

        //前月の売上を取得
        $all_proceeds_1m =Sell::whereYear('created_at', $year)->whereMonth('created_at', $lastmonth)
        ->selectRaw('sum(number * price) as total')
                    ->value('total');
        
        //前月の目標を取得
         $all_goal_1m =Goal::where('class',0)->whereYear('date', $year)->whereMonth('date', $lastmonth)
        ->value('goal');

        //前々月の売上を取得
        $all_proceeds_2m =Sell::whereYear('created_at', $year)->whereMonth('created_at', $lasttwomonths)
        ->selectRaw('sum(number * price) as total')
                    ->value('total');

        //前々月の目標を取得
         $all_goal_2m =Goal::where('class',0)->whereYear('date', $year)->whereMonth('date', $lasttwomonths)
        ->value('goal');

        return view('sell.index', 
        compact('sells','sells_m','sells_y',
        'proceeds_d','proceeds_m','proceeds_1m','proceeds_2m',
        'all_proceeds_m','all_proceeds_1m','all_proceeds_2m',
        'all_goal_m','all_goal_1m','all_goal_2m','own_goal_m','own_goal_1m','own_goal_2m'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, 
            ['number' => 'required',],
            ['number.required' => '数量は必須です',]); 

            // 商品登録
            Sell::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'number' => $request->number,
                'price' => $request->price,
            ]);
            //商品登録と同時に売った分を在庫から引く
            $number = $request->input('number');
            $item = Item::find($request->item_id);
            $currentstock = $item->stock;
            $newstock = $currentstock - $number ;
            $item->stock = $newstock;
            $item->save();

            return redirect('sell/add')->with('flash_message', '登録が完了しました');
        }


        // 商品一覧取得
        $items = Item
        ::orderBy('maker', 'asc')
        ->get();

        return view('sell.add', compact('items'));
    }

    public function search(Request $request){

        
        $items = Item::orderByDesc('created_at')->get();

        $search = $request->input('search'); //フォームの入力値を取得

        //検索キーワードが空の場合
        if (empty($search)) {
            $items = Item::paginate(50);

        //検索キーワードが入っている場合
        } else {
            $_q = str_replace('　', ' ', $search);  //全角スペースを半角に変換
            $_q = preg_replace('/\s(?=\s)/', '', $_q); //連続する半角スペースは削除
            $_q = trim($_q); //文字列の先頭と末尾にあるホワイトスペースを削除
            $_q = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $_q); //円マーク、パーセント、アンダーバーはエスケープ処理
            $keywords = array_unique(explode(' ', $_q)); //キーワードを半角スペースで配列に変換し、重複する値を削除

            $query = Item::query();
            foreach($keywords as $keyword) {
            $query->where(function($_query) use($keyword){
            $_query->where('maker', 'LIKE', '%'.$keyword.'%')
            ->orwhere('item_name', 'LIKE', '%'.$keyword.'%');
            });

            }


            $items = $query->paginate(10); //検索結果のユーザーを50件/ページで表示

        }

        return view('sell.add', compact('items','search'));
    }


    //目標金額について

    public function goal(Request $request)
    {
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, 
            ['goal' => 'required|regex:/^[0-9]+$/',
             'date' => 'required',
             'class' => 'required',],
            ['goal.required' => '金額は必須です',
            'goal.regex' => '金額は半角数字で入力してください',
            'date.required' => '年月は必須です',
            'class.required' => '区分は必須です',]); 

            $id=Auth::id();

            // 商品登録
            Goal::create([
                'user_id' => $id,
                'goal' => $request->goal,
                'date' => $request->date.'-01',
                'class' => $request->class,
            ]);


            return redirect('sell')->with('flash_message', '登録が完了しました');
        }


        // 商品一覧取得
        $items = Item
        ::orderBy('maker', 'asc')
        ->get();

        return view('sell.goal', compact('items'));
    }


    



 
}



