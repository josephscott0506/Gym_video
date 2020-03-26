<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Services\UserService;
class AccountController extends Controller
{
    protected $userservice;
 
	public function __construct(UserService $userservice)
	{
        $this->userservice = $userservice;
    }
    public function gymowner(Request $request)
    {
        $user = $request->user();
        $gymownerid = $user->id;
        $data = $this->userservice->getGymSummary($gymownerid);
        
        return view('gymowner', $data);
    }

    public function student()
    {
        return view('studentaccount');
    }

    public function members($id)
    {
        return view('memberaccount');
    }

    public function gymlist()
    {
        return view('gymlist');
    }
}
