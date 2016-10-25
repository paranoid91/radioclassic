<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Poll extends Model
{
    protected $fillable = ['title','status','published_at','parent_id','answers','lang'];

    protected $data;
    /**
     * @param $date
     */
    public function setPublishedAtAttribute($date){
        $this->attributes['published_at'] = Carbon::createFromFormat('d/m/Y H:i',$date);
    }

    public function setAnswersAttribute(){
        $this->attributes['answers'] = count(Input::get('answer'));
    }

    public function scopeParent($query,array $data){
        $query->whereIn('parent_id',$data);
    }

    public function scopeOneParent($query,$data){
        $query->where('parent_id',$data);
    }



    public function pollStatus($poll){
        if($poll->status > 0)
        {
            $poll->update(['status'=>'0']);
            return 'deactivated';
        }else{
            Poll::where('status','=','1')->update(['status'=>'0']);
            $poll->update(['status'=>'1']);
            return 'activated';
        }
    }

    public function scopeGetVotes($query){

        $query->with(['votes'=>function($q){
            $q->select('cookie','poll_id','votes.parent_id');
        }]);


    }

    public function votes(){
        return $this->hasMany('App\Vote');
    }

}
