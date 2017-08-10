<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		return redirect('oauth/login');
	}

	public function testStylus()
	{
		return view('teststylus');
	}

}
