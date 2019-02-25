<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Auth;
use Menu;
use DB;
use Gate;

class AdminController extends Controller
{
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content = false;
    protected $title;
    protected $vars;
    
    protected $projects;
    
    
    public function __construct() {
       
       $this->middleware(function (Request $request, $next) {
            if (!\Auth::check()) {
                abort (403);
            }
            $this->user = \Auth::user(); 
            
            return $next($request);
        }); 
       
    }
    public function renderOutput() {
        
        $this->vars = array_add($this->vars,'title',$this->title);
        
        $menu = $this->getMenu();
        
       $navigation = view(config('settings.theme').'.admin.navigation')->with('menu',$menu)->render();
       $this->vars = array_add($this->vars,'navigation',$navigation);
       
       if($this->content) {
           $this->vars = array_add($this->vars,'content',$this->content);
       }
       $footer = view(config('settings.theme').'.admin.footer')->with('menu',$menu)->render();
       $this->vars = array_add($this->vars,'footer',$footer);
       
       return view($this->template)->with($this->vars);
    }
    
    public function getMenu() {
        
        return Menu::make('adminMenu',function($menu) {
            
            if(Gate::allows('VIEW_ADMIN_ARTICLES')) {
                $menu->add('Статьи',['route'=>'articles.index']);
            }            
            
            $menu->add('Портфолио',['route'=>'articles.index']);
            $menu->add('Меню',['route'=>'menus.index']);
            $menu->add('Пользователи',['route'=>'users.index']);
            $menu->add('Привелегии',['route'=>'permissions.index']);
        });
        
    }
}
