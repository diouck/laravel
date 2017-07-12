<?php namespace Modules\Commercemetro\Repositories;

use Modules\Commercemetro\Entities\Post;
use Modules\Commercemetro\Repositories\helper;
use Illuminate\Support\Facades\DB;
use Auth;

class PostRepository extends BaseRepository
{
	public function __construct(Post $post)
	{
		$this->model = $post;
	}

	public function index()
	{
		return $this->model->all();
	}
	
	public function geom()
	{
		$posts = $this->model->whereIn('perimeter_id',$this->perim())->get(array('id',DB::raw('ST_AsGeoJSON(polygon,6) as geom')));
        $geoms ='{"type": "FeatureCollection", "features": [';
        foreach($posts as $key=>$post)
        {
            if(!empty($post->geom))
            {
                if($key>0)
                {
                    $geoms .= ',';
                }
               $geoms .= '{"type": "Feature", "geometry":'.$post->geom.', "properties": {"id":"'.$post->id.'"}}'; 
            }
        }
        $geoms .=']}';
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

    public function editgeom($id)
    {
        $typegeoms = array('polygon','linestring','point');
        $post = $this->model->whereIn('perimeter_id',$this->perim())->where('id',$id)->first();
        $geoms ='';
        foreach ($typegeoms as $typegeom){
                if (!is_null($post->$typegeom)){
                    if(empty($geoms)){
                        $geoms = '{"type": "FeatureCollection", "features": [';
                    }else{
                        $geoms .=',';
                    }
                    $dump = $post->select(DB::raw('ST_AsGeoJSON((st_dump('.$typegeom.')).geom,6) as geom'))->where('id',$id)->get();
                    foreach ($dump as $key=>$geom){
                        if($key > 0){
                            $geoms .=',';
                        }
                        $geoms .= '{"type": "Feature", "geometry": '.$geom->geom;
                        if(json_decode($geom->geom)->type == 'Polygon'){
                            $geoms .=',"properties": {"fill": "#533716","fill-opacity": 0.3,"stroke":"#e79527","stroke-width": 5}}';
                        } else if(json_decode($geom->geom)->type == 'Point'){
                            $geoms .=',"properties": {"marker-color": "#000","marker-size": "large","marker-symbol": "commercial"}}';
                        } else {
                            $geoms .=',"properties": {"stroke": "#007798","stroke-width": 3}}';
                        }
                    }
                }
            }
        $geoms .=']}';
        return $geoms;
    }

	public function find($id)
	{
		return $this->model->findOrFail($id);
	}

	

	public function destroy($id)
	{
		$post = $this->model->find($id);
		$post->delete();
	}

    public function popup($id)
    {
        $post = $this->model->find($id);
        $popup['post']['slug'] = $post->slug;
        $popup['post']['title'] = $post->title;
        $popup['post']['content'] = json_decode($post->content);
        $popup['post']['total'] = helper::sum_cat('#^cat_#', (array)json_decode($post->content));
        $popup['post']['secteur'] = helper::sum_cat('#^cat_6#', (array)json_decode($post->content))+helper::sum_cat('#^cat_7#', (array)json_decode($post->content));
        $popup['post']['sftotal'] = helper::sum_cat('#^sf_#', (array)json_decode($post->content));
        $popup['post']['restau'] = helper::sum_cat('#^cat_8#', (array)json_decode($post->content));
        $popup['terms']['commune'] = $post->perimeter->nom_com;
        
        foreach ($post->postmetas as $key => $meta) {
            $popup['meta'][$meta->metakey] = json_decode($meta->metavalue);
        }
        foreach ($post->postdatas as $key => $data) {
            $popup['data'][$data->datakey] = $data->datavalue;
        }

        return $popup;
    }

	public function customsearch()
	{
		$geoms = $this->model->whereIn('perimeter_id',$this->perim()); 
        //communes
        if (isset($_GET['com'])){
            $com = $_GET['com'];
            $geoms = $geoms->whereIn('perimeter_id',$com);
        }

        $geoms = $geoms->get(array('id',DB::raw('ST_AsGeoJSON(point,6) as geom')));

        $search ='{"type": "FeatureCollection", "features": [';
        foreach($geoms as $key=>$geom)
        {
            if(!empty($geom->geom))
            {
                if($key>0)
                {
                    $search .= ',';
                }
               $search .= '{"type": "Feature", "geometry":'.$geom->geom.', "properties": {"id":"'.$geom->id.'"}}'; 
            }
        }
        $search .=']}';
        return $search;
        
        
	}
}