<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Storage;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        //$items = Item::orderBy('maker', 'asc')->paginate(10);
        $items = Item::select('maker','item_name')->orderBy('maker', 'asc')->distinct('item_name')->paginate(10);

        //別ページに移植
        //$less_items = Item::select('maker','item_name','stock','size')->paginate(5);


        return view('item.index', compact('items'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
            'maker' => 'required',
            'item_name' => 'required',
            'size' => 'required',
            'price' => 'required|regex:/^[0-9]+$/',
            'stock' => 'required|regex:/^[0-9]+$/',
            ],
            [
            'maker.required' => 'メーカーは必須です',
            'item_name.required' => '商品名は必須です',
            'size.required' => 'サイズは必須です',
            'price.required' => '値段は必須です',
            'price.regex' => '値段は半角数字で入力してください',
            'stock.required' => '在庫数は必須です',
            'stock.regex' => '在庫は半角数字で入力してください',
            ]); 

            if($request->has('item_image')){
                //ローカル用の設定
           // $image_extension = $request->file('item_image')->getClientOriginalExtension();
            //$path = $request->item_name.'_'.date('YmdHis').'.'.$image_extension;
            //$request->file('item_image')->storeAS('',$path,'public');

            //AWSの設定
            $image_name =$request->file('item_image');
            $path = Storage::disk('s3')->putFile('myprefix', $image_name, 'public');
            // アップロードした画像のフルパスを取得
            $image_path = Storage::disk('s3')->url($path);
            }else{
            $image_path = null;
            }
            // 商品登録
            Item::create([
                'maker' => $request->maker,
                'item_name' => $request->item_name,
                'size' => $request->size,
                'price' => $request->price,
                'stock' => $request->stock,
                'remarks' => $request->remarks,
                'item_image' => $image_path,
            ]);

            return redirect('/items');
        }

        return view('item.add');
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


            $items = $query->select('maker','item_name')->distinct('item_name')->paginate(10); //検索結果のユーザーを50件/ページで表示

        }

        return view('item.index', compact('items','search'));
    }

 
}
