<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards:
            new Middleware('permission:view article',only: ['index']),
            new Middleware('permission:edit article',only: ['edit']),
            new Middleware('permission:create article',only: ['create']),
            new Middleware('permission:delete article',only: ['delete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $articles = Article::latest()->paginate(10);
//        order by createdat latest useage
        return view('adminpanel.articles.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('adminpanel.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|max:10',
            'author' => 'required',

        ]);
        try{
            Article::create([
                'title'=>$request->title,
                'author'=>$request->author,
                'text'=>$request->text,
            ]);
            $notification = ['message' => 'Article Created', 'alert-type' => 'success'];
            return redirect()->route('articles.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('articles.create')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $encryptedId)
    {
        //

        $id = Crypt::decryptString($encryptedId);
        $articleedit = Article::find($id);

        return view('adminpanel.articles.edit',get_defined_vars());

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        try {
            $id = Crypt::decryptString($request->id);
            $request->validate([
                'title' => 'required|max:10',
                'author' => 'required',
            ]);
            $articleupdate = Article::find($id);
            $articleupdate->title = $request->title;
            $articleupdate->author = $request->author;
            $articleupdate->text = $request->text;
            $articleupdate->save();

            $notification = ['message' => 'Article Updated', 'alert-type' => 'success'];
            return redirect()->route('articles.index')->with($notification);
        } catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('articles.index')->with($notification);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encrypteddelete)
    {
        //
        try {
            $id = Crypt::decryptString($encrypteddelete);
            $articledelete = Article::find($id);
            $articledelete->delete();
            $notification = ['message' => 'Article Deleted', 'alert-type' => 'success'];
            return redirect()->route('articles.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('articles.index')->with($notification);
        }
    }
}
