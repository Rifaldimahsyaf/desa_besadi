<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Validator;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Imports\InventarisImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;


class InventarisController extends Controller
{
    public function viewInventaris()
    {
        $column_names = ['Jenis Barang', 'Asal Barang','Keadaan Barang', 'Penghapusan Barang',  'Keterangan' ];
        

        return view('inventaris.list')->with(['column_names' => $column_names]);
    }

    public function viewUpdateInventaris($id){
        
        $model = Inventaris::find($id)->format();

        return view('inventaris.update')->with('model', $model);
    }

    public function showInventarisAjax()
    {
        $model = Inventaris::get()->map->format();


        return DataTables::of($model)->make(true);
    }

    public function create(Request $request)
    {
            
        $validator = Validator::make($request->all(),[
            'jenis_barang' => 'required|string|max:255',
            'asal_barang' => 'required|string|max:255',
            'keadaan_barang' => 'required|string|max:255',
            'penghapusan_barang' => 'required|string|max:255',
            'keterangan' => 'required|string',
           
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }


        $modelInventaris = Inventaris::create([
            'id' => (String) Str::uuid(),
            'jenis_barang' => $request->jenis_barang,
            'asal_barang' => $request->asal_barang,
            'keadaan_barang' => $request->keadaan_barang,
            'penghapusan_barang' => $request->penghapusan_barang,
            'keterangan' => $request->keterangan,
           
        ]);

        if($modelInventaris)
            return redirect()->intended('/inventaris')->with('successMessage', 'Successfully Add Inventaris.');

        return redirect()->back()->with('errorMessage', 'Failed Add Inventaris.');
    }

    public function update(Request $request)
    {
        // dd($request->inventaris_id);
        $validator = Validator::make($request->all(),[
            'jenis_barang' => 'required|string|max:255',
            'asal_barang' => 'required|string|max:255',
            'keadaan_barang' => 'required|string|max:255',
            'penghapusan_barang' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelInventaris = Inventaris::where('id', $request->inventaris_id)->first();
       
        
        if(!$modelInventaris)
            return response()->json(['status' => 'inventaris Not Found.'], 422);

            $modelInventaris->jenis_barang = $request->jenis_barang;
            $modelInventaris->asal_barang = $request->asal_barang;
            $modelInventaris->keadaan_barang = $request->keadaan_barang;
            $modelInventaris->penghapusan_barang = $request->penghapusan_barang;
            $modelInventaris->keterangan = $request->keterangan;
    

        if($modelInventaris->save()){
            return redirect()->intended('/inventaris')->with('successMessage', 'Successfully Updating inventaris.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Updating inventaris.');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'inventaris_id' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelInventaris = Inventaris::find($request->inventaris_id);

      
        
        if($modelInventaris->delete()){
            return redirect()->back()->with('successMessage', 'Successfully Delete Inventaris.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Delete Inventaris.');
    }
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    try {
        Excel::import(new InventarisImport, $request->file('file'));
        return redirect()->back()->with('successMessage', 'Data Inventaris berhasil diimport!');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        // Anda bisa tangani error per baris di sini
        return redirect()->back()->with('errorMessage', 'Import gagal: '.$failures[0]->errors()[0]);
    }
}
}
