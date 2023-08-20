<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    public function viewPurchase()
    {
        $column_names = ['Suppleir', 'Product Name', 'Unit', 'Price', 'Items'];
        return view('purchase.list')->with('column_names', $column_names);
    }

    public function viewUpdateSubject($id){
        $model = Subject::find($id)->format();

        return view('purchase.update')->with('model', $model);
    }

    public function showSubjectAjax()
    {
        $model = Subject::get()->map->format();

        return DataTables::of($model)->make(true);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelSubject = Subject::create([
            'id' => (String) Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        if($modelSubject)
            return redirect()->intended('/subject')->with('successMessage', 'Successfully Add Subject.');

        return redirect()->back()->with('errorMessage', 'Failed Add Subject.');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subject_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelSubject = Subject::where('id', $request->subject_id)->first();
        
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
            'subject_id' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelSubject = Subject::find($request->subject_id);

        if(!$modelSubject)
            return response()->json(['status' => 'Subject Not Found.'], 422);
        
        if($modelSubject->delete()){
            return redirect()->back()->with('successMessage', 'Successfully Delete Subject.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Delete Subject.');
    }

}
