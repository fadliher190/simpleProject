<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barang Gudang</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-4.0.0/css/bootstrap.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('assets/css/popup.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/js/sweetalert/dist/sweetalert2.min.css') }}">
    
    <script src="{{ asset('assets/js/sweetalert/dist/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-3.4.0.min.js') }}"></script>
    <style>
        .row{
            max-width: 100%;
            margin-left: 0
        }
        *{
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="row mt-4">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tabel Barang</div>
                <div class="card-body">
                    <a href="#" class="float-right btn btn-primary font-weight-light mb-3" id="btnTambah"><i class="fa fa-plus-circle"></i> Tambah Barang</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="50%">Nama Barang</th>
                                <th width="10%" class="text-center">Stok</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1
                            @endphp
                            @foreach ($data as $barang)
                                <tr>
                                    <td class="align-middle text-center">{{ $i }}</td>   
                                    <td class="align-middle">{{ $barang->nama_barang }}</td>
                                    <td class="align-middle text-center">{{ $barang->stok_barang }}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <a href="#" onclick="deleteBarang('{{ $barang->id }}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        <a href="#" onclick="openGambar('{{ $barang->gambar_barang }}')" class="btn btn-primary font-weight-light"><i class="fa fa-eye"></i> Lihat Gambar</a>
                                    </td>
                                </tr>
                                @php
                                    $i++
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- form popup add barang --}}
    <div class="popup-tambah">
        <div class="outer" onclick="tutupPopupTambah()"></div>
        <div class="form-container">
            <div class="card">
                <div class="card-header text-primary font-weight-light">
                    <i class="fa fa-plus-circle"></i> Tambah Data Barang
                </div>
                <div class="card-body">
                    <div class="alert alert-danger w-100 " id="message" style="display: none">
                        <ul></ul>
                    </div>
                    <form class="form" id="form-tambah" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_barang">
                                <small>Nama Barang <span class="text-danger">*</span></small>
                            </label>
                            <input type="text" class="form-control font-weight-light" name="nama_barang" id="nama_barang">
                        </div>
                        <div class="form-group">
                            <label for="gambar_barang">
                                <small>File Gambar <span class="text-danger">*</span></small>
                            </label>
                            <input type="file" class="form-control font-weight-light" name="gambar_barang" id="gambar_barang">
                        </div>
                        <div class="form-group">
                            <label for="stok_barang">
                                <small>Stok <span class="text-danger">*</span></small>
                            </label>
                            <input type="number" class="form-control font-weight-light" name="stok_barang" id="stok_barang">
                        </div>
                        <button type="submit" class=" btn btn-primary float-right ml-2 font-weight-light" id="btnSubmitTambah"><i class="fa fa-save"></i> Simpan</button>
                        <a href="#" class="btn btn-danger float-right font-weight-light" id="btnBatal" onclick="tutupPopupTambah()"><i class="fa fa-times"></i> Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end form popup add barang --}}
    {{-- form popup Gambar --}}
    <div class="popup-gambar">
        <div class="outer" onclick="closeGambar()"></div>
        <img src="/" alt="" id="img">
    </div>
    {{-- end form popup Gambar --}}

</body>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
    $(document).ready(()=>{
        $('#form-tambah').submit(function (event) { 
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('barang.store') }}",
                data: new FormData(this),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status == '1') {
                        openSuccessDialog(response.msg);
                    }else{
                        openErrorDialog(response.msg);
                        $("#message").find("ul").html('');
                        $("#message").css('display', 'block');
                        $.each( response.error, function( key, value ) {
                            $("#message").find("ul").append('<li><small>'+value+'</small></li>');
                        });
                    }
                }
            });
        });
    });

    function deleteBarang(id) {
        Swal.fire({
        title: 'Yakin?',
            text: "Kamu tidak dapat mengembalikan data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('barang.home').'/destroy/' }}"+id,
                        data: "",
                        dataType: "",
                        success: function (response) {
                            if (response.status == '1') {
                                openSuccessDialog(response.msg)
                            }else{
                                openErrorDialog(response.msg);
                            }
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                    'Cancelled',
                    'Data Tidak Jadi Di Hapus :)',
                    'error'
                )
            }
        })
        
    }

    function openErrorDialog(msg) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: msg
        }).then((res) => {
        })
    }
    function openSuccessDialog(msg){
        Swal.fire(
            'Good job!',
            msg,
            'success'
        ).then((res) => {
            location.reload();
        })
    }
    
    function openGambar(crypted){
        $("#img").attr("src", "{{ route('barang.home') }}/" + crypted);
        $(".popup-gambar").css("display", "block");
        setTimeout(() => {
           $("#img").css("opacity", "1"); 
           $("#img").css("top", "50%"); 
        }, 400);
    }
    function closeGambar(){
        $("#img").css("opacity", "0"); 
        $("#img").css("top", "35%"); 
        setTimeout(() => {
            $(".popup-gambar").css("display", "none");
        }, 400);
    }
</script>
</html>