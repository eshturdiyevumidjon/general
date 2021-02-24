<?php

namespace App\Http\Controllers\General;

use App\General\ListPosts;
use App\Http\Requests\ListPostEditRequest;
use App\Http\Requests\ListPostRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class ListPostsController extends Controller
{
    public function index()
    {
    	$directories = ListPosts::where('isDelete',false)->orderby('order','ASC')->paginate(10);
    	return view('general.pages.directories.list_posts',[
    		'directories'=>$directories
	    ]);
    }

    public function edit(Request $request)
    {
    	$directories = ListPosts::find($request->id);
    	return $directories;
    }

	public function update(ListPostEditRequest $request)
	{
		$directories = ListPosts::find($request->id);
		$directories->name = $request->name_edit;
		$directories->post_place = $request->post_place_edit;

		if ($request->isFavotire_edit) $directories->isfavorite = true;
		else $directories->isfavorite = false;

		$directories->save();

		return redirect(route('general.directories.list_posts'));
	}

	public function store(ListPostRequest $request)
	{
		$directories = new ListPosts();
		$directories->order = $request->order;
		$directories->name = $request->name;
		$directories->post_place = $request->post_place;
		if ($request->isFavotire) $directories->isfavorite = true;
		else $directories->isfavorite = false;
		$directories->save();

		return redirect(route('general.directories.list_posts'));
	}

	public function destroy($id)
	{
		$directories = ListPosts::find($id);
		$directories->isDelete = true;
		$directories->save();

		return redirect(route('general.directories.list_posts'));
	}
}
