<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Video;
use App\Gym;

use App\Services\UserService;
use App\Services\GymService;
use Spatie\Activitylog\Models\Activity;

class AccountController extends Controller
{
    protected $userservice;
    protected $gymservice;

	public function __construct(UserService $userservice, GymService $gymservice)
	{
        $this->userservice = $userservice;
        $this->gymservice = $gymservice;
    }

    /**
     * Get gym information
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */    
    public function gymOwner(Request $request)
    {
        $user = $request->user();
        $gymSummary = $this->userservice->getGymSummary($user->id);
      
        return view('gymowneraccount', $gymSummary);
    }    
    
    /**
    * Get gym information
    *
    * @param Illuminate\Http\Request
    * @return \Illuminate\Contracts\Support\Renderable
    */    
    public function gymOwnerDetails(Request $request)
    {
        $user = $request->user();
        $data = $this->userservice->getGymSummary($user->id);
      
        return view('gymownerdetails', $data);
    }    

    /**
    * Get gym information
    *
    * @param Illuminate\Http\Request
    * @return \Illuminate\Contracts\Support\Renderable
    */  
    public function gymDetails(Request $request)
    {
        $user = $request->user();
        $data = $this->userservice->getGymSummary($user->id);
      
        return view('gymdetails', $data);
    }

    /**
     * Get members information
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */ 
    public function members($id)
    {
        return view('members');
    }
    
    /**
     * Show student page
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */ 
    public function student(Request $request)
    {
        $user = $request->user();
        $members = $this->userservice->getApprovedMembers($user);
       
        return view('memberaccount', ['members'=> $members, 'user' => $user]);
    }

      
    /**
     * Show student page
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */   
    public function studentDetails(Request $request)
    {
        $user = $request->user();
        $members = $this->userservice->getApprovedMembers($user);
       
        return view('studentaccountdetails', ['members'=> $members, 'user' => $user]);
    }

    /**
     * Update user page
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */ 
    public function updateUser($id, UpdateUserRequest $request)
	{
        $user = $request->user();
        $this->userservice->update($request, $id);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('update_user');

        return redirect()->back()->with('success', 'My Account Details have been updated successfully!');
    }
  
            
    /**
     * Update user page
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */ 
    public function gymList()
    {
        return view('gymlist');
    }
            
    /**
     * get member activities
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminActivity()
    {   
        $activities = Activity::orderBy('created_at','desc')->get();

        return view('adminmemberactivity', ['activities'=>$activities]);
    }

    /**
     * Get gym activities
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */ 
    public function gymActivity($gym_id, Request $request)
    {
        $user = auth()->user();
        $activities = $this->userservice->getGymActivities($gym_id, $user->id);
        $gym = $this->gymservice->read($gym_id);

        return view('gymmemberactivity', ['activities'=>$nactivites, 'gym'=>$gym]);
    }
}
