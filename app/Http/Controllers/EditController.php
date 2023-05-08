<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Storage;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function edit(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'price' => 'required|regex:/^[0-9]+$/',
                'stock' => 'required|regex:/^[0-9]+$/',
                ],
                [
                'price.required' => '値段は必須です',
                'price.regex' => '値段は半角数字で入力してください',
                'stock.required' => '在庫数は必須です',
                'stock.regex' => '在庫は半角数字で入力してください',
                ]);

            if($request->has('item_image')){
                //ローカルでの設定
                //$image_extension = $request->file('item_image')->getClientOriginalExtension();
                //$path = $request->item_name.'_'.date('YmdHis').'.'.$image_extension;
                //$request->file('item_image')->storeAS('',$path,'public');

            //AWS用の設定
            $image_name =$request->file('item_image');
            $path = Storage::disk('s3')->putFile('myprefix', $image_name, 'public');
            // アップロードした画像のフルパスを取得
            $image_path = Storage::disk('s3')->url($path);

            // 商品編集
            $items = Item::find($request->id);
            // $items->maker = $request->maker;
            // $items->item_name = $request->item_name;
            //$items->size = $request->size;
            $items->price = $request->price;
            $items->stock = $request->stock;
            $items->remarks = $request->remarks;
            $items->item_image = $image_path;
            $items->save();
            }else{
               
            // 商品編集
            $items = Item::find($request->id);
            // $items->maker = $request->maker;
            // $items->item_name = $request->item_name;
            //$items->size = $request->size;
            $items->price = $request->price;
            $items->stock = $request->stock;
            $items->remarks = $request->remarks;
            $items->save();

            }
        

            return redirect('items/detail/'.$items->item_name );
        }

        $item = Item::find($request->id);

        return view('item.edit', ['item' => $item ]);
    }

    public function delete($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect('items/detail/'.$item->item_name );
    }

}

