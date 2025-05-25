<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Validator;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WargaController extends Controller
{
    public function viewWarga()
    {
        $column_names = ['No KK', 'Name','nik', 'Gender', 'Tanggal Lahir' ,'Golongan Darah','Religion','Pendidikan','Pekerjaan','Alamat','Status Perkawinan','Tempat Dikeluarkan','Tanggal Dikeluarkan','Status Keluarga','Kewarganegaraan','Nama Ayah','Nama Ibu','Tanggal Mulai','Keterangan'];
        

        return view('warga.list')->with(['column_names' => $column_names]);
    }

    public function viewUpdateWarga($id){
        
        $model = Warga::find($id)->format();

        return view('warga.update')->with('model', $model);
    }

    public function showWargaAjax()
    {
        $model = Warga::get()->map->format();


        return DataTables::of($model)->make(true);
    }

    public function create(Request $request)
    {
            
        $validator = Validator::make($request->all(),[
            'no_kk' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'golongan_darah' => 'required|string',
            'religion' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat' => 'required|string',
            'status_perkawinan' => 'required|string',
            'tanggal_dikeluarkan' => 'required|string',
            'status_keluarga' => 'required|string',
            'kewarganegaraan' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'keterangan' => 'required|string',
           
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }


        $modelWarga = Warga::create([
            'id' => (String) Str::uuid(),
            'no_kk' => $request->no_kk,
            'name' => $request->name,
            'nik' => $request->nik,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'golongan_darah' => $request->golongan_darah,
            'religion' => $request->religion,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'status_perkawinan' => $request->status_perkawinan,
            'tempat_dikeluarkan' => $request->tempat_dikeluarkan,
            'tanggal_dikeluarkan' => $request->tanggal_dikeluarkan,
            'status_keluarga' => $request->status_keluarga,
            'kewarganegaraan' => $request->kewarganegaraan,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'tanggal_mulai' => $request->tanggal_mulai,
            'keterangan' => $request->keterangan,
           
        ]);

        if($modelWarga)
            return redirect()->intended('/warga')->with('successMessage', 'Successfully Add Warga.');

        return redirect()->back()->with('errorMessage', 'Failed Add Warga.');
    }

    public function update(Request $request)
    {
        // dd($request->warga_id);
        $validator = Validator::make($request->all(),[
            'no_kk' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'golongan_darah' => 'required|string',
            'religion' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat' => 'required|string',
            'status_perkawinan' => 'required|string',
            'tempat_dikeluarkan' => 'required|string',
            'tanggal_dikeluarkan' => 'required|date',
            'status_keluarga' => 'required|string',
            'kewarganegaraan' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelWarga = Warga::where('id', $request->warga_id)->first();
       
        
        if(!$modelWarga)
            return response()->json(['status' => 'warga Not Found.'], 422);

            $modelWarga->no_kk = $request->no_kk;
            $modelWarga->name = $request->name;
            $modelWarga->nik = $request->nik;
            $modelWarga->gender = $request->gender;
            $modelWarga->birth_date = $request->birth_date;
            $modelWarga->golongan_darah = $request->golongan_darah;
            $modelWarga->religion = $request->religion;
            $modelWarga->pendidikan = $request->pendidikan;
            $modelWarga->pekerjaan = $request->pekerjaan;
            $modelWarga->alamat = $request->alamat;
            $modelWarga->status_perkawinan = $request->status_perkawinan;
            $modelWarga->tanggal_dikeluarkan = $request->tanggal_dikeluarkan;
            $modelWarga->status_keluarga = $request->status_keluarga;
            $modelWarga->kewarganegaraan = $request->kewarganegaraan;
            $modelWarga->nama_ayah = $request->nama_ayah;
            $modelWarga->nama_ibu = $request->nama_ibu;
            $modelWarga->tanggal_mulai = $request->tanggal_mulai;
            $modelWarga->keterangan = $request->keterangan;
    

        if($modelWarga->save()){
            return redirect()->intended('/warga')->with('successMessage', 'Successfully Updating warga.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Updating warga.');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'warga_id' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $modelWarga = Warga::find($request->warga_id);

      
        
        if($modelWarga->delete()){
            return redirect()->back()->with('successMessage', 'Successfully Delete Warga.');
        }
        return redirect()->back()->with('errorMessage', 'Failed Delete Warga.');
    }

}
