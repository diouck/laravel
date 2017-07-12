<?php 
namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = ['slug','name'];
    
    public function authorizations()
    {
      return $this->hasMany('Modules\Acl\Entities\Authorization');
    }
}
