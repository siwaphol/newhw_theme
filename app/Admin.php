<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {

    protected $table = 'admins';

    protected $fillable = ['username', 'name'];

    protected $primaryKey = 'username';

    public $incrementing = false;


}
