<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Corp\Repositories\PermissionsRepository;
use Corp\Repositories\RolesRepository;
use Gate;


class PermissionsController extends AdminController
{
   protected $per_rep; 
   protected $rol_rep; 
    
    public function __construct(PermissionsRepository $per_rep, RolesRepository $rol_rep) {
        
        parent::__construct(); 
        
        $this->per_rep = $per_rep;
        $this->rol_rep = $rol_rep;
        
        $this->template = env('THEME').'.admin.permissions';
 
        
    }
    
    public function index()
    {
        if(Gate::denies('EDIT_USERS')) {
            abort(403);
        }
        
        $this->title = 'Менеджер привелегий';
        $roles = $this->getRoles();
        $permissions = $this->getPermissions();
        
        $this->content = view(env('THEME').'.admin.permissions_content')->with(['roles'=>$roles,'permissions'=>$permissions])->render();
    
        return $this->renderOutput();
        }
    
    public function getRoles()
    {
        $roles = $this->rol_rep->get();
        
        return $roles;
    }
    
    public function getPermissions()
    {
        $permissions = $this->per_rep->get();
        
        return $permissions;
    }
    
    public function store(Request $request) {
        
        $result = $this->per_rep->changePermissions($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return back()->with($result);
        
    }
}
