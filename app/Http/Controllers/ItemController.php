<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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
        $items = Item
        ::orderBy('maker', 'asc')
        ->get();

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
               
            ]);

            // 商品登録
            Item::create([
                'maker' => $request->maker,
                'item_name' => $request->item_name,
                'size' => $request->size,
                'price' => $request->price,
                'stock' => $request->stock,
                'remarks' => $request->remarks,
                'item_image' => $request->item_image,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }
}
