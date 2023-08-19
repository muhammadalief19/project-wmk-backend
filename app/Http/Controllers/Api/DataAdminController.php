<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            "user_id" => "required",
            "nik" => "required",
            "nama_admin" => "required",
            "no_telp" => "required",
            "foto_pribadi" => "required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048",
            "foto_ktp" => "required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096"
        ], [
            "user_id.required" => "User ID wajib diisi",
            "nik.required" => "NIK wajib diisi",
            "nama_admin.required" => "Nama wajib diisi",
            "no_telp.required" => "Nomer telp wajib diisi",
            "foto_pribadi.required" => "Foto wajib diisi",
            "foto_pribadi.image" => "File yang anda masukkan bukan gambar",
            "foto_pribadi.mimes" => "File harus berformat jpeg,png,jpg,gif,svg,webp",
            "foto_pribadi.max" => "Ukuran file max 2MB",
            "foto_ktp.required" => "Foto wajib diisi",
            "foto_ktp.image" => "File yang anda masukkan bukan gambar",
            "foto_ktp.mimes" => "File harus berformat jpeg,png,jpg,gif,svg,webp",
            "foto_ktp.max" => "Ukuran file max 4MB",
        ]);

        // jika validasi gagal
        if($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }

        // upload image
        $foto_pribadi = $request->file('foto_pribadi');
        $foto_pribadi->storeAs('public/foto-pribadi-admin', $foto_pribadi->hashName());
        $foto_ktp = $request->file('foto_ktp');
        $foto_ktp->storeAs('public/foto-ktp-admin', $foto_ktp->hashName());

        // create data admin
        $data = DataAdmin::create([
            "user_id" => $request->user_id,
            "nik" => $request->nik,
            "nama_admin" => $request->nama_admin,
            "no_telp" => $request->no_telp,
            "foto_pribadi" => "foto-pribadi-admin/{$foto_pribadi->hashName( )}",
            "foto_ktp" => "foto-ktp-admin/{$foto_ktp->hashName( )}",
        ]);

        if($data) {
            return response()->json([
                "success" => true,
                "message" => "data admin berhasil ditambahkan",
            ], 201);
        }

            return response()->json([
                "success" => false,
                "message" => "data gagal berhasil ditambahkan",
            ], 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
