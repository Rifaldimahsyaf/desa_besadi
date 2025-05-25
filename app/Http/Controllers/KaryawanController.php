<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    public function viewKaryawan()
    {
        $column_names = ['NIP', 'Nama Lengkap', 'Email', 'Alamat'];
        return view('karyawan.list')->with('column_names', $column_names);
    }

    public function viewUpdateKaryawan($id){
        $model = Karyawan::find($id)->format();

        return view('karyawan.update')->with('model', $model);
    }

    public function showKaryawanAjax()
    {
        $model = Karyawan::get()->map->format();

        return DataTables::of($model)->make(true);
    }

    public function create(Request $request)
    {
       
 
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:120',
            'email' => 'required|email|max:30',
            'alamat' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelKaryawan = Karyawan::create([
            'id' => (string) Str::uuid(),
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        if($modelKaryawan)
            return redirect()->intended('/karyawan')->with('successMessage', 'Successfully Add karyawan.');

        return redirect()->back()->with('errorMessage', 'Failed Add karyawan.');
    }

    public function update(Request $request)
    {
        
       


        $validator = Validator::make($request->all(),[
            'karyawan_id' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelKaryawan = Karyawan::where('id', $request->karyawan_id)->first();
        
        if(!$modelKaryawan)
            return response()->json(['status' => 'Subject Not Found.'], 422);

        $modelKaryawan->nip = $request->nip;
        $modelKaryawan->nama_lengkap = $request->nama_lengkap;
        $modelKaryawan->email = $request->email;
        $modelKaryawan->alamat = $request->alamat;
    

        if($modelKaryawan->save()){
            return redirect()->intended('/karyawan')->with('successMessage', 'Successfully Updating Karyawan.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Updating Karyawan.');
    }

    public function delete(Request $request)
    {
   
        $validator = Validator::make($request->all(),[
            'karyawan_id' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelKaryawan = Karyawan::find($request->karyawan_id);

        if(!$modelKaryawan)
            return response()->json(['status' => 'Karyawan Not Found.'], 422);
        
        if($modelKaryawan->delete()){
            return redirect()->back()->with('successMessage', 'Successfully Delete Karyawan.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Delete Karyawan.');
    }

}
