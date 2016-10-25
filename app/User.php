<?php namespace App;


use Illuminate\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

/**
 * Class User
 * @package App
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    protected $auth,$data,$role_id;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password','passport','phone'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];




    /**
     * a user can have many articles
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(){
        return $this->hasMany('App\Article');
    }


    /**
     * User Roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    /**
     * User INFO
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function details(){
        return $this->belongsToMany('App\Detail');
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasRole($name){
        foreach($this->roles as $role):
            if(is_array($name)){
                if(in_array($role->name,$name)){
                    return true;
                }
            }else if($role->name == $name) {
                return true;
            }
        endforeach;

        return false;
    }



    public function scopeOrderRole($query,array $data){
        $this->data = $data;
        $query->with(['roles' => function ($q) {
                $q->whereNotIn('name',$this->data);
            }]);
        $query->whereHas('roles',function($q){
            $q->whereNotIn('name',$this->data);
        });
    }

    public function scopeOrderRoleIn($query,array $data){
        $this->data = $data;
        $query->with(['roles' => function ($q) {
            $q->whereIn('name',$this->data);
        }]);
        $query->whereHas('roles',function($q){
            $q->whereIn('name',$this->data);
        });
    }

    public function scopeUserDetails($query,array $data){
        $this->data = $data;
        $query->with(['details' => function ($q) {
            $q->where('details.lang',App::getLocale())->whereIn('details.user_id',$this->data)->select('full_name');
        }]);
        $query->whereHas('details',function($q){
            $q->where('details.lang',App::getLocale())->whereIn('details.user_id',$this->data);
        });
    }


    public function scopeUserName($query,$data){
        $this->data = $data;

        $query->with(['details' => function ($q) {
            $q->where('details.lang',App::getLocale())->where('details.full_name','LIKE','%'.$this->data.'%')->select('details.full_name');
        }]);
        $query->whereHas('details',function($q){
            $q->where('details.lang',App::getLocale())->where('details.full_name','LIKE','%'.$this->data.'%');
        });
    }



    /**
     * @param $pass
     * @return array
     */


    public function setPasswordAttribute($pass){
        if(!empty($pass)){
            $this->attributes['password'] = bcrypt($pass);
        }
    }

    /**
     * adding user role
     * @param array $data
     */
    public function addRole(array $data){
        $user = User::find($data['user_id']);
        $this->role_id = ($data['role_id'] > 0) ? $data['role_id'] : $data['default'];
        $user->roles()->attach($this->role_id);
    }


    /**
     * @param array $data
     */
    public function updateRole(array $data){
        $cat = $this->find($data['user_id']);
        $cat->roles()->detach();
        $cat->roles()->attach($data['id']);
    }


    public function getUsers($data = array(),$order = ''){
        if(!empty($order)){
            $explode = explode('|',$order);
            $name = $explode[0];
            $order = $explode[1];
        }else{
            $name = 'id';
            $order = 'desc';
        }
        return $this->orderBy($name,$order)->orderrolein($data)->get();
    }



}
