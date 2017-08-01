<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Response;
use Hash;
use Session;
use Redirect;
use App\LawyerDetails;
class Authentication extends Controller
{
	public function LogOut(){
		Auth::logout(); //Logging Out The User
    	Session::flush(); //Clearing The Session
    	return Redirect::to('/login');
	}
    public function LogIn(Request $request){
    	$inputData = $request->all();
    	$email = $inputData['email'];
    	$password = $inputData['password'];
    	if (Auth::attempt(['email'=>$email,'password'=>$password])) {
    		$userId = Auth::id();

            // Getting User Data -----------
            $userData = User::find($userId);
            $userName = $userData->name;

    		session(['userId' => $userId, 'userType' => "Lawyer", 'userName' => $userName, 'userEmail' => $email]); //Creating The Session
	      	return Response::json(array(
	          		'success' => true
	        ));
        }
        else{
        	return Response::json(array(
	          		'success' => false
	        	));
        }
    }
    public function GetRegisterForm(){
    	return view("Pages.Register");
    }
    public function Register(Request $request){
    	$inputData = $request->all(); //Getting All Form Input Data
    	$Name = $inputData['name'];
    	$Email = $inputData['email'];
    	$PhoneNumber = $inputData['phoneNumber'];
    	$Password = $inputData['password'];
    	$password_confirmation = $inputData['password_confirmation'];
    	if ($Password != $password_confirmation) {
    		return Response::json(array(
	          		'Status' => "PasswordMismatch"
	        ));
    	}

    	//Creating data for Users table
	    $userData = array(
	      'name'      => $Name,
	      'email'     =>  $Email,
	      'password'  =>  $Password,
	      'created_at' => \Carbon\Carbon::now(),
	      'updated_at' => \Carbon\Carbon::now(),
	    );
        $userData['password'] = Hash::make($userData['password']);
    	$userId = User::insertGetId($userData);

    	$ld = new LawyerDetails;
    	$ld->id = $userId;
    	$ld->Name = $Name;
    	$ld->Email = $Email;
    	$ld->PhoneNumber = $PhoneNumber;
    	$ld->UserRole = "Lawyer";
    	$ld->save();

    	if (Auth::attempt(['email'=>$Email,'password'=>$Password])) {
    		session(['userId' => $userId, 'userType' => "Lawyer", 'userName' => $Name, 'userEmail' => $Email]);
	      	return Response::json(array(
	          		'Status' => "Registered"
	        ));
        }

    }
}
