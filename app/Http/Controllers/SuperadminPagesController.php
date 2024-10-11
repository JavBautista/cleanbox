<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperadminPagesController extends Controller
{
    public function index(){
        return view('superadmin.index');
    }

    public function categories(){
        return view('superadmin.categories');
    }

    public function products(){
        return view('superadmin.products');
    }

    public function suppliers(){
        return view('superadmin.suppliers');
    }

    public function customers(){
        return view('superadmin.customers');
    }
}
