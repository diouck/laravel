<?php 
namespace Modules\Acl\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Acl\Entities\User;
use Modules\Acl\Repositories\UserRepository;
use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\UserCreateRequest;
use Modules\Acl\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    protected $users;

    public function __construct(
        UserRepository $users)
    {
        $this->users = $users;
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $counts = $this->users->count();
        $users= $this->users->index();
        return view('acl::admin.users.index', compact('users','counts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('acl::admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UserCreateRequest $request)
    {
        $this->users->store($request->all());
        return redirect('admin/user')->with('success', trans('back/users.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user= $this->users->find($id);
        return view('acl::admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user= $this->users->find($id);
        return view('acl::admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $this->users->update($request->all(), $id);
        return redirect('admin/user')->with('success', trans('back/users.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->users->destroy($id);
        return redirect('admin/user')->with('ok', trans('back/users.destroyed'));
    }
}
