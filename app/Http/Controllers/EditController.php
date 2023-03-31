<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class EditController extends Controller
{
    public function edit(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
               
            ]);

            // 商品編集
            $items = Item::find($request->id);
            $items->maker = $request->maker;
           // $items->item_name = $request->item_name;
            //$items->size = $request->size;
            $items->price = $request->price;
            $items->stock = $request->stock;
            $items->remarks = $request->remarks;
            $items->item_image = $request->item_image;
            $items->save();
        

            return redirect('items/detail/'.$items->item_name );
        }

        $item = Item::find($request->id);

        return view('item.edit', ['item' => $item ]);
    }
}

