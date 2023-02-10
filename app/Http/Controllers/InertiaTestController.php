<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\InertiaTest;  //ﾃｰﾌﾞﾙ操作時はつける

class InertiaTestController extends Controller
{
     public function index()
     {
        return Inertia::render('Inertia/index',[
          'blogs' => InertiaTest::all()
        ]);
     }

     public function create()
     {
        return Inertia::render('Inertia/create');
     }



     public function show($id)
     {
      //  dd($id);
      return Inertia::render('Inertia/show',
      [
         'id' => $id

      ]
   );
   }

   public function store(Request $request)
   {
// ﾊﾞﾘﾃﾞｰｼｮﾝ処理
      $request->validate([
         'title' => ['required','max:20'],
         'content' => ['required'],
      ]);

      $InertiaTest = new InertiaTest;
      $InertiaTest->title   = $request->title;
      $InertiaTest->Content = $request->content;
      $InertiaTest->save();
      
      return to_route('inertia.index')
      ->with([
         'message' => '登録しました。'
      ]);

   }

}
