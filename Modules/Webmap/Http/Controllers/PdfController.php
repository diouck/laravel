<?php 
namespace Modules\Webmap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Webmap\Repositories\PostRepository;


class PdfController extends Controller {
	
	protected $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

	public function pdf($id)
	{
		$post = $this->posts->find($id);
        $other= $this->posts->popup($id);
        $perimeters = $this->posts->userperim();
        $geojson = $this->posts->singlegeom($id);

		return \PDF::loadView($this->posts->modulename().'::pdf', compact('post','other','perimeters','geojson'))->stream('webmap-'.$id.'.pdf');
	}
	
}