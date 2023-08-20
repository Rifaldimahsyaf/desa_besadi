<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public function viewSupplier()
    {
        $column_names = ['Name', 'Address'];
        return view('supplier.list')->with('column_names', $column_names);
    }

    public function viewUpdateSupplier($id){
        $model = Supplier::find($id)->format();

        return view('purchase.update')->with('model', $model);
    }

    public function showSupplierAjax()
    {
        $model = Supplier::get()->map->format();

        return DataTables::of($model)->make(true);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelSupplier = Supplier::create([
            'id' => (String) Str::uuid(),
            'name' => $request->name,
            'address' => $request->address,
        ]);

        if($modelSupplier)
            return redirect()->intended('/supplier')->with('successMessage', 'Successfully Add supplier.');

        return redirect()->back()->with('errorMessage', 'Failed Add supplier.');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'supplier_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelSupplier = Supplier::where('id', $request->supplier_id)->first();
        
        if(!$modelSupplier)
            return response()->json(['status' => 'Subject Not Found.'], 422);

        $modelSupplier->name = $request->name;
        $modelSupplier->address = $request->address;
    

        if($modelSupplier->save()){
            return redirect()->intended('/supplier')->with('successMessage', 'Successfully Updating Supplier.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Updating Supplier.');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'supplier_id' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelSupplier = Supplier::find($request->supplier_id);

        if(!$modelSupplier)
            return response()->json(['status' => 'Supplier Not Found.'], 422);
        
        if($modelSupplier->delete()){
            return redirect()->back()->with('successMessage', 'Successfully Delete Supplier.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Delete Supplier.');
    }

}
