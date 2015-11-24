<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

class HomeworkType extends Model {

    protected $table = 'homework_types';

    protected $fillable = ['id','extension'];

    protected $exclude_extension = ['002'];

    //Important
    //to create or save for this model simply use HomeworkType::create(['extension'=>'here is extension']);
    protected function excludeExtension(){
        $exclude_list = ['001','002'];
        return $exclude_list;
    }

    //return false if a extension is not exluded
    public function isExclude(){
        if(array_search($this->attributes['id'],$this->exclude_extension) != false){
            return false;
        }else{
            return true;
        }
    }

}
