<?php namespace Modules\Commercemetro\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Postdata extends Model {

    protected $table = 'avz_1_postdatas';

    protected $fillable = [];

    public function posts()
    {
        return $this->belongsTo('Modules\Commercemetro\Entities\Post');
    }

}