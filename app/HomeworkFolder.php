<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeworkFolder extends Model {

    protected $table = 'homework_folder';

    protected $fillable = ['course_id', 'section', 'name', 'path','semester','year'];

}
