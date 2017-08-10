<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		if (\Auth::check()){
			return redirect("/home");
		}

		return view("auth.landing_page");
	}

	public function testStylus()
	{
		return view('teststylus');
	}

}
