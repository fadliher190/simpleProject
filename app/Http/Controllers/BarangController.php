<?php

namespace App\Http\Controllers;

use App\Barang;
use Crypt;
use Illuminate\Http\Request;
use Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = Barang::all();
        return view('barang', $data);
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
        $message = [
            "required" => ":attribute harus di isi !"
        ];

        $validation = Validator::make($request->all(), [
            'nama_barang' => 'required|max:191',
            'gambar_barang' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'stok_barang' => 'required|max:20'
        ],$message);
       
        if ($validation->passes()) {
            
            $gambar = $request->file('gambar_barang');
            
            $id = Barang::max('id') + 1;
            
            $newName = $id.'.'.$gambar->getClientOriginalExtension();

            Barang::create([
                'nama_barang' => $request->post('nama_barang'),
                'gambar_barang' => Crypt::encrypt('uploads/gambar/'.$newName),
                'stok_barang' => $request->post('stok_barang')
            ]);
            
            $gambar->move('uploads/gambar', $newName);
            
            return response()->json([
            
                'status' => '1'
            
            ], 200);
        
        }else{
        
            return response()->json([
        
                'status' => '0',
                'error' => $validation->errors()->all()
        
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($encryptImage)
    {
        $file = file_get_contents(Crypt::decrypt($encryptImage));
        return response($file)->header('Content-type', 'image/png');
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
