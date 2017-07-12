<?php 
namespace Modules\Commercemetro\Repositories;

use Modules\Acl\Entities\Perimeter;
use Modules\Acl\Entities\Role;
use Module;

abstract class BaseRepository {
	/**
	 * The Model instance.
	 *
	 * @var Illuminate\Database\Eloquent\Model
	 */
	protected $model;
	/**
	 * Get number of records.
	 *
	 * @return array
	 */

	public function count()
	{
		return $this->model->count();
	}

	public function modulename()
    {
        $module = Module::get('commercemetro')->getLowerName();
        return $module;
    }

    public function perim()
	{
		$roles = Role::all(); 
        $perim = array();

        foreach ($roles as $role) 
        {
            if(is_array(session()->get('auth.'.$this->modulename().'.'.$role->slug)))
            {
                $perim = array_merge($perim, session()->get('auth.'.$this->modulename().'.'.$role->slug));
            }
        }
		return $perim;
	}

	public function userperim()
    {
        $userperim = Perimeter::whereIn('id',$this->perim())->get();
        return $userperim;
    }

	public function getNumber()
	{
		$total = $this->model->count();
		$new = $this->model->count();
		return compact('total');
	}

	public function find($id)
	{
		return $this->model->findOrFail($id);
	}
	/**
	 * Destroy a model.
	 *
	 * @param  int $id
	 * @return void
	 */
	public function destroy($id)
	{
		$this->getById($id)->delete();
	}
	/**
	 * Get Model by id.
	 *
	 * @param  int  $id
	 * @return App\Models\Model
	 */
	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}
}