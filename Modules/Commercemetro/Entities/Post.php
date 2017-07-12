<?php namespace Modules\Commercemetro\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

    protected $table = 'avz_1_posts';

    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'content','slug','status','point','polygon','linestring'];

    public function perimeter()
    {
        return $this->belongsTo('Modules\Acl\Entities\Perimeter','perimeter_id','id');
    }

    public function postmetas()
    {
        return $this->hasMany('Modules\Commercemetro\Entities\Postmeta');
    }

    public function postdatas()
    {
        return $this->hasMany('Modules\Commercemetro\Entities\Postdata');
    }
    public function revision()
    {
        return $this->hasMany('Modules\Commercemetro\Entities\Revision');
    }

}