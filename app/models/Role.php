<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {
    protected $guarded = array();
    public static $rules = array();
    // protected $fillable = array('name');


    /*
    *  $users = Role::find($id)->users
    */
    // public function users()
    // {
    // 	return $this->hasMany('User', 'assigned_roles');
    // }
}