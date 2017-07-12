<?php 
namespace Modules\Acl\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Perimeter;
use Modules\Acl\Repositories\PerimeterRepository;
use Modules\Acl\Http\Requests\PerimeterCreateRequest;
use Modules\Acl\Http\Requests\PerimeterUpdateRequest;
use Illuminate\Http\Request;

class PerimeterController extends Controller
{
   protected $perimeters;

    public function __construct(
        PerimeterRepository $perimeters)
    {
        $this->perimeters = $perimeters;
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $counts = $this->perimeters->count();
        $perimeters= $this->perimeters->index();
        return view('acl::admin.perimeters.index', compact('perimeters','counts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('acl::admin.perimeters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(PerimeterCreateRequest $request)
    {
        $this->roles->store($request->all());
        return redirect('admin/perimeter')->with('success', trans('back/perimeters.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $perimeter= $this->perimeters->find($id);
        return view('acl::admin.perimeters.show', compact('perimeter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $perimeter= $this->perimeters->find($id);
        return view('acl::admin.perimeters.edit', compact('perimeter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(PerimeterUpdateRequest $request, $id)
    {
        $this->perimeters->update($request->all(), $id);
        return redirect('admin/perimeter')->with('success', trans('back/perimeters.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->perimeters->destroy($id);
        return redirect('admin/perimeter')->with('ok', trans('back/perimeters.destroyed'));
    }
}
