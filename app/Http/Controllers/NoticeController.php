<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Item;
use App\Models\Sell;
use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class NoticeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
     
        return view('notice.index');
    }

    public function add(Request $request)
    {

        // バリデーション
        $this->validate($request, 
        ['title' => 'required|max:30',
        'content' => 'required|max:250',],
        ['title.required' => 'タイトルは必須です',
        'title.max' => 'タイトルは30文字以内で入力してください',
        'content.required' => '内容は必須です',
        'content.max' => '内容は250文字以内で入力してください',]); 
     
        Notice::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect('/');
    }

    public function list(Request $request)
    {
        $notice = Notice::with('user')->find($request->id);

        return view('notice.noticelist',compact('notice'));
    }


    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, 
            ['title' => 'required|max:30',
            'content' => 'required|max:250',],
            ['title.required' => 'タイトルは必須です',
            'title.max' => 'タイトルは30文字以内で入力してください',
            'content.required' => '内容は必須です',
            'content.max' => '内容は250文字以内で入力してください',]); 
    
    
            // 商品登録
            $notice = Notice::find($request->id);
            $notice->title = $request->title;
            $notice->content = $request->content;
            $notice->save();
            return redirect('/')->with('flash_message', '登録が完了しました');
            }

        $id = $request->id;
        $notice =Notice::find($id);
    
        return view('notice.notice-edit', compact('notice'));
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $notice =Notice::find($id);
        $notice->delete();

        return redirect('/');

    }

}
