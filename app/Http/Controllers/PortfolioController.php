<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfoliosRepository;
use Corp\Menu;

class PortfolioController extends SiteController {

    public function __construct(PortfoliosRepository $p_rep) {

        parent::__construct(new MenusRepository(new Menu));

        $this->p_rep = $p_rep;

        $this->template = config('settings.theme') . '.portfolios';
    }

    public function index($cat_alias = false) {
        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';
        $this->title = 'Портфолио';

        $portfolios = $this->getPortfolios();

        $content = view(config('settings.theme') . '.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);


        return $this->renderOutput();
    }

    public function getPortfolios($take=false,$paginate = true) {

        $portfolios = $this->p_rep->get('*', $take, $paginate);

        if ($portfolios) {
            $portfolios->load('filter');
        }

        return $portfolios;
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        //
    }

    public function show($alias) {
        
        $portfolio = $this->p_rep->one($alias);
        
        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);
        
        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;       
        
        
        $content = view(config('settings.theme') . '.portfolio_content')->with(['portfolio'=>$portfolio,'portfolios'=>$portfolios])->render();
         $this->vars = array_add($this->vars, 'content', $content);        
        
        return $this->renderOutput();
    }

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
