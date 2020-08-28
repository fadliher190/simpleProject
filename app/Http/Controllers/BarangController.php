<?php

namespace App\Http\Controllers;

use App\Barang;
use Crypt;
use File;
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
            "required" => ":attribute harus di isi !",
            "image" => ":attribute harus berupa gambar",
            "mimes" => ":attribute harus berformat jpeg, jpg, png"
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
            
                'status' => '1',
                'msg' => "Tambah Data Berhasil"
            
            ], 200);
        
        }else{
        
            return response()->json([
        
                'status' => '0',
                'error' => $validation->errors()->all(),
                'msg' => "Tambah Data Gagal"
        
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
        $barang = Barang::where('id', $id)->first();
        
        return response()->json([
            'status' => '1',
            'barang' => $barang,
        ], 200);
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
        $gambar = $request->file('gambar_barang');

        $message = [
            "required" => ":attribute harus di isi !",
            "image" => ":attribute harus berupa gambar",
            "mimes" => ":attribute harus berformat jpeg, jpg, png"
        ];

        $validation = Validator::make($request->all(), [
            'nama_barang' => 'required|max:191',
            'gambar_barang' => 'image|mimes:jpeg,jpg,png|max:2048',
            'stok_barang' => 'required|max:20'
        ],$message);

        if ($validation->passes()) {
            if ( isset($gambar)) {
                $path_gambar = Barang::where('id', $id)->first();
                $nama_gambar = $path_gambar->id.'.'.$gambar->getClientOriginalExtension();
                File::delete(public_path(Crypt::decrypt($path_gambar->gambar_barang)));
                $gambar->move('uploads/gambar', $nama_gambar);
                $barang = Barang::where('id', $id)
                        ->update([
                                'nama_barang' => $request->post('nama_barang'),
                                'gambar_barang' => Crypt::encrypt('uploads/gambar/' . $nama_gambar),
                                'stok_barang' => $request->post('stok_barang')
                            ]);
            }else {
                
                $barang = Barang::where('id', $id)
                ->update([
                    'nama_barang' => $request->post('nama_barang'),
                    'stok_barang' => $request->post('stok_barang')
                    ]);
            }

            return response()->json([
                'status' => '1',
                'msg' => 'Edit Data Berhasil'
            ], 200);
        }else{
            
            return response()->json([
                'status' => '0',
                'error' => $validation->errors()->all(),
                'msg' => 'Edit Data Gagal'
            ], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $path_gambar = Barang::where('id', $id)->first();
        File::delete(public_path(Crypt::decrypt($path_gambar->gambar_barang)));
        
        $delete = Barang::find($id)->delete();
        
        if($delete){
            return response()->json([
                "status" => "1",
                "msg" => "Menghapus Data Berhasil",
            ], 200);
        }else{
            return response()->json([
                "status" => "0",
                "msg" => "Menghapus Data Gagal",
            ], 200);
        }
    }
}
