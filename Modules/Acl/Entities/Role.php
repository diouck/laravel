<?php 
namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['slug','name'];
    
    public function authorizations()
    {
      return $this->hasMany('Modules\Acl\Entities\Authorization');
    }
}
