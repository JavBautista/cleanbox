<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function get(Request $request)
    {

        if(!$request->ajax()) return redirect('/');

        $customers = Customer::orderBy('id', 'desc')
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
                'total'=> $customers->total(),
                'current_page'=> $customers->currentPage(),
                'per_page'=> $customers->perPage(),
                'last_page'=> $customers->lastPage(),
                'from'=> $customers->firstItem(),
                'to'=> $customers->lastItem(),
            ],
            'customers'=>$customers,
        ];

    }//get();

    public function store(Request $request)
    {
        $customer = new Customer;
        $customer->active=1;
        $customer->name=$request->name;
        $customer->alias=$request->alias;
        $customer->company=$request->company;
        $customer->rfc=$request->rfc;
        $customer->curp=$request->curp;
        $customer->email=$request->email;
        $customer->phone=$request->phone;
        $customer->movil=$request->movil;
        $customer->address=$request->address;
        $customer->zip_code=$request->zip_code;
        $customer->number_out=$request->number_out;
        $customer->number_int=$request->number_int;
        $customer->district=$request->district;
        $customer->city=$request->city;
        $customer->state=$request->state;
        $customer->reference=$request->reference;
        $customer->detail=$request->detail;
        $customer->observations=$request->observations;
        $customer->save();
    }

    public function update(Request $request)
    {

        $customer = Customer::findOrFail($request->id);
        $customer->name=$request->name;
        $customer->alias=$request->alias;
        $customer->company=$request->company;
        $customer->rfc=$request->rfc;
        $customer->curp=$request->curp;
        $customer->email=$request->email;
        $customer->phone=$request->phone;
        $customer->movil=$request->movil;
        $customer->address=$request->address;
        $customer->zip_code=$request->zip_code;
        $customer->number_out=$request->number_out;
        $customer->number_int=$request->number_int;
        $customer->district=$request->district;
        $customer->city=$request->city;
        $customer->state=$request->state;
        $customer->reference=$request->reference;
        $customer->detail=$request->detail;
        $customer->observations=$request->observations;
        $customer->save();
    }

    public function deactive(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->active = 0;
        $customer->save();

    }

    public function active(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->active = 1;
        $customer->save();

    }
}
