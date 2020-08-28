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
    
    @include('popup_gambar')
    @include('popup_tambah')
    @include('popup_edit')

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
                                        <a href="#" class="btn btn-warning" onclick="editBarang('{{ $barang->id }}')"><i class="fa fa-edit"></i></a>
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
        $('#form-edit').submit(function (event) { 
            event.preventDefault();

           Swal.fire({
            title: 'Yakin?',
            text: "Kamu tidak dapat mengembalikan data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Iya, Simpan Data Ini!',
            cancelButtonText: 'Tidak, Batal!',
            reverseButtons: true
            }).then((result) => {
                var id_barang =  $("#id_barang").val();
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('barang.home').'/update/' }}" + id_barang,
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
                                $("#message_edit").find("ul").html('');
                                $("#message_edit").css('display', 'block');
                                $.each( response.error, function( key, value ) {
                                    $("#message_edit").find("ul").append('<li><small>'+value+'</small></li>');
                                });
                            }
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                    'Batal',
                    'Data Tidak Jadi Di Edit :)',
                    'error'
                    )
                }
            })
           
        });
        
    });

    function deleteBarang(id) {
        Swal.fire({
            title: 'Yakin?',
            text: "Kamu tidak dapat mengembalikan data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Iya, Hapus Data Ini!',
            cancelButtonText: 'Tidak, Batal!',
            reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('barang.home').'/destroy/' }}"+id,
                        data: "",
                        dataType: "",
                        success: function (response) {
                            console.log(response);
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
                    'Batal',
                    'Data Tidak Jadi Di Hapus :)',
                    'error'
                )
            }
        })
        
    }

    function editBarang(id) {

        $.ajax({
            type: "GET",
            url: "{{ route('barang.home').'/edit/' }}" + id,
            data: "",
            dataType: "JSON",
            success: function (response) {
                console.log(response);

                $(".popup-edit .form-container #id_barang").val(response.barang.id);
                $(".popup-edit .form-container #nama_barang").val(response.barang.nama_barang);
                $(".popup-edit .form-container #gambar_barang_preview").attr('src', response.barang.gambar_barang);
                $(".popup-edit .form-container #stok_barang").val(response.barang.stok_barang);

                $(".popup-edit").css("display", 'block');
                setTimeout(() => {
                    $(".popup-edit .form-container").css("top", '50%');
                    $(".popup-edit .form-container").css("opacity", '1');
                }, 100);

            }
        });


    }
    
    function openGambar(crypted){
        $("#img").attr("src", "{{ route('barang.home') }}/" + crypted);
        $(".popup-gambar").css("display", "block");
        setTimeout(() => {
           $("#img").css("opacity", "1"); 
           $("#img").css("top", "50%"); 
        }, 400);
    }
</script>
</html>