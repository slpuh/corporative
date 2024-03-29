<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\SlidersRepository;
use Corp\Repositories\PortfoliosRepository;
use Corp\Repositories\ArticlesRepository;
use Corp\Menu;
use Config;

class IndexController extends SiteController {

    public function __construct(SlidersRepository $s_rep, PortfoliosRepository $p_rep, ArticlesRepository $a_rep) {

        parent::__construct(new MenusRepository(new Menu));

        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;

        $this->bar = 'right';
        $this->template = config('settings.theme') . '.index';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $portfolios = $this->getPortfolio();
        
        $content = view(config('settings.theme') . '.content')->with('portfolios', $portfolios);
        $this->vars = array_add($this->vars, 'content', $content);
        
        $sliderItems = $this->getSliders();

        $sliders = view(config('settings.theme') . '.slider')->with('sliders', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'sliders', $sliders);
        
        
        $this->keywords = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->title = 'Home Page';
        
        $articles = $this->getArticles();
        $this->contentRightBar = view(config('settings.theme') . '.indexBar')->with('articles', $articles)->render();
        
        return $this->renderOutput();
    }
    
    public function getArticles() {
        
        $articles = $this->a_rep->get(['title','created_at','img','alias'], Config::get('settings.home_articles_count'));
       
        return $articles;
        
    }

    public function getSliders() {

        $sliders = $this->s_rep->get();

        if ($sliders->isEmpty()) {
            return false;
        }
        $sliders->transform(function($item, $key) {
            $item->image = Config::get('settings.slider_path') . '/' . $item->image;
            return $item;
        });

        return $sliders;
    }

    protected function getPortfolio() {

        $portfolio = $this->p_rep->get('*', Config::get('settings.home_port_count'));
       
        return $portfolio;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
