<?php

namespace App\Http\Controllers\General;

use App\Models\Divisions;
use App\Models\Level;
use App\Models\Positions;
use App\Models\Role;
use App\Models\User;
use App\UserAttrs;
use App\UzDistricts;
use App\Models\UzRegions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
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
        if(Auth::check())
        {
            $user = Auth::user();
            if($user->user_type == 'minvodxoz')
            {

                $users = User::where('isDeleted',false)->where('user_type','minvodxoz')->with('level','user_attr')->orderby('email','ASC')->paginate(10);
                $positions = Positions::all();
                $divisions = Divisions::all();
                $levels = Level::all();
                $rolls = Role::get();
                $regions = UzRegions::all();
                return view('admin.users.users')
                    ->with('positions',$positions)
                    ->with('divisions',$divisions)
                    ->with('levels',$levels)
                    ->with('users',$users)
                    ->with('rolls',$rolls)
                    ->with('regions',$regions);

            }
            elseif($user->user_type == 'gidrogeologiya')
            {
                $users = User::where('isDeleted',false)->where('user_type','gidrogeologiya')->with('level','user_attr')->orderby('email','ASC')->paginate(10);
                $positions = Positions::all();
                $divisions = Divisions::all();
                $levels = Level::all();
                $rolls = Role::get();
                $regions = UzRegions::all();
                return view('gidrogeologiya.admin.users.users')
                    ->with('positions',$positions)
                    ->with('divisions',$divisions)
                    ->with('levels',$levels)
                    ->with('users',$users)
                    ->with('rolls',$rolls)
                    ->with('regions',$regions);


            }
            elseif($user->user_type == 'gidromet')
            {
                $users = User::where('isDeleted',false)->where('user_type','gidromet')->with('level','user_attr')->orderby('email','ASC')->paginate(10);
                $positions = Positions::all();
                $divisions = Divisions::all();
                $levels = Level::all();
                $rolls = Role::get();
                $regions = UzRegions::all();
                return view('gidromet.admin.users.users')
                    ->with('positions',$positions)
                    ->with('divisions',$divisions)
                    ->with('levels',$levels)
                    ->with('users',$users)
                    ->with('rolls',$rolls)
                    ->with('regions',$regions);
            }
            elseif($user->user_type == 'general')
            {
	            $users = User::where('isDeleted',false)->where('user_type','general')->with('level','user_attr')->orderby('email','ASC')->paginate(10);
	            $positions = Positions::all();
	            $divisions = Divisions::all();
	            $levels = Level::all();
	            $rolls = Role::get();
	            $regions = UzRegions::all();
	            return view('general.admin.users.users')
		            ->with('positions',$positions)
		            ->with('divisions',$divisions)
		            ->with('levels',$levels)
		            ->with('users',$users)
		            ->with('rolls',$rolls)
		            ->with('regions',$regions);
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $user = Auth::user();

        if($user->user_type == 'general')
        {
    	    $request->validate([
    		    'email' => 'required|unique:users',
    		    'lastname' => 'required|max:255',
    		    'firstname' => 'required|max:255',
    		    'middlename' => 'required',
    		    'roll_id' => 'required',
    		    'regions' => 'required|max:255',
    		    'user_email' => 'required|max:255|unique:users',
    		    'password' => 'required|confirmed|max:255|min:6',

    	    ]);
        }
        else
        {
    	    $request->validate([
    		    'email' => 'required|unique:users',
    		    'lastname' => 'required|max:255',
    		    'firstname' => 'required|max:255',
    		    'middlename' => 'required',
    		    'roll_id' => 'required',
    		    'division_id' => 'required',
    		    'regions' => 'required|max:255',
    		    'user_email' => 'required|max:255|unique:users',
    		    'password' => 'required|confirmed|max:255|min:6',

    	    ]);
        }


     	if($user->user_type == 'minvodxoz')
        {
            $users = new User();
            $users->email = Input::get('email');
            $users->lastname = Input::get('lastname');
            $users->firstname = Input::get('firstname');
            $users->middlename = Input::get('middlename');
            $users->level_id = Input::get('level_id');
            $users->region_id = Input::get('regions');
            $users->user_email = Input::get('user_email');
            $users->password = Hash::make(Input::get('password'));
            $users->user_type = "minvodxoz";
            $users->save();
            $users->assignRole(Input::get('roll_id'));

            foreach (Input::get('division_id') as $key=>$division)
            {
                $user_attr = new UserAttrs();
                $user_attr->user_id = $users->id;
                $user_attr->minvodxoz_division_id = $division;
                $user_attr->save();
            }

            return redirect(route('admin.users'));
        }
     	elseif($user->user_type == 'gidrogeologiya')
        {
            $users = new User();
            $users->email = Input::get('email');
            $users->lastname = Input::get('lastname');
            $users->firstname = Input::get('firstname');
            $users->middlename = Input::get('middlename');
            $users->level_id = Input::get('level_id');
            $users->region_id = Input::get('regions');
            $users->user_email = Input::get('email');
            $users->password = Hash::make(Input::get('password'));
            $users->user_type = "gidrogeologiya";
            $users->save();

            $users->assignRole(Input::get('roll_id'));


            foreach (Input::get('division_id') as $key=>$division)
            {
                $user_attr = new UserAttrs();
                $user_attr->user_id = $users->id;
                $user_attr->minvodxoz_division_id = $division;
                $user_attr->save();
            }


            return redirect(route('gidrogeologiya.admin.users'));
        }
        elseif($user->user_type == 'gidromet')
        {
            $users = new User();
            $users->email = Input::get('email');
            $users->lastname = Input::get('lastname');
            $users->firstname = Input::get('firstname');
            $users->middlename = Input::get('middlename');
            $users->level_id = Input::get('level_id');
            $users->region_id = Input::get('regions');
            $users->user_email = Input::get('email');
            $users->password = Hash::make(Input::get('password'));
            $users->user_type = "gidromet";
            $users->save();

            $users->assignRole(Input::get('roll_id'));


            foreach (Input::get('division_id') as $key=>$division)
            {
                $user_attr = new UserAttrs();
                $user_attr->user_id = $users->id;
                $user_attr->minvodxoz_division_id = $division;
                $user_attr->save();
            }


            return redirect(route('gm.admin.users'));
        }
        elseif($user->user_type == 'general')
        {
            $users = new User();
            $users->email = Input::get('email');
            $users->lastname = Input::get('lastname');
            $users->firstname = Input::get('firstname');
            $users->middlename = Input::get('middlename');
            $users->region_id = Input::get('regions');
            $users->user_email = Input::get('user_email');
            $users->password = Hash::make(Input::get('password'));
            $users->user_type = "general";
            $users->org_name = $request->get('org_name');
            $users->save();

            $users->assignRole(Input::get('roll_id'));

            return redirect(route('general.admin.users'));
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $user = User::where('id',$request->get('id'))->with('level','user_attr','roles')->first();
	    $roles = $user->getRoleNames();
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


	    if($users->user_type == 'general')
	    {
		    $request->validate([
			    'email' => 'required',
			    'lastname' => 'required|max:255',
			    'firstname' => 'required|max:255',
			    'middlename' => 'required',
			    'roll_id' => 'required',
			    'regions' => 'required|max:255',
			    'user_email' => 'required|max:255',
			    'password' => 'required|confirmed|max:255|min:6',

		    ]);
	    }
	    else
	    {
		    $request->validate([
			    'email' => 'required',
			    'lastname' => 'required|max:255',
			    'firstname' => 'required|max:255',
			    'middlename' => 'required',
			    'roll_id' => 'required',
			    'division_id' => 'required',
			    'regions' => 'required|max:255',
			    'user_email' => 'required|max:255',
			    'password' => 'required|confirmed|max:255|min:6',

		    ]);
	    }

	    $users->email = Input::get('email');
	    $users->lastname = Input::get('lastname');
	    $users->firstname = Input::get('firstname');
	    $users->middlename = Input::get('middlename');
	    $users->level_id = Input::get('level_id');
	    $users->region_id = Input::get('regions');
	    $users->user_email = Input::get('user_email');
	    $users->org_name = $request->get('org_name');

	    $users->password = Hash::make(Input::get('password'));
	    $users->save();

	    $users->syncRoles(Input::get('roll_id'));
	    if(Auth::user()->user_type != 'general')
        {
            UserAttrs::where('user_id',$users->id)->delete();
            foreach (Input::get('division_id') as $key=>$division)
            {
                $user_attr = new UserAttrs();
                $user_attr->user_id = $users->id;
                $user_attr->minvodxoz_division_id = $division;
                $user_attr->save();
            }
        }



	    if($users->user_type == 'minvodxoz')
	    return redirect(route('admin.users'));
	    elseif($users->user_type == 'general')
		    return redirect(route('general.admin.users'));
	    elseif($users->user_type == 'gidromet')
		    return redirect(route('gm.admin.users'));
	    elseif($users->user_type == 'gidrogeologiya')
		    return redirect(route('gidrogeologiya.admin.users'));





    }

	public function SelectPosition()
	{
		$positions = UserAttrs::select('minvodxoz_division_id')->where('user_id','=', Input::get('id'))->get();

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


	    User::where('id',$id)->update([
	        'isDeleted'=>true
        ]);

	    $users = Auth::user();

	    if($users->user_type == 'minvodxoz')
		    return redirect(route('admin.users'));
	    elseif($users->user_type == 'general')
		    return redirect(route('general.admin.users'));
	    elseif($users->user_type == 'gidromet')
		    return redirect(route('gm.admin.users'));
	    elseif($users->user_type == 'gidrogeologiya')
		    return redirect(route('gidrogeologiya.admin.users'));
    }
}
