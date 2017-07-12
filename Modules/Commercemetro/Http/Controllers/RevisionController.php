<?php 
namespace Modules\Commercemetro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Commercemetro\Repositories\RevisionRepository;
use Modules\Commercemetro\Http\Requests\RevisionCreateRequest;
use Modules\Commercemetro\Http\Requests\RevisionUpdateRequest;
use Modules\Commercemetro\Entities\Post;
use Modules\Acl\Entities\Perimeter;

class RevisionController extends Controller {
	
	protected $revisions;

    public function __construct(RevisionRepository $revisions)
    {
        $this->revisions = $revisions;
    }
    
    public function dashboard()
    {     
        $nb_revisions = $this->revisions->count();
        $nb_posts = Post::count();
        return view($this->revisions->modulename().'::admin.dashboard', compact('nb_revisions','nb_posts'));
    }

     public function index()
    {
        $counts = $this->revisions->count();
        $revisions= $this->revisions->index();
        return view($this->revisions->modulename().'::admin.index', compact('revisions','counts'));
    }

    public function show($id)
    {
        $post = $this->revisions->find($id);
        $other= $this->revisions->popup($id);
        $perimeters = $this->revisions->userperim();
        return view($this->revisions->modulename().'::admin.show', compact('post','other','perimeters'));
    }

    public function create()
    {
        $communes = $this->revisions->userperim()->pluck('nom_com', 'id');
        return view($this->revisions->modulename().'::create', compact('communes'));
    }

    public function geomAjax()
    {
        $geoms = $this->revisions->geom();
        return response($geoms);
    }

    public function singleAjax(Request $request)
    {
        $geom = $this->revisions->singlegeom($request->id);

        return response($geom);
    }

    public function newStore(RevisionCreateRequest $request)
    {
        $this->revisions->new_store($request->all());
        return redirect('commercemetro')->with('success', 'Pôle commercial créé et en attente de modération');
    }

    public function storeRevision(RevisionUpdateRequest $request, $id)
    {
        $this->revisions->store_revision($request->all(), $id);
        return back()->with('success', 'Pôle commercial modifié et en attente de modération');
    }

    public function update($id)
    {
        $this->revisions->update($id);
        return back()->with('success', 'Pôle commercial modifié');
    }

    public function destroy($id)
    {
        $this->revisions->destroy($id);
        return redirect('commercemetro/admin/revisions')->with('ok', 'Pôle commercial en attente supprimé');
    }
}