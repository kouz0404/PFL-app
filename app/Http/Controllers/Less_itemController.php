<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class Less_itemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $less_items = Item::select('maker','item_name','stock','size')->orderBy('item_name', 'asc')->get();


        return view('less_items.index', compact('less_items'));
    }
}
