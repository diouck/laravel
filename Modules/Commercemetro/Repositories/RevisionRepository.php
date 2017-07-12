<?php namespace Modules\Commercemetro\Repositories;

use Modules\Commercemetro\Entities\Revision;
use Modules\Commercemetro\Entities\Post;
use Modules\Commercemetro\Repositories\helper;
use Modules\Acl\Entities\Perimeter;
use Illuminate\Support\Facades\DB;
use Auth;

class RevisionRepository extends BaseRepository
{
	public function __construct(Revision $revision)
	{
		$this->model = $revision;
	}


	public function index()
	{
		return $this->model->all();
	}	

    public function geom()
    {
        if (isset($_POST['shape']) && !empty($_POST['shape'])){
            $shape =json_decode($_POST['shape']);
            $geomstring=array('Point' => '','Polygon' => '','LineString' => '');
            $geoms=array();
            $typegeoms = array('Point','Polygon','LineString');
            foreach ($typegeoms as $typegeom){
                foreach ($shape->features as $id=>$object) {
                    if($object->geometry->type == $typegeom){
                        if(!empty($geomstring[$typegeom])){
                            $geomstring[$typegeom] .= ',';
                        }
                        $geomstring[$typegeom] .= "ST_SetSRID(ST_GeomFromGeoJSON('".json_encode($object->geometry)."'),4326)";
                    }
                }
                if (!empty($geomstring[$typegeom])){
                    $geoms[$typegeom] = Post::select(DB::raw('ST_collect(ARRAY['.$geomstring[$typegeom].']) as geom'))->first();  
                }
            }
        }
        return $geoms;
    }

    public function singlegeom($id)
    {
        $post = $this->model->whereIn('perimeter_id',$this->perim())->where('id',$id)->first(array('id',DB::raw('ST_AsGeoJSON(polygon,6) as polygon'),DB::raw('ST_AsGeoJSON(point,6) as point'),DB::raw('ST_AsGeoJSON(linestring,6) as linestring')));
        $geom ='{"type": "FeatureCollection", "features": [';
        $geom .= '{"type": "Feature", "geometry":'.$post->polygon.',"properties": {"fill": "#533716","fill-opacity": 0.3,"stroke":"#e79527","stroke-width": 5}}';
        if(!empty($post->point)){
            $geom .= ',{"type": "Feature", "geometry":'.$post->point.',"properties": {"marker-color": "#000","marker-size": "large","marker-symbol": "commercial"}}';
        }
        if(!empty($post->linestring)){
            $geom .= ',{"type": "Feature", "geometry":'.$post->linestring.',"properties": {"stroke": "#007798","stroke-width": 3}}';
        }  
        $geom .=']}';
        return $geom;
    }

	public function new_store($inputs)
	{
	    $revision = new $this->model;
	    $revision->user_id = Auth::user()->id;
	    $revision->perimeter_id = $inputs['com'];
        $inputs['content'] = json_encode($inputs['content']);
        $revision->fill($inputs);
        $revision->save();
	}

    public function store_revision($inputs, $id)
    {       
        $revision = new $this->model;
        $revision->post_id = $id;
        $revision->user_id = Auth::user()->id;
        $revision->perimeter_id = $inputs['com'];
        $inputs['content'] = json_encode($inputs['content']);
        $revision->fill($inputs);
        $revision->save();
    }


    public function update($id)
    {       
        $revision = $this->model->find($id);
        $post = Post::find($revision->post_id);
        if(empty($post))
        {
            $post = new Post;
        }
        
        $post->user_id = $revision->user_id;
        $post->perimeter_id = $revision->perimeter_id;
        $post->slug = $revision->slug;
        $post->title = $revision->title;
        $post->content = $revision->content;
        $post->status = $revision->status;
        $post->point = $revision->point;
        $post->polygon = $revision->polygon;
        $post->linestring = $revision->linestring;
        $post->save();
        $this->model->where('id',$id)->delete();
        
    }

	public function destroy($id)
	{
		$revision = $this->model->find($id);
		$revision->delete();
	}

    public function popup($id)
    {
        $revision = $this->model->find($id);
        $popup['post']['slug'] = $revision->slug;
        $popup['post']['content'] = json_decode($revision->content);
        $popup['post']['total'] = helper::sum_cat('#^cat_#', (array)json_decode($revision->content));
        $popup['post']['secteur'] = helper::sum_cat('#^cat_6#', (array)json_decode($revision->content))+helper::sum_cat('#^cat_7#', (array)json_decode($revision->content));
        $popup['post']['sftotal'] = helper::sum_cat('#^sf_#', (array)json_decode($revision->content));
        $popup['post']['restau'] = helper::sum_cat('#^cat_8#', (array)json_decode($revision->content));
        $popup['terms']['commune'] = $revision->perimeter->nom_com;

        return $popup;
    }
}