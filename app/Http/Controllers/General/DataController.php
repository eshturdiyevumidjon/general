<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Ixudra\Curl\Facades\Curl;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $r_days_in_month = date('t',strtotime (Input::get('month')));// shu oyda necha kun borligi
	    $informations = [];

	    return view('general.pages.data.information.information',[
		    'r_days_in_month'=>$r_days_in_month,
		    'informations'=>$informations,

	    ]);
    }

	public function getView()
	{
		$r_days_in_month = date('t',strtotime (Input::get('month')));// shu oyda necha kun borligi
		$informations = [];

		return view('general.pages.data.information.get_view',[
			'r_days_in_month'=>$r_days_in_month,
			'informations'=>$informations,

		]);
	}



    public function  getViewPost()
    {
	    $date = Input::get('month');
	    $date = explode('-',$date);
	    $r_days_in_month = date('t',strtotime (Input::get('month')));// shu oyda necha kun borligi


	    $response = Curl::to('http://213.230.126.118:8080/api/get-view')
	                    ->withData( array(
		                    'month' => $date[1],
		                    'year' => $date[0],
		                    'kun' => $r_days_in_month,
	                    ))
	                    ->withHeader('Accept: application/json')
	                    ->withHeader('Content-Type: application/json ')
	                    ->get();
	    $informations = json_decode($response);
	    $r_days_in_month = date('t',strtotime (Input::get('month')));// shu oyda necha kun borligi


	    return view('general.pages.data.information.get_view',[
		    'informations'=>$informations,
		    'r_days_in_month'=>$r_days_in_month,
		    'date'=>Input::get('month')
	    ]);
    }


    public function getInfo()
    {
    	$date = Input::get('month');
    	$date = explode('-',$date);
	    $r_days_in_month = date('t',strtotime (Input::get('month')));// shu oyda necha kun borligi


	    $response = Curl::to('http://213.230.126.118:8080/api/get-value')
	                    ->withData( array(
	                    	'month' => $date[1],
	                    	'year' => $date[0],
	                    	'kun' => $r_days_in_month,
		                    ))
		    ->withHeader('Accept: application/json')
		    ->withHeader('Content-Type: application/json ')
	                    ->get();
	     $informations = json_decode($response);
	    $r_days_in_month = date('t',strtotime (Input::get('month')));// shu oyda necha kun borligi


	    return view('general.pages.data.information.information',[
	    	'informations'=>$informations,
	    	'r_days_in_month'=>$r_days_in_month,
	    ]);


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
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
