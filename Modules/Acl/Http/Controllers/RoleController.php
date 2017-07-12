<?php 
namespace Modules\Acl\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Role;
use Modules\Acl\Repositories\RoleRepository;
use Modules\Acl\Http\Requests\RoleCreateRequest;
use Modules\Acl\Http\Requests\RoleUpdateRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roles;

    public function __construct(
        RoleRepository $roles)
    {
        $this->roles = $roles;
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $counts = $this->roles->count();
        $roles= $this->roles->index();
        return view('acl::admin.roles.index', compact('roles','counts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('acl::admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(RoleCreateRequest $request)
    {
        $this->roles->store($request->all());
        return redirect('admin/role')->with('success', trans('back/roles.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $role= $this->roles->find($id);
        return view('acl::admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $role= $this->roles->find($id);
        return view('acl::admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $this->roles->update($request->all(), $id);
        return redirect('admin/role')->with('success', trans('back/roles.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->roles->destroy($id);
        return redirect('admin/role')->with('ok', trans('back/roles.destroyed'));
    }
}
