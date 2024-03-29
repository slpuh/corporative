<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Requests\MenusRequest;
use Corp\Http\Controllers\Controller;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\PortfoliosRepository;
use Gate;
use Menu;
use Corp\Category;

class MenusController extends AdminController {

    protected $m_rep;

    public function __construct(MenusRepository $m_rep, ArticlesRepository $a_rep, PortfoliosRepository $p_rep) {

        parent::__construct();

        $this->m_rep = $m_rep;
        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;


        $this->template = config('settings.theme') . '.admin.menus';
    }

    public function index() {
        if (Gate::denies('VIEW_ADMIN_MENU')) {
            abort(403);
        }

        $menu = $this->getMenus();

        $this->content = view(config('settings.theme') . '.admin.menus_content')->with('menus', $menu)->render();

        return $this->renderOutput();
    }

    public function getMenus() {
        $menu = $this->m_rep->get();

        if ($menu->isEmpty()) {
            return false;
        }
        return Menu::make('forMenuPart', function($m) use($menu) {

                    foreach ($menu as $item) {
                        if ($item->parent == 0) {
                            $m->add($item->title, $item->path)->id($item->id);
                        } else {
                            if ($m->find($item->parent)) {
                                $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                            }
                        }
                    }
                });
    }

    public function create() {

        $this->title = 'Новый пункт меню';

        $tmp = $this->getMenus()->roots();
        $menus = $tmp->reduce(function($returnMenus, $menu) {
            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;
        }, ['0' => 'Родительский пункт меню']);

        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();
        $list = [];
        $list = array_add($list, '0', 'Не используется');
        $list = array_add($list, 'parent', 'Раздел блог');
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $list[$category->title] = array();
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->a_rep->get(['id', 'title', 'alias']);
        $articles = $articles->reduce(function($returnArticles, $article) {
            $returnArticles[$article->alias] = $article->title;
            return $returnArticles;
        }, []);

        $filters = \Corp\Filter::select('id', 'title', 'alias')->get()->reduce(function ($returnFilters, $filter) {
            $returnFilters[$filter->alias] = $filter->title;
            return $returnFilters;
        }, ['parent' => 'Раздел портфолио']);

        $portfolios = $this->p_rep->get(['id', 'alias', 'title'])->reduce(function ($returnPortfolios, $portfolio) {
            $returnPortfolios[$portfolio->alias] = $portfolio->title;
            return $returnPortfolios;
        }, []);

        $this->content = view(config('settings.theme') . '.admin.menus_create_content')->with(['menus' => $menus, 'categories' => $list, 'articles' => $articles, 'filters' => $filters, 'portfolios' => $portfolios])->render();

        return $this->renderOutput();
    }

    public function store(MenusRequest $request) {
        $result = $this->m_rep->addMenu($request);
        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }

    public function edit(\Corp\Menu $menu) {

        $this->title = 'Редактирование пункта - ' . $menu->title;

        $type = false;
        $option = false;

        $route = app('router')->getRoutes()->match(app('request')->create($menu->path));

        $aliasRoute = $route->getName();
        $parameters = $route->parameters();

        if ($aliasRoute == 'articles.index' || $aliasRoute == 'articlesCat') {
            $type = 'blogLink';
            $option = isset($parameters['cat_alias']) ? $parameters['cat_alias'] : 'parent';
        } else if ($aliasRoute == 'articles.show') {
            $type = 'blogLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';
        } else if ($aliasRoute == 'portfolios.index') {
            $type = 'portfolioLink';
            $option = 'parent';
        } else if ($aliasRoute == 'portfolios.show') {
            $type = 'portfolioLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';
        } else {
            $type = 'customLink';
        }

        $tmp = $this->getMenus()->roots();
        $menus = $tmp->reduce(function($returnMenus, $menu) {
            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;
        }, ['0' => 'Родительский пункт меню']);

        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();
        $list = [];
        $list = array_add($list, '0', 'Не используется');
        $list = array_add($list, 'parent', 'Раздел блог');
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $list[$category->title] = array();
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->a_rep->get(['id', 'title', 'alias']);
        $articles = $articles->reduce(function($returnArticles, $article) {
            $returnArticles[$article->alias] = $article->title;
            return $returnArticles;
        }, []);

        $filters = \Corp\Filter::select('id', 'title', 'alias')->get()->reduce(function ($returnFilters, $filter) {
            $returnFilters[$filter->alias] = $filter->title;
            return $returnFilters;
        }, ['parent' => 'Раздел портфолио']);

        $portfolios = $this->p_rep->get(['id', 'alias', 'title'])->reduce(function ($returnPortfolios, $portfolio) {
            $returnPortfolios[$portfolio->alias] = $portfolio->title;
            return $returnPortfolios;
        }, []);

        $this->content = view(config('settings.theme') . '.admin.menus_create_content')->with(['menu' => $menu, 'type' => $type, 'option' => $option, 'menus' => $menus, 'categories' => $list, 'articles' => $articles, 'filters' => $filters, 'portfolios' => $portfolios])->render();

        return $this->renderOutput();
    }

    public function update(Request $request, \Corp\Menu $menu) {
        
        $result = $this->m_rep->updateMenu($request,$menu);
        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }
    
    public function destroy(\Corp\Menu $menu) {
        
        $result = $this->m_rep->deleteMenu($menu);
        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }
}
