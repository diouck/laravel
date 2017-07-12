<?php 

namespace Modules\Acl\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname','name','username', 'email', 'password','admin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password','remember_token','deleted_at'];

    public function authorizations()
    {
      return $this->belongsToMany('Modules\Acl\Entities\Authorization');
    }

    public function isAdmin()
    {
        return $this->admin;
    }
}
