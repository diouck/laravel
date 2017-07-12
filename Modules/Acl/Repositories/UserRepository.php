<?php namespace Modules\Acl\Repositories;

use Modules\Acl\Entities\User, Modules\Acl\Entities\Authorization;

class UserRepository extends BaseRepository
{
	public function __construct(User $user)
	{
		$this->model = $user;
	}

	public function index()
	{

		return $this->model->with('authorizations')->get();
	}

	public function count()
	{
		return $this->model->count();
	}

	public function find($id)
	{
		return $this->model->with('authorizations')->findOrFail($id);
	}

	public function store($inputs)
	{
	    $user = new $this->model;
	    $user->firstname = $inputs['firstname'];
	    $user->name = $inputs['name'];
	    $user->username = $inputs['username'];
	    $user->email = $inputs['email'];
	    $user->password = bcrypt($inputs['password']);
	    if(isset($inputs['admin'])){
	    	$user->admin = true;
	    }
	    $user->save();
	}

	public function update($inputs, $id)
	{		
		$user = $this->model->find($id);
		if(isset($inputs['password'])){
	    	$inputs['password'] = bcrypt($inputs['password']);
	    }
		$user->fill($inputs);
		$user->save();
	}
	public function destroy($id)
	{
		$user = $this->model->find($id);
		$user->delete();
	}
}