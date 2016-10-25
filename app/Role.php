<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	protected $fillable = ['name','permissions'];

    protected $arr = array();

    protected $table = "roles";

    protected $permissions;

    /**
     * @param $permissions
     */
    public function setPermissionsAttribute($groups){

        if(is_array($groups)){
            foreach($groups as $key => $item){
                if(in_array('edit',$item)){
                    $groups = array_add($groups,$key.'.update','update');
                }
                if(in_array('index',$item)){
                    $groups = array_add($groups,$key.'.show','show');
                }
                if(in_array('create',$item)){
                    $groups = array_add($groups,$key.'.store','store');
                }
                $groups = array_add($groups,$key.'.filter','filter');
            }
        }


        $this->attributes['permissions'] = serialize($groups);

    }


    /**
     * @return Roles
     */
    public function roles(){
        $i=0;foreach($this->all() as $role){
            //$arr[$i]['permissions'] = $role->permissions;
            $this->arr[$i]['role'] = $role->name;
            $i++;
        }
        return $this->arr;
    }



    public function scopeNouser($query,array $data){
        $query->whereNotIn('name',$data);
    }









}
