<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use Auth;
use Language;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpSpec\Exception\Exception;


class AuthController extends Controller
{
	private $mail;

	private $request;

	private $inputs;
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
		$this->mailer =  app()->make(\Snowfire\Beautymail\Beautymail::class);
		$this->request = $request;
		$this->inputs = $this->request->all();
    }


	/**
	 * Create new user
	 * @param array $data
	 * @return static
	 */
	protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
			'verification_key' => $data['verification_key']
        ]);
    }


    public function getRegister()
    {
        return view('auth.register');
    }


    public function postRegister()
    {
		$credentials = array_add( Input::all(), 'verification_key', str_random(20));
        $validation = $this->validateRegister($credentials);

        if( ! $validation->fails()){
            $this->create($credentials);
			$this->sendConfirmationEmail($credentials);
            return redirect()
                ->to(Language::getRoute('login'))
                ->withSuccess(trans('messages.confirm-subscription'));
        }

        return redirect()->back()
                ->withErrors($validation)
                ->withInput();
    }


	/**
	 * Confirm user subscription
	 * @param $segment
	 * @param $userToken
	 * @return $this
	 */
	public function getConfirmSubscription($segment, $userToken)
	{
		$user = User::where('verification_key','=', $userToken)->first();

		if($user && $user->confirmed == 0)
        {
			$user->confirmed = 1;
			$user->save();
			return redirect()
                ->to(Language::getRoute('login'))
                ->withSuccess(trans('messages.finished_register_process'));
		}

		return redirect()
            ->to(Language::getRoute('login'))
            ->withErrors(trans('errors.user_already_confirmed'));
	}


	/**
	 * Send user subscription confirmation email
	 * @param array $request
	 */
	public function sendConfirmationEmail(array $request)
	{
		$data = ['verification_key' => $request['verification_key']];
		$this->mailer->send('emails.welcome', $data, function($message) use ($request)
		{
			$message
				->to($request['email'], $request['name'])
				->subject('Welcome!');
		});
	}


    public function getLogin()
    {
		if(Auth::check())
			return redirect()
                ->to(language::getRoute('dashboard'));
        return view('auth.login');
    }


	public function postLogin(LoginRequest $request)
    {
		if($this->validateLogin())
        {
            flash()->success('Bienvenido', 'este es tu dashboard');
			return redirect()->to(language::getRoute('dashboard'));
        }

        return redirect()->back()
            ->withErrors(trans('errors.invalid_user'))
            ->withInput();
    }


	public function getLogout()
	{
		if(Auth::check())
		{
			Auth::logout();
			return view('auth.logout');
		}
		return redirect()->route('login');
	}


    public function userLogout()
	{
		if(Auth::check())
			Auth::logout();
	}


    public function getResetPassword()
    {
        return view('auth.reset');
    }


	public function validateLogin()
	{
		$credentials = Input::only(['email', 'password']);

		if ($this->isValidUser() && Auth::attempt( $credentials, Input::has('remember')))
			return true;

		return false;
	}


    public function postResetPassword()
    {
        $email = Input::get('email');
		$validation = $this->validateResetPassword();

        if( ! $validation->fails()  && $this->isValidUser() )
        {
			$this->createPasswordToken($email);
			$this->sendResetPasswordEmail($email);

			flash()->success(trans('messages.check_your_email'), trans('messages.reset_email_sent'));
            return redirect()->back()
				->withSuccess(trans('messages.reset_email_sent'));;
        }

		return redirect()->back()
			->withErrors($validation);
    }


	public function sendResetPasswordEmail($email)
	{
		$user = User::where('email', $email);

		$this->mailer->send('emails.password',
			[
				'token' => $this->getPasswordToken($email)
			], function($message) use ($email, $user
		)
		{
			$message
				->to($email, $user->first()->name)
				->subject('Reset password');
		});
	}


	/**
	 * Create or update password token if exists
	 * @param $email
	 */
	public function createPasswordToken($email)
	{
		$token = str_random(64);
		$date = Carbon::now();

		if($this->existsPasswordToken($email))
		{
			DB::table('password_resets')
				->where('email', $email)
				->update([
					'token' => $token,
					'created_at' => $date
				]);
		}
		else
		{
			DB::table('password_resets')
				->insert([
					'email' => $email,
					'token' => $token,
					'created_at' => $date
				]);
		}

	}


	public function getPasswordToken($email)
	{
		$token = DB::table('password_resets')
			->where('email', $email);

		if($token->first() == null)
			throw new Exception("There's no token created for: ". $email. " to resest password");

		return $token->first()->token;
	}


	public function existsPasswordToken($email)
	{
		$user = DB::table('password_resets')->where('email', $email);

		return $user->get() != null;
	}


    public function isValidUser()
    {
        $user = User::where('email', '=', Input::get('email'))->first();
        if($user && $user->confirmed && $user->is_active)
            return true;

        return false;
    }


	private function validateRegister($request = null)
	{
		$request = ($request == null) ? $this->inputs : $request;

		return Validator::make($request, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'verification_key' => 'unique:users'
		]);
	}


	private function validateResetPassword($request = null)
	{
		$request = ($request == null) ? $this->inputs : $request;

		return Validator::make($request, [
			'email' => 'required|email'
		]);
	}
}
