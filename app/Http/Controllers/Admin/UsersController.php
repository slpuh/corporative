<?php
namespace Corp\Http\Controllers\Admin;

use Corp\Repositories\RolesRepository;
use Corp\Repositories\UsersRepository;
use Corp\Role;
use Corp\User;
use Illuminate\Http\Request;
use Corp\Http\Requests\UserRequest;

use Corp\Http\Requests;
use Corp\Http\Controllers\Controller;
use Gate;

class UsersController extends AdminController
{

    protected $us_rep;
    protected $rol_rep;    

    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep)
    {
        parent::__construct();
        
        $this->us_rep = $us_rep;
        $this->rol_rep = $rol_rep;
        
        $this->template = config('settings.theme') . '.admin.users';
    }

    public function index()
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }
        
        $users = $this->us_rep->get();

        $this->content = view(config('settings.theme').'.admin.users_content')->with(['users'=>$users])->render();

       return $this->renderOutput();            
    }
    
    public function create()
    {
        $this->title = 'Новый пользователь';
        
        $roles = $this->getRoles()->reduce(function ($returnRoles, $role){
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        },[]);
        $this->content = view(config('settings.theme'). '.admin.users_create_content')->with('roles',$roles)->render();
        return $this->renderOutput();
    }
    
    public function getRoles() {
        return Role::all();
    }

    
    public function store(UserRequest $request)
    {
        $result = $this->us_rep->addUser($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }

    
    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        $this->title = 'Изменение пользователя - '. $user->name;

        $roles = $this->getRoles()->reduce(function ($returnRoles, $role){
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        },[]);
        $this->content = view(config('settings.theme'). '.admin.users_create_content')->with(['roles'=>$roles,'user'=>$user])->render();
        return $this->renderOutput();
    }
    
    public function update(Requests\UserRequest $request, User $user)
    {
        $result = $this->us_rep->updateUser($request,$user);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }
    
    public function destroy(User $user)
    {
        $result = $this->us_rep->deleteUser($user);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }
}
