<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class AppController extends Controller
{
    public function getCategories(Request $request)
    {
        $buscar = $request->buscar;
        if($buscar==''){
            $categories = Category::where('active',1)
                    ->orderBy('id','desc')
                    ->paginate(10);
        }else{
            $categories = Category::where('active',1)
                    ->where('name', 'like', '%'.$buscar.'%')
                    ->orderBy('id','desc')
                    ->paginate(10);
        }
        return $categories;
    }
}
