<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //dd($request);
        $categories = Category::with('subcategories')->where('active',1)->orderBy('name')->get();

        $categories2 = Category::with('subcategories')->where('active',1)->limit(6)->get();
        //dd($categories);

        $products = Product::where('active', 1)
            ->with(['images' => function ($query) {
                $query->wherePivot('selected', true); // Carga solo la imagen seleccionada
            }])
            ->inRandomOrder() // Orden aleatorio
            ->limit(8)
            ->get();

        $products2 = Product::where('active', 1)
            ->with(['images' => function ($query) {
                $query->wherePivot('selected', true); // Carga solo la imagen seleccionada
            }])
            ->inRandomOrder() // Orden aleatorio
            ->limit(8)
            ->get();

        return view('web.index',['categories'=>$categories,'categories2'=>$categories2,'products'=>$products,'products2'=>$products2]);
/*
        $request->user()->authorizeRoles(['superadmin', 'admin', 'client']);

        if($request->user()->hasRole('superadmin'))
            return redirect('/superadmin');

        //if($request->user()->hasRole('admin'))
          //  return redirect('/client');

        //if($request->user()->hasRole('client'))
          //  return redirect('/client');

        return redirect('/');
        */
    }//.index()

    public function passwordReset(Request $request){
        return view('user.reset_password');
    }//.passwordReset()

    public function updatePassword(Request $request){

        $user_id=$request->user()->id;
        $user = User::find($user_id);
        $user->password = Hash::make( $request->input('password') );
        $user->setRememberToken(Str::random(60));
        $user->save();

        $this->guard()->login($user);

        /*
            $request->user()->authorizeRoles(['seller', 'admin', 'buyer']);

            if($request->user()->hasRole('seller'))
                return redirect('/seller');

            if($request->user()->hasRole('buyer'))
                return redirect('/buyer');

            if($request->user()->hasRole('admin'))
                return redirect('/admin');

            return redirect('/');
            //return view('user.reset_password');
        */
        return redirect('/');

    }//.updatePassword()

    protected function guard()
    {
        return Auth::guard();
    }

    public function shop(){
        return view('web.shop');
    }
    public function detail(){
        return view('web.detail');
    }
    public function contact(){
        return view('web.contact');
    }
}
