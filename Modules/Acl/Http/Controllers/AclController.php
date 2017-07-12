<?php

namespace Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Repositories\ApplicationRepository;
use Modules\Acl\Repositories\UserRepository;
use Modules\Acl\Repositories\RoleRepository;
use Modules\Acl\Repositories\PerimeterRepository;

class AclController extends Controller
{
	public function index(
        ApplicationRepository $applications, 
        RoleRepository $roles,
        PerimeterRepository $perimeters,
        UserRepository $users,Request $request)
    {
        $nb_applications = $applications->count();
        $nb_roles = $roles->count();
        $nb_perimeters = $perimeters->count();
        $nb_users = $users->count();     
        return view('acl::admin.dashboard', compact('nb_applications', 'nb_roles', 'nb_perimeters', 'nb_users'));
    }
}
