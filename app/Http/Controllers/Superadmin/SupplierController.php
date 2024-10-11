<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function get(Request $request)
    {

        if(!$request->ajax()) return redirect('/');

        $suppliers = Supplier::orderBy('id', 'desc')
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
                'total'=> $suppliers->total(),
                'current_page'=> $suppliers->currentPage(),
                'per_page'=> $suppliers->perPage(),
                'last_page'=> $suppliers->lastPage(),
                'from'=> $suppliers->firstItem(),
                'to'=> $suppliers->lastItem(),
            ],
            'suppliers'=>$suppliers,
        ];

    }//get();

    public function store(Request $request)
    {
        $supplier = new Supplier;
        $supplier->active=1;
        $supplier->number=$request->number;
        $supplier->name=$request->name;
        $supplier->alias=$request->alias;
        $supplier->company=$request->company;
        $supplier->rfc=$request->rfc;
        $supplier->curp=$request->curp;
        $supplier->email=$request->email;
        $supplier->phone=$request->phone;
        $supplier->movil=$request->movil;
        $supplier->address=$request->address;
        $supplier->zip_code=$request->zip_code;
        $supplier->number_out=$request->number_out;
        $supplier->number_int=$request->number_int;
        $supplier->district=$request->district;
        $supplier->city=$request->city;
        $supplier->state=$request->state;
        $supplier->reference=$request->reference;
        $supplier->detail=$request->detail;
        $supplier->observations=$request->observations;
        $supplier->save();
    }

    public function update(Request $request)
    {

        $supplier = Supplier::findOrFail($request->id);
        $supplier->number=$request->number;
        $supplier->name=$request->name;
        $supplier->alias=$request->alias;
        $supplier->company=$request->company;
        $supplier->rfc=$request->rfc;
        $supplier->curp=$request->curp;
        $supplier->email=$request->email;
        $supplier->phone=$request->phone;
        $supplier->movil=$request->movil;
        $supplier->address=$request->address;
        $supplier->zip_code=$request->zip_code;
        $supplier->number_out=$request->number_out;
        $supplier->number_int=$request->number_int;
        $supplier->district=$request->district;
        $supplier->city=$request->city;
        $supplier->state=$request->state;
        $supplier->reference=$request->reference;
        $supplier->detail=$request->detail;
        $supplier->observations=$request->observations;
        $supplier->save();
    }

    public function deactive(Request $request)
    {
        $supplier = Supplier::findOrFail($request->id);
        $supplier->active = 0;
        $supplier->save();

    }

    public function active(Request $request)
    {
        $supplier = Supplier::findOrFail($request->id);
        $supplier->active = 1;
        $supplier->save();

    }
}
