<?php 
namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class Perimeter extends Model
{
    protected $table = 'perimeters';
    protected $fillable = ['com','nom_com','epci','nom_epci'];

    public function authorizations()
    {
      return $this->belongsToMany('Modules\Acl\Entities\Authorization');
    }

    public function avz_3_posts()
    {
      return $this->hasMany('Modules\Coproprietes\Entities\Post');
    }
}
