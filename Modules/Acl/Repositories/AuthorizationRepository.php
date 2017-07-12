<?php
namespace Modules\Acl\Repositories;

use Modules\Acl\Entities\Authorization, Modules\Acl\Entities\Perimeter;

class AuthorizationRepository extends BaseRepository
{
	public function __construct(Authorization $authorization)
	{
		$this->model = $authorization;
	}

	public function index()
	{

		return $this->model->all();
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
	    $authorization = new $this->model;
	    $authorization->application_id = $inputs['application'];
		$authorization->role_id = $inputs['role'];
		$authorization->save();
	    $authorization->users()->sync($inputs['user']);
		if (isset($inputs['com']))
		{
			$authorization->perimeters()->sync($inputs['com']);
		}
		if (isset($inputs['epci']) && !empty($inputs['epci']))
		{
			$perim = Perimeter::select('id')->whereIn('epci',$inputs['epci'])->get();
			$authorization->perimeters()->sync($perim);
		}
		if (isset($inputs['dep']))
		{
			$perim = Perimeter::select('id')->whereIn('dep',$inputs['dep'])->get();
			$authorization->perimeters()->sync($perim);
		}
		
	}

	public function update($inputs, $id)
	{		
		
		$authorization = $this->model->find($id);
		$authorization->users()->sync($inputs['user']);
		if (isset($inputs['com']))
		{
			$authorization->perimeters()->sync($inputs['com']);
		}
		if (isset($inputs['epci']) && !empty($inputs['epci']))
		{
			$perim = Perimeter::select('id')->whereIn('epci',$inputs['epci'])->get();
			$authorization->perimeters()->sync($perim);
		}
		if (isset($inputs['dep']))
		{
			$perim = Perimeter::select('id')->whereIn('dep',$inputs['dep'])->get();
			$authorization->perimeters()->sync($perim);
		}
		$authorization->application_id = $inputs['application'];
		$authorization->role_id = $inputs['role'];
		$authorization->save();
	}
	public function destroy($id)
	{
		$authorization = $this->model->find($id);
		$authorization->delete();
	}
}