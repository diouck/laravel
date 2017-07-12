<?php namespace Modules\Acl\Repositories;

use Modules\Acl\Entities\Authorization, Modules\Acl\Entities\Role;

class RoleRepository extends BaseRepository
{
	public function __construct(Role $role)
	{
		$this->model = $role;
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
		return $this->model->findOrFail($id);
	}

	public function store($inputs)
	{
	    $role = new $this->model;
	    $role->slug = $inputs['slug'];
	    $role->name = $inputs['name'];
	    $role->save();
	}

	public function update($inputs, $id)
	{		
		$role = $this->model->find($id);
		$role->fill($inputs);
		$role->save();
	}
	public function destroy($id)
	{
		$role = $this->model->find($id);
		$role->delete();
	}
}