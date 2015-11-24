<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Homework1s extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'homework';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'cours_id', 'section', 'name', 'type_id', 'detail', 'sub_folder', 'assign_date', 'due_date', 'accept_date','create_by','semester','year'];

    public $incrementing = true;

    protected $primaryKey = 'id';
}