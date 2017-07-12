<?php 
namespace Modules\Acl\Repositories;

use Modules\Acl\Entities\Authorization, Modules\Acl\Entities\Application;

class ApplicationRepository extends BaseRepository
{
	public function __construct(Application $application)
	{
		$this->model = $application;
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
	    $application = new $this->model;
	    $application->slug = $inputs['slug'];
	    $application->name = $inputs['name'];
	    $application->save();
	}

	public function update($inputs, $id)
	{		
		$application = $this->model->find($id);
		$application->fill($inputs);
		$application->save();
	}
	public function destroy($id)
	{
		$application = $this->model->find($id);
		$application->delete();
	}
}