$(document).ready(() => {

    $('body').on('click', '#btnTambah', () => {
        $(".popup-tambah").css("display", 'block');
        setTimeout(() => {
            $(".popup-tambah .form-container").css("top", '50%');
            $(".popup-tambah .form-container").css("opacity", '1');
        }, 100);
    });
});

function tutupPopupTambah() { 
    $(".popup-tambah .form-container").css("top", '40%');
    $(".popup-tambah .form-container").css("opacity", '0');
    setTimeout(() => {
        $(".popup-tambah").css("display", 'none');
    }, 300);
}

function tutupPopupEdit() { 
    $(".popup-edit .form-container").css("top", '40%');
    $(".popup-edit .form-container").css("opacity", '0');
    setTimeout(() => {
        $(".popup-edit").css("display", 'none');
    }, 300);
}

function openErrorDialog(msg) {
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: msg
    }).then((res) => {
    })
}
function openSuccessDialog(msg){
    Swal.fire(
        'Berhasil !',
        msg,
        'success'
    ).then((res) => {
        location.reload();
    })
}
function closeGambar(){
    $("#img").css("opacity", "0"); 
    $("#img").css("top", "35%"); 
    setTimeout(() => {
        $(".popup-gambar").css("display", "none");
    }, 400);
}