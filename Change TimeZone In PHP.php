******************************* Change TimeZone In Database **********************************************

open app.php file  cofig/app.php

	'timezone' => 'Asia/Kolkata',



open web file


	Route::get('/', function(){
		dd(date_default_timezone_get());
		return view('index');
	})->name('index')