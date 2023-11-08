<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

	function create()
	{
		return view('admin.login');
	}

	function store(Request $request)
	{
		$formFields = $request->validate([
			'email' => 'required',
			'password' => 'required',
		]);


		if (Auth::guard('admin')->attempt($formFields)) {
			return redirect('/admin');
		}
		Session::flash('error-message', 'Invalid Email or Password');
		return back();
	}


	function dashboard()
	{
		return view('admin.dashboard');
	}

	function edit()
	{
		return view('admin.edit');
	}

	function destroy(Request $request)
	{
		Auth::guard('admin')->logout();
		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect('/');
	}
}
