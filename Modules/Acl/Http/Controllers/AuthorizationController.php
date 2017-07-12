<?php 
namespace Modules\Acl\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Authorization, Modules\Acl\Entities\Application, Modules\Acl\Entities\Role, Modules\Acl\Entities\Perimeter, Modules\Acl\Entities\User;
use Modules\Acl\Repositories\AuthorizationRepository;
use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\AuthorizationCreateRequest;
use Modules\Acl\Http\Requests\AuthorizationUpdateRequest;

class AuthorizationController extends Controller
{
    protected $authorizations; 
    
    public function __construct(
        AuthorizationRepository $authorizations)
    {
        $this->authorizations = $authorizations;
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $counts = $this->authorizations->count();
        $authorizations= $this->authorizations->index();
        return view('acl::admin.authorizations.index', compact('authorizations','counts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $applications = Application::pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        $communes = Perimeter::pluck('nom_com', 'id');
        $epcis = Perimeter::whereNotNull('nom_epci')->pluck('nom_epci', 'epci');
        $deps = Perimeter::pluck('nom_dep', 'dep');
        $users = User::pluck('username', 'id');

        return view('acl::admin.authorizations.create', compact('applications','roles','communes','epcis','deps','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(AuthorizationCreateRequest $request)
    {
        $this->authorizations->store($request->all());
        return redirect('admin/authorization')->with('success', trans('back/authorizations.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $authorization= $this->authorizations->find($id);
        return view('acl::admin.authorizations.show', compact('authorization'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $authorization= $this->authorizations->find($id);
        $applications = Application::pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        $communes = Perimeter::pluck('nom_com', 'id');
        $epcis = Perimeter::whereNotNull('nom_epci')->pluck('nom_epci', 'epci');
        $deps = Perimeter::pluck('nom_dep', 'dep');
        $users = User::pluck('username', 'id');

        return view('acl::admin.authorizations.edit', compact('authorization','applications','roles','communes','epcis','deps','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AuthorizationUpdateRequest $request, $id)
    {
        $this->authorizations->update($request->all(), $id);
        return redirect('admin/authorization')->with('success', trans('back/authorizations.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorizations->destroy($id);
        return redirect('admin/authorization')->with('ok', trans('back/authorizations.destroyed'));
    }
}
