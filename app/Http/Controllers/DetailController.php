<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class DetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function detail(Request $request)
    {
        $items = Item::where('item_name',$request->item_name)->orderBy('size', 'asc')->get();

        return view('item.detail',[
            'items' => $items, 
        ]);
    }
}
