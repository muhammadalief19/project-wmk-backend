<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
    // set validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:dns|unique:users',
            'role' => 'required',
        ],
        [
            'name.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'email.email' => 'format email tidak sesuai',
            'email.unique' => 'email tidak tersedia',
            'role.required' => 'role wajib diisi',
        ]
        );

        // if falidation fails
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $code = uniqid();

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($code)
        ]);

        $details = [
            'title' => 'Mail from DavezDelivery.com',
            'body' => 'Gunakan password dibawah ini untuk login ke aplikasi DavezDelivery',
            'name' => $user->name,
            'code' => $code
        ];

        //return response JSON user is created
        if($user) {
            Mail::to($user->email)->send(new EmailVerification($details));
            return response()->json([
                'success' => true,
                'user'    => $user,
                'message' => 'User berhasil ditambahkan'  
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
            'message' => 'User gagal ditambahkan'
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


    // method register
    public function register(Request $request) {
        // set validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:dns|unique:users',
            'role' => 'required',
            'password' => 'required|min:8|confirmed'
        ],
        [
            'name.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'email.email' => 'format email tidak sesuai',
            'email.unique' => 'email tidak tersedia',
            'role.required' => 'role wajib diisi',
            'password.required' => 'password wajib diisi',
            'password.min' => 'password minimal 8 karakter',
            'password.confirmed' => 'password belum dikonfirmasi'
        ]
        );

        // if falidation fails
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'verify' => 'pending',
            'password' => Hash::make($request->password)
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);

    }

    public function login(Request $request) {
        // set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        //if auth failed
        if(!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => auth()->user(),    
            'token'   => $token   
        ], 200);
    }

    public function logout() {
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            //return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',  
            ]);
        }
    }

    // verify email
    public function verify(Request $request, $uuid) {
        date_default_timezone_set('Asia/Jakarta');
        // // set validation
        // $validator = Validator::make($request->all(), [
        //     'email_verified_at'     => 'required',
        // ],
        // [
        //     'email_verified_at.required' => "kolom wajib diisi"
        // ]);

        // //if validation fails
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        $user = DB::table('users')->where('uuid', $uuid);

        $verifyUser = DB::table('users')->where('uuid', $uuid)->update([
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        if($verifyUser) {
            return response()->json([
                "success" => true,
                "message" => "Akun telah terverifikasi"
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Akun gagal terverifikasi",
            "user" => $user,
            "uuid" => $uuid
        ], 400);
    }
}
