<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Sell;

class SellController extends Controller
{
    public function index()
    {
        // 商品一覧取得
        $items = Item
        ::orderBy('maker', 'asc')
        ->get();

        $proceeds =Sell::where('user_id',Auth::id())
        ->selectRaw('sum(number * price) as total')
                    ->value('total');

        return view('sell.index', compact('items','proceeds'));
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

 
}



