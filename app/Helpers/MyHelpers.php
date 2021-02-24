<?php

namespace App\Helpers;

class MyHelpers 
{

	public static  function getLocaleValue($key)
	{
		$lang_id = \App\Models\Language::where('language_prefix', app()->getLocale())->first();
		if($lang_id) $metki = \App\Models\Metki::select('mark_name')->where('id_column', $key)->where('language_id',$lang_id->id)->first();

		if(isset($metki)) return $metki->mark_name;
		
    	return $key;
	}
}
