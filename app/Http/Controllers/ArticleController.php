<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfoliosRepository;
use Corp\Repositories\ArticlesRepository;
use Corp\Menu;
use Config;

class ArticleController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep) {

        parent::__construct(new MenusRepository(new Menu));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
    } 
    
    public function index()
    {
        
//        
//        $this->keywords = 'Home Page';
//        $this->meta_desc = 'Home Page';
//        $this->title = 'Home Page';
//        
          $articles = $this->getArticles();
          
          $content = view(env('THEME') . '.articles_content')->with('articles', $articles);
          $this->vars = array_add($this->vars, 'content', $content);
          
//        $this->contentRightBar = view(env('THEME') . '.indexBar')->with('articles', $articles)->render();
        
        return $this->renderOutput();
    }

     public function getArticles($alias = false) {
        
        $articles = $this->a_rep->get(['id','title','created_at','img','alias','desc','user_id','category_id'], false, true);
        if($articles) {
            //$articles->load('user','category','comments');
        }
        return $articles;
        
    } 
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
