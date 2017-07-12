<?php namespace Modules\Webmap\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Postdata extends Model {

    protected $table = 'avz_2_postdatas';

    protected $fillable = [];

    public function posts()
    {
        return $this->belongsTo('Modules\Webmap\Entities\Post');
    }

}