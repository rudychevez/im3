<?php


class UserController extends BaseController
{
	protected $layout = 'layout.default';

	
	public function logIn( $serial = '' )
	{
		if ( Auth::check () ) {
			return Redirect::to ( 'client/' );
		} else {
			return View::make ( 'user.login', array( 's' => $serial ) );
		}
	}
	

	public function validateLogIn()
	{
		$user     = Input::get ( 'user' );
		$password = Input::get ( 'password' );
		
		$attemp = array (
				'user' => $user,
				'password' => $password,
				'status' => 'ON' 
		);
		
		$serial = ( Input::get ( 's' ) != '' ) ? Input::get ( 's' ) : '';
		
		if (Cookie::get ( 's' ) == '') {
			$attemp ['user_type'] = 'admin';
			
			if( Branch::where ( 'serial', '=', Input::get ( 's' ) )->count () != 1 ) {
				return Redirect::to ( 'login/' . $serial )->with ( 'error', 'wrong address to set up and pc' );
			}
			
		} else {
			if ( Branch::where ( 'serial', '=', Cookie::get ( 's' ) )->count () != 1) {
				return Redirect::to ( 'login/' . $serial )->with ( 'error', 'cookie broken' );
			}
		}
		
		
		
		if ( Auth::attempt ( $attemp ) ) {
			
			$branchInfo = Branch::find ( Auth::user()->id_branch );
			Session::put( 'branch',   $branchInfo->branch );
			Session::put( 'logo',     $branchInfo->logo );
			Session::put( 'phone',    $branchInfo->phone );
			Session::put( 'address',  $branchInfo->address );
			Session::put( 'city',     $branchInfo->city );
			Session::put( 'zip_code', $branchInfo->zip_code );
			Session::put( 'state',    $branchInfo->state );
			Session::put( 'remind_insurance_expiration', $branchInfo->remind_insurance_expiration );
			
			if ( Cookie::get ( 's' ) == '' ) {
				$serialCookie = Cookie::make ( 's', Input::get ( 's' ), 9000 );
				return Redirect::to ( 'client/add' )->withCookie ( $serialCookie );
			}
			
			return Redirect::to ( 'client/add' );
		} else {
			return Redirect::to ( 'login/' . $serial )->with ( 'error', 'log in fail' );
		}
	}
	
	public function logOut()
	{
		Auth::logout();
		
		return Redirect::to ( 'login/' )->with ( 'message', 'Log out' );
	}
}
?>