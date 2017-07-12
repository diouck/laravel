<?php namespace Modules\Webmap\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model {

    protected $table = 'avz_2_postmetas';

    protected $fillable = [];

    public function posts()
    {
        return $this->belongsTo('Modules\Webmap\Entities\Post');
    }

}