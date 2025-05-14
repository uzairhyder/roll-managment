<?php

namespace App\Interfaces;

interface ArticleRepositoryInterface
{
    public function getAllArticles();
    public function createArticle();
    public function storeArticle($request);
    public function editArticle($encryptedId);

    public function updateArticle($request);
    public function destroyArticle($encrypteddelete);
}
