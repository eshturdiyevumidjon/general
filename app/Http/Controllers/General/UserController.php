<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Additional\Divisions;
use App\Models\Additional\Level;
use App\Models\Additional\Positions;
use App\Models\Additional\Role;
use App\Models\Additional\UserAttrs;
use App\Models\Additional\UzRegions;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()) {
            $users = User::where('isDeleted',false)
                //->where('user_type', 'general')
                ->with('level', 'user_attr', 'role')
                ->orderby('email','ASC')
                ->paginate(10);
            
            $positions = Positions::all();
            $divisions = Divisions::all();
            $levels = Level::all();
            $rolls = Role::get();
            //dd($rolls);
            return view('admin.users.users')
                ->with('positions',$positions)
                ->with('divisions',$divisions)
                ->with('levels',$levels)
                ->with('users',$users)
                ->with('rolls',$rolls);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users',
            'lastname' => 'required|max:255',
            'firstname' => 'required|max:255',
            'middlename' => 'required',
            'roll_id' => 'required',
            'user_email' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|max:255|min:6',
        ]);

        $users = new User();
        $users->email = $request->email;
        $users->lastname = $request->lastname;
        $users->firstname = $request->firstname;
        $users->middlename = $request->middlename;
        $users->user_email = $request->user_email;
        $users->password = Hash::make($request->password);
        $users->role_id = $request->roll_id;
        $users->user_type = "general";
        $users->org_name = $request->get('org_name');
        $users->save();

        //$users->assignRole($request->roll_id);
        return redirect(route('general.admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = User::where('id',$request->get('id'))->with('level','user_attr','role')->first();
	    return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
	    $users = User::find($request->get('id'));

	    $request->validate([
            'email' => 'required',
            'lastname' => 'required|max:255',
            'firstname' => 'required|max:255',
            'middlename' => 'required',
            //'roll_id' => 'required',
            'user_email' => 'required|max:255',
            'password' => 'required|confirmed|max:255|min:6',
        ]);

	    $users->email = $request->email;
	    $users->lastname = $request->lastname;
	    $users->firstname = $request->firstname;
	    $users->middlename = $request->middlename;
	    $users->level_id = $request->level_id;
	    $users->user_email = $request->user_email;
	    $users->org_name = $request->get('org_name');
	    $users->password = Hash::make($request->password);
	    $users->save();

	    // $users->syncRoles($request->roll_id);
	    return redirect(route('general.admin'));
    }

	public function SelectPosition(Request $request)
	{
		$positions = UserAttrs::select('minvodxoz_division_id')->where('user_id', $request->id)->get();
		return $positions;
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
	    User::where('id',$id)->update(['isDeleted'=>true]);
	    return redirect(route('general.admin'));
    }
}
