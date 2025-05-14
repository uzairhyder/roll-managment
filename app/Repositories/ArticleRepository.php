<?php
namespace App\Repositories;

use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use Illuminate\Support\Facades\Crypt;

class ArticleRepository implements ArticleRepositoryInterface
{

        public function getAllArticles()
        {
            $articles = Article::latest()->paginate(10);
            //order by createdat latest useage
            return view('adminpanel.articles.index',get_defined_vars());
        }

        public function createArticle()
        {
            return view('adminpanel.articles.create');
        }
        public function storeArticle($request){
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

        public function editArticle($encryptedId)
        {
            $id = Crypt::decryptString($encryptedId);
            $articleedit = Article::find($id);
            return view('adminpanel.articles.edit',get_defined_vars());
        }

        public function updateArticle($request){
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

        public function destroyArticle($encrypteddelete)
        {
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
