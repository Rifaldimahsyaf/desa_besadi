<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Validator;
use DataTables;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    public function viewPurchase()
    {
        $column_names = ['Product Name', 'Supplier', 'Unit', 'Price', 'Items' ,'Status'];
        $modelSupplier = Supplier::get()->toArray();
        $modelProduct = Product::get()->toArray();

        return view('purchase.list')->with(['column_names' => $column_names, 'list_supplier' => $modelSupplier, 'list_product' => $modelProduct ]);
    }

    public function viewUpdateSubject($id){
        $model = Subject::find($id)->format();

        return view('purchase.update')->with('model', $model);
    }

    public function showPurchaseAjax()
    {
        $model = Purchase::get()->map->format();


        return DataTables::of($model)->make(true);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product_id' => 'required|string|max:255',
            'supplier_id' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'price' => 'required|numeric',
            'items' => 'required|numeric',
     
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }


        $modelPurchase = Purchase::create([
            'id' => (String) Str::uuid(),
            'product_id' => $request->product_id,
            'supplier_id' => $request->supplier_id,
            'unit' => $request->unit,
            'price' => $request->price,
            'items' => $request->items,
            'status' => "proccess",
        ]);

        if($modelPurchase)
            return redirect()->intended('/purchase')->with('successMessage', 'Successfully Add Purchase.');

        return redirect()->back()->with('errorMessage', 'Failed Add Purcahse.');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'purchase_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelSubject = Subject::where('id', $request->purchase_id)->first();
        
        if(!$modelSubject)
            return response()->json(['status' => 'Subject Not Found.'], 422);

        $modelSubject->name = $request->name;
        $modelSubject->email = $request->email;
        $modelSubject->subject = $request->subject;
        $modelSubject->message = $request->message;
    

        if($modelSubject->save()){
            return redirect()->intended('/subject')->with('successMessage', 'Successfully Updating Subject.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Updating Subject.');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'purchase_id' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelPurchase = Purchase::find($request->purchase_id);

        if(!$modelPurchase)
            return response()->json(['status' => 'Purchase Not Found.'], 422);
        
        if($modelPurchase->delete()){
            return redirect()->back()->with('successMessage', 'Successfully Delete Purchase.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Delete Purchase.');
    }

}
