<?php 
namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $table = 'authorizations';
    protected $fillable = ['application_id','role_id'];

    
	public function application()
	{
	  return $this->belongsTo('Modules\Acl\Entities\Application');
	}
	public function role()
	{
	  return $this->belongsTo('Modules\Acl\Entities\Role');
	}
	public function users()
	{
	  return $this->belongsToMany('Modules\Acl\Entities\User');
	}
	public function perimeters()
	{
	  return $this->belongsToMany('Modules\Acl\Entities\Perimeter');
	}
}
