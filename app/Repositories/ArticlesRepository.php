<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Corp\Repositories;
use Corp\Article;

class ArticlesRepository  extends Repository 
{
    
   public function __construct(Article $article) {
        $this->model = $article;
    }
    
    public function one($alias, $attr = []) {
        
        $article = parent::one($alias, $attr);
        
        if($article && !empty($attr)) {
            $article->load('comments');
            $article->comments->load('user');
        }
        
        return $article;
    }
}
