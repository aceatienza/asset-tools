<?php

use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideEloquentRepository;
/* Entrust: relation with Role and the following methods roles, hasRole( $name ), 
	 can( $permission ), and ability($roles, $permissions, $options) */
use Zizaco\Entrust\HasRole;					


class User extends ConfideUser {

	use HasRole;  							// $this->belongsToMany('Role', 'assigned_roles');

	protected $table = 'users';
	protected $hidden = array('password');
 	protected $fillable = array('username', 'email', 'password');

 	// Override ConfideUser rules
    public static $rules = array(
        'username' => 'required|alpha_dash|unique:users',
        'email' => 'email|unique:users',
        'password' => 'required|between:4,11|confirmed',
        'password_confirmation' => 'between:4,11',
    );
    protected $updateRules = array(
        'username' => 'required|alpha_dash',
        'email' => 'email',
        'password' => 'between:4,11|confirmed',
        'password_confirmation' => 'between:4,11',
    );


	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getUserByUsername( $username )
    {
        return $this->where('username', '=', $username)->first();
    }
    
	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Get user's id.
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	public function portfolios()
	{
		return $this->belongsToMany('Portfolio');
	}

	/**
	*	Override Confide's aftersave to prevent it from sending confirmation email;
	*	@return true 
	*/
	public function afterSave()
    {
	   	// add default role of user after $succes
        return true;
    }
}