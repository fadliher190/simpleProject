$(document).ready(() => {

    $('body').on('click', '#btnTambah', () => {
        $(".popup-tambah").css("display", 'block');
        setTimeout(() => {
            $(".form-container").css("top", '50%');
            $(".form-container").css("opacity", '1');
        }, 100);
    });

});

function tutupPopupTambah() { 
    $(".form-container").css("top", '40%');
    $(".form-container").css("opacity", '0');
    setTimeout(() => {
        $(".popup-tambah").css("display", 'none');
    }, 300);
 }
 
 function openErrorDialog() {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!'
    })
}

function openSuccessDialog(){
    Swal.fire(
        'Good job!',
        'You clicked the button!',
        'success'
    )
}