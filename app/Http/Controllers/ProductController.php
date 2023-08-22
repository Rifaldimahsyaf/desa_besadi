<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class ProductController extends Controller
{
    public function viewProduct()
    {
        $column_names = ['Name', 'Unit', 'Purchase Price', 'Selling price', 'Items'];
        return view('product.list')->with('column_names', $column_names);
    }

    public function viewUpdateSupplier($id)
    {
        $model = Supplier::find($id)->format();

        return view('supplier.update')->with('model', $model);
    }

    public function showProductAjax()
    {
        $model = Product::get()->map->format();

        return DataTables::of($model)->make(true);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|string|max:255',
            'selling_price' => 'nullable|string|max:255',
            'items' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $modelProduct = Product::create([
            'id' => (string) Str::uuid(),
            'name' => $request->name,
            'unit' => $request->unit ?? null,
            'purchase_price' => $request->purchase_price ?? null,
            'selling_price' => $request->selling_price ?? null,
            'items' => $request->items ?? null,

        ]);

        if ($modelProduct)
            return redirect()->intended('/product')->with('successMessage', 'Successfully Add product.');

        return redirect()->back()->with('errorMessage', 'Failed Add product.');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $modelSupplier = Supplier::where('id', $request->supplier_id)->first();

        if (!$modelSupplier)
            return response()->json(['status' => 'Subject Not Found.'], 422);

        $modelSupplier->name = $request->name;
        $modelSupplier->address = $request->address;


        if ($modelSupplier->save()) {
            return redirect()->intended('/supplier')->with('successMessage', 'Successfully Updating Supplier.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Updating Supplier.');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $modelSupplier = Supplier::find($request->supplier_id);

        if (!$modelSupplier)
            return response()->json(['status' => 'Supplier Not Found.'], 422);

        if ($modelSupplier->delete()) {
            return redirect()->back()->with('successMessage', 'Successfully Delete Supplier.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Delete Supplier.');
    }
}
