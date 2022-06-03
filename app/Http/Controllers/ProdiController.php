<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use Illuminate\Support\Facades\DB;

class ProdiController extends Controller
{

    function index(){
        /*$data = [
            'prodi' => ['Manajemen Informatika', 'Sistem Informasi', 'Informatika']
        ];
    
        //atau menggunakan compact
        $prodi = ['Manajemen Informatika', 'Sistem Informasi', 'Informatika'];
        $kampus = "Universitas Multi Data Palembang";
    
        return view("prodi.index", compact('prodi', 'kampus'));*/

        $kampus = "Universitas Multi Data Palembang";
        $prodi = Prodi::all();

        /*$prodi = DB::select("SELECT prodi.*, fakultas.nama as namaf FROM prodi INNER JOIN fakultas ON prodi.fakultas_id = fakultas.id");*/
        
        return view("prodi.index", compact('kampus', 'prodi'));
    }

    function detail($id = null){
        echo $id;
    }

    public function index(){
        $prodis = prodi :: all();
        return $prodi;
    }

    public function show($id)
    {
    $prodi = Prodi::findOrFail($id);
        return $prodi;
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:1000'
        ]);

        //mengambil file extension
        $ext = $request->foto->getClientOriginalExtension();
        //menentukan nama file
        $nama_file =  "foto-" . time() . "." . $ext;
        $path = $request->foto->storeAs("public", $nama_file);

        $prodi = new Prodi(); //buat object prodi
        $prodi->nama = $validateData['nama']; //simpan nilai inout ($validateData['nama]) ke dalam property nama prodi ($prodi->nama)
        //$prodi->institusi_id = 0;
        //$prodi->fakultas_id = 1;
        $prodi->foto= $nama_file;
        $prodi->save(); //simpan ke dalam tabel prodis

        return['status' =>true, 'message' => 'Data berhasil disimpan'];
    }
}
