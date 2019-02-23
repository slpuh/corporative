<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Requests\ArticleRequest;
use Corp\Http\Controllers\Controller;
use Corp\Repositories\ArticlesRepository;
use Gate;
use Corp\Category;
use Corp\Article;

class ArticlesController extends AdminController
{
    public function __construct(ArticlesRepository $a_rep) {
        
        parent::__construct();  
        
       $this->a_rep = $a_rep;
        
        $this->template = env('THEME').'.admin.articles';
 
        
    }
    
    public function index()
    {
        if (Gate::denies('VIEW_ADMIN_ARTICLES')) {
            abort(403);
        }
        
        $this->title = 'Управление статьями';
        
        $articles = $this->getArticles();        
        $this->content = view(env('THEME') . '.admin.articles_content')->with('articles', $articles)->render();
        
       return $this->renderOutput();
    }

    public function getArticles()
    {
       return $this->a_rep->get();
    }
    
    public function create()
    {
        if (Gate::denies('save', new \Corp\Article)) {
            abort(403);
        }
        $this->title = 'Добавление материала';
        
        $categories = Category::select(['title','alias','parent_id','id'])->get();
        
        $lists = [];
        foreach($categories as $category) {
            if($category->parent_id == 0) {
                $lists[$category->title] = [];
            }
            else {
                $lists[$categories->where('id',$category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }
        $this->content = view(env('THEME').'.admin.articles_create_content')->with('categories',$lists)->render();
        return $this->renderOutput();
    }

    public function store(ArticleRequest $request)
    {
        $result = $this->a_rep->addArticle($request);
        
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }

    public function show($id)
    {
        //
    }

    public function edit(Article $article)
    {
        if(Gate::denies('edit',new Article)){
            abort(403);
        }
        
        $article->img = json_decode($article->img);
      
        $categories = Category::select(['title','alias','parent_id','id'])->get();
        $list = array();
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $list[$category->title] = array();
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }

        }
        $this->title = 'Редактирование материала - '. $article->title;
        $this->content = view(env('THEME').'.admin.articles_create_content')->with('categories',$lists)->render();
        return $this->renderOutput();
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