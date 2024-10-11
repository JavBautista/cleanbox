<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function get(Request $request)
    {

        if(!$request->ajax()) return redirect('/');

        $categories = Category::orderBy('id', 'desc')
                ->when($request->buscar!='', function ($query) use ($request) {
                        return $query->where($request->criterio, 'like', '%'.$request->buscar.'%');
                    })
                ->when($request->estatus != '', function ($query) use ($request) {
                        // Filtrar por estatus
                        if ($request->estatus === 'active') {
                            return $query->where('active', 1);
                        } elseif ($request->estatus === 'inactive') {
                            return $query->where('active', 0);
                        }
                    })
                ->paginate(15);

        return [
            'pagination'=>[
                'total'=> $categories->total(),
                'current_page'=> $categories->currentPage(),
                'per_page'=> $categories->perPage(),
                'last_page'=> $categories->lastPage(),
                'from'=> $categories->firstItem(),
                'to'=> $categories->lastItem(),
            ],
            'categories'=>$categories,
        ];

    }//get();

    public function store(Request $request)
    {
        $category = new Category;
        $category->active=1;
        $category->name=$request->name;
        $category->description=$request->description;
        $category->save();
    }

    public function update(Request $request)
    {

        $category = Category::findOrFail($request->id);
        $category->name=$request->name;
        $category->description=$request->description;
        $category->save();
    }

    public function deactive(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->active = 0;
        $category->save();

    }

    public function active(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->active = 1;
        $category->save();

    }
}
