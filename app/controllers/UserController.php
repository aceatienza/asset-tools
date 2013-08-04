<?php

class UserController extends BaseController {
    /**
    * User Model
    * @var User
    */
        protected $user;

    /**
    * Inject the models.
    * @param User $user
    */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function index() 
    {
        $users = User::all();
        return View::make('users.index')->with('users', $users);
    }
 
    public function create()
    {
        return View::make('users.create');
    }

    // GET /user/{id}  show    user.show
    public function show($id)
    {
        $user = User::find($id);
        return View::make('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), '_method');
        $validation = Validator::make($input, User::$updateRules);

        if ($validation->passes())
        {
            $user = $this->user->find($id);
            // $user->portfolios()->attach($input['Portfolios']);
            $user->update($input);

            return Redirect::route('control.users.edit', array($id));
        }

        return Redirect::route('control.users.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function store()
    {
        $user = new User;

        $user->username = Input::get( 'username' );
        $user->email = Input::get( 'email' );
        $user->password = Input::get( 'password' );
        $user->password_confirmation = Input::get( 'password_confirmation' );
        $user->confirmed = 1;  // automatically confirm user. remove if want to confirm via email

        // find the Role object matching the role of the input
        $role = Input::get('role');                                 // string
        $role = Role::where('name', '=', $role)->firstOrFail();     // object

        // Save if valid. Password field will be hashed before save
        $user->save();

        if ( $user->id )
        {
            $user->attachRole($role);
            // Redirect with success message, You may replace "Lang::get(..." for your custom message.
            return Redirect::to('control')
                ->with( 'notice', Lang::get('confide::confide.alerts.account_created') );
        }
        else
        {
            // Get validation errors (see Ardent package)
            $error = $user->errors()->all(':message');

                        return Redirect::to('control/user/create')
                            ->withInput(Input::except('password'))
                ->with( 'error', $error );
        }
    }


    /**
     * Attempt to confirm account with code
     *
     * @param  string  $code
     */
    public function getConfirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
                        return Redirect::to('user/login')
                            ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
                        return Redirect::to('user/login')
                            ->with( 'error', $error_msg );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgot()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     */
    public function postForgot()
    {
        if( Confide::forgotPassword( Input::get( 'email' ) ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
                        return Redirect::to('user/login')
                            ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
                        return Redirect::to('user/forgot')
                            ->withInput()
                ->with( 'error', $error_msg );
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     */
    public function postReset()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( Confide::resetPassword( $input ) )
        {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
                        return Redirect::to('user/login')
                            ->with( 'notice', $notice_msg );
        }
        else
        {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
                        return Redirect::to('user/reset/'.$input['token'])
                            ->withInput()
                ->with( 'error', $error_msg );
        }
    }

}