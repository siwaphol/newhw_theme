<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'roles';

    protected $fillable = ['id', 'role_detail'];

    public $incrementing = false;


}
