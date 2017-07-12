<?php 
namespace Modules\Commercemetro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Commercemetro\Repositories\PostRepository;
use Modules\Commercemetro\Http\Requests\PostCreateRequest;
use Modules\Commercemetro\Http\Requests\PostUpdateRequest;
use Modules\Acl\Entities\Perimeter;

class PostController extends Controller {
	
	protected $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    public function admin()
    {     
        $posts = $this->posts->index();
        return view($this->posts->modulename().'::admin.indexposts', compact('posts'));
    }
    
    public function index()
    {       
        $perimeters = $this->posts->userperim();
        return view($this->posts->modulename().'::map', compact('perimeters'));
    }

    public function indexAjax()
    {
        $geoms= $this->posts->geom();

        return response($geoms);
    }

    public function singleAjax(Request $request)
    {
        $geom = $this->posts->singlegeom($request->id);

        return response($geom);
    }

    public function popupAjax(Request $request)
    {
        $popup= $this->posts->popup($request->id);

        return response()->json($popup);
    }

    public function show($id)
    {
        $post = $this->posts->find($id);
        $other= $this->posts->popup($id);
        $perimeters = $this->posts->userperim();
        return view($this->posts->modulename().'::show', compact('post','other','perimeters'));
    }
    
    public function search()
    {     
        $perimeters = $this->posts->userperim();
        return view($this->posts->modulename().'::map', compact('perimeters'));
    }

    public function searchAjax()
    {
        $geoms = $this->posts->customsearch();

        return response($geoms);
    }

    public function edit($id)
    {
        $post = $this->posts->find($id);
        $other= $this->posts->popup($id);
        $communes = $this->posts->userperim()->pluck('nom_com', 'id');
        return view($this->posts->modulename().'::edit', compact('post','other','communes'));
    }

    public function editgeomAjax($id)
    {
        $geoms = $this->posts->editgeom($id);
        return response($geoms);
    }

    public function destroy($id)
    {
        $this->posts->destroy($id);
        return redirect('commerce')->with('ok', 'Pôle commercial supprimé');
    }
}