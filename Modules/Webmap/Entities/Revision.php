<?php namespace Modules\Webmap\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Revision extends Model {

    protected $table = 'avz_2_revisions';

    protected $fillable = ['title', 'content','slug','status','point','polygon','linestring'];


    
    public function post()
    {
        return $this->belongsTo('Modules\Webmap\Entities\Revision');
    }

    public function perimeter()
    {
        return $this->belongsTo('Modules\Acl\Entities\Perimeter','perimeter_id','id');
    }

}