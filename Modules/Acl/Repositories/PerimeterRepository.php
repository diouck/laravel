<?php 
namespace Modules\Acl\Repositories;

use Modules\Acl\Entities\Authorization, Modules\Acl\Entities\Perimeter;

class PerimeterRepository extends BaseRepository
{
	public function __construct(Perimeter $perimeter)
	{
		$this->model = $perimeter;
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
	    $perimeter = new $this->model;
	    $perimeter->com = $inputs['com'];
	    $perimeter->nom_com = $inputs['nom_com'];
	    $perimeter->epci = $inputs['epci'];
	    $perimeter->nom_epci = $inputs['nom_epci'];
	    $perimeter->dep = $inputs['dep'];
	    $perimeter->nom_dep = $inputs['nom_dep'];
	    $perimeter->save();
	}

	public function update($inputs, $id)
	{		
		$perimeter = $this->model->find($id);
		$perimeter->fill($inputs);
		$perimeter->save();
	}
	public function destroy($id)
	{
		$perimeter = $this->model->find($id);
		$perimeter->delete();
	}
}