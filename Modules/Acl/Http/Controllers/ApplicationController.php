<?php 
namespace Modules\Acl\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Application;
use Modules\Acl\Repositories\ApplicationRepository;
use Modules\Acl\Http\Requests\ApplicationCreateRequest;
use Modules\Acl\Http\Requests\ApplicationUpdateRequest;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $applications;

    public function __construct(
        ApplicationRepository $applications)
    {
        $this->applications = $applications;
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $counts = $this->applications->count();
        $applications= $this->applications->index();
        return view('acl::admin.applications.index', compact('applications','counts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('acl::admin.applications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ApplicationCreateRequest $request)
    {
        $this->applications->store($request->all());
        return redirect('admin/application')->with('success', trans('back/applications.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $application= $this->applications->find($id);
        return view('acl::admin.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $application= $this->applications->find($id);
        return view('acl::admin.applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ApplicationUpdateRequest $request, $id)
    {
        $this->applications->update($request->all(), $id);
        return redirect('admin/application')->with('success', trans('back/applications.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->applications->destroy($id);
        return redirect('admin/application')->with('ok', trans('back/applications.destroyed'));
    }
}
