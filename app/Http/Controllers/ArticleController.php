<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Interfaces\ArticleRepositoryInterface;

class ArticleController extends Controller implements HasMiddleware
{
    private ArticleRepositoryInterface $ArticleRepository;

    public function __construct(ArticleRepositoryInterface $ArticleRepository)
    {
        $this->ArticleRepository = $ArticleRepository;
    }
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
       return $this->ArticleRepository->getAllArticles();


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return $this->ArticleRepository->createArticle();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
     return  $this->ArticleRepository->storeArticle($request);
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
    public function edit($encryptedId)
    {
        //
        return $this->ArticleRepository->editArticle($encryptedId);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        return $this->ArticleRepository->updateArticle($request);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encrypteddelete)
    {
        //
      return $this->ArticleRepository->destroyArticle($encrypteddelete);
    }
}
