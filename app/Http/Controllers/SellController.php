<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Item;
use App\Models\Sell;
use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class SellController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = Carbon::today();
        $month = date('m');
        $lastmonth = date('m', strtotime('-1 month'));
        $lasttwomonths = date('m', strtotime('-2 months'));
        $year = date('Y');


        // そのユーザーが売った商品一覧取得
        $sells = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $month)->whereDate('created_at', $today)->orderByDesc('created_at')
        ->paginate(10);

        $sells_m = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderByDesc('created_at')
        ->paginate(10);

        $sells_y = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->orderByDesc('created_at')
        ->paginate(10);

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
            ['number' => 'required|regex:/^[0-9]+$/',],
            ['number.required' => '数量は必須です',
             'number.regex' => '数量は半角数字で入力してください',]); 

            // 商品登録
            Sell::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'number' => $request->number,
                'maker' => $request->maker,
                'item_name' => $request->item_name,
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
        $details = Item
        ::orderBy('maker', 'asc')
        ->get();

        $items = Item::select('maker','item_name')->orderBy('maker', 'asc')->distinct('item_name')->paginate(10);

        return view('sell.add', compact('items','details'));
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

            $items = $query->select('maker','item_name')->distinct('item_name')->paginate(10); 

        }

        $details = Item
        ::orderBy('maker', 'asc')
        ->get();

        return view('sell.add', compact('items','details','search'));
    }


    //目標金額について

    public function goal(Request $request)
    {
        if ($request->isMethod('post')) {
            //input type monthはdate型に直接入らないため、日を手動で追加

   
            // バリデーション
            $this->validate($request, 
            ['goal' => 'required|regex:/^[0-9]+$/',
             'date' => 'required',
             'class' => 'required',],
            ['goal.required' => '金額は必須です',
            'goal.regex' => '金額は半角数字で入力してください',
            'date.required' => '年月は必須です',
            'class.required' => '区分は必須です',]); 

            $request->merge([
                'date' => $request->date.'-01',
            ]);   

            if($request->class == 0){
            $this->validate($request, 
            ['date' => Rule::unique('goals')->where(function ($query) {
                return $query->where('class', 0);
            })],
            ['date.unique' => 'その月の目標は既に入力済みです',]); }

            if($request->class == 1){
            $this->validate($request, 
            ['date' => Rule::unique('goals')->where(function ($query) {
                return $query->where('class', 1);
            })],
            ['date.unique' => 'その月の目標は既に入力済みです',]); }

            $id=Auth::id();

            // 商品登録
            Goal::create([
                'user_id' => $id,
                'goal' => $request->goal,
                'date' => $request->date,
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

    //個人売上目標の一覧表示
    public function history(Request $request)
    {
        $historys =Goal::where('class',1)->where('user_id',Auth::id())->orderByDesc('date')->paginate(3);
        return view('sell.history', compact('historys'));
    }

    //個人売上目標の一覧表示
    public function allhistory(Request $request)
    {
        $historys =Goal::where('class',0)->orderByDesc('date')->paginate(3);
        return view('sell.history', compact('historys'));
    }

        //売上目標の編集削除
    public function history_edit(Request $request)
    {
        if ($request->isMethod('post')) {
        //input type monthはdate型に直接入らないため、日を手動で追加
            $request->merge([
            'date' => $request->date.'-01',
            ]);
            // バリデーション
            $this->validate($request, 
                ['goal' => 'required|regex:/^[0-9]+$/',],
                ['goal.required' => '金額は必須です',
                'goal.regex' => '金額は半角数字で入力してください',]); 
    
    
            // 商品登録
            $goal = Goal::find($request->id);
            $goal->goal = $request->goal;
            $goal->date = $request->date;
            $goal->save();
    
            if($goal->class == 1){
            return redirect('sell/myhistory')->with('flash_message', '登録が完了しました');
            }
            return redirect('sell/allhistory')->with('flash_message', '登録が完了しました');
            }

        $id = $request->id;
        $history_detail =Goal::find($id);
    
        return view('sell.history-edit', compact('history_detail'));
    }
    
    public function delete(Request $request)
        {
            $id = $request->id;
            $history_detail =Goal::find($id);
            $history_detail->delete();

            if($history_detail->class == 1){
            return redirect('sell/myhistory');}

            return redirect('sell/allhistory');

        }


    public function sell_items($id)
    {
        $today = Carbon::today();
        $month = date('m');
        $lastmonth = date('m', strtotime('-1 month'));
        $lasttwomonths = date('m', strtotime('-2 months'));
        $year = date('Y');


        if($id == 1){

            // そのユーザーが売った商品一覧取得
            $sells = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $month)->whereDate('created_at', $today)->orderByDesc('created_at')
            ->with('item')->paginate(10);

            $d='本日';


            return view('sell.sell-items', compact('sells','d'));

        }elseif($id == 2){

            // そのユーザーが売った月の商品一覧取得
            $sells = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderByDesc('created_at')
            ->paginate(10);
    
            $d='月';
    
            return view('sell.sell-items', compact('sells','d'));

        }elseif($id == 3){

            // そのユーザーが売った年間の商品一覧取得
            $sells = Sell::where('user_id', Auth::id())->whereYear('created_at', $year)->orderByDesc('created_at')
            ->with('item')->paginate(10);

            $d='年間';

            return view('sell.sell-items', compact('sells','d'));
        }

    }

    public function delete_sell_items(Request $request)
    {
        $id = $request->id;
        $history_detail =Sell::find($id);
        $history_detail->delete();

        return redirect('sell');

    }



    



 
}



