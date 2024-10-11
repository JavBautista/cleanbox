<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get(Request $request)
    {

        if(!$request->ajax()) return redirect('/');

        $products = Product::orderBy('id', 'desc')
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
                'total'=> $products->total(),
                'current_page'=> $products->currentPage(),
                'per_page'=> $products->perPage(),
                'last_page'=> $products->lastPage(),
                'from'=> $products->firstItem(),
                'to'=> $products->lastItem(),
            ],
            'products'=>$products,
        ];

    }//get();

    public function store(Request $request)
    {
        $product = new Product;
        $product->active=1;
        $product->category_id = $request->category_id;
        $product->key = $request->key;
        $product->key_alt = $request->key_alt;
        $product->barcode = $request->barcode;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->purcahse_unit = $request->purcahse_unit;
        $product->sales_unit = $request->sales_unit;
        $product->factor = $request->factor;
        $product->tax = $request->tax;
        $product->net = $request->net;
        $product->cost = $request->cost;
        $product->price_1 = $request->price_1;
        $product->price_2 = $request->price_2;
        $product->price_3 = $request->price_3;
        $product->price_4 = $request->price_4;
        $product->save();
    }

    public function update(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $product->category_id = $request->category_id;
        $product->key = $request->key;
        $product->key_alt = $request->key_alt;
        $product->barcode = $request->barcode;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->purcahse_unit = $request->purcahse_unit;
        $product->sales_unit = $request->sales_unit;
        $product->factor = $request->factor;
        $product->tax = $request->tax;
        $product->net = $request->net;
        $product->cost = $request->cost;
        $product->price_1 = $request->price_1;
        $product->price_2 = $request->price_2;
        $product->price_3 = $request->price_3;
        $product->price_4 = $request->price_4;
        $product->save();

    }

    public function deactive(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->active = 0;
        $product->save();

    }

    public function active(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->active = 1;
        $product->save();

    }
}
