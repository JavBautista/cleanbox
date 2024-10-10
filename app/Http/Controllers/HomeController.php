<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //return view('home');

        $request->user()->authorizeRoles(['superadmin', 'admin', 'client']);

        if($request->user()->hasRole('superadmin'))
            return redirect('/superadmin');

        //if($request->user()->hasRole('admin'))
          //  return redirect('/client');

        //if($request->user()->hasRole('client'))
          //  return redirect('/client');

        return redirect('/');
    }
}
