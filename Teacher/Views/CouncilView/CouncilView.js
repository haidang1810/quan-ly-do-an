function showAddCouncil() {
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});
function showEditCouncil(value) {
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    var data =value.split(",");

    document.getElementById('editMaHD').value = data[0];

    $('#editCTHD').val(data[1]).change();
    $('#editCTHD').trigger("chosen:updated");

    $('#editCBHD').val(data[2]).change();
    $('#editCBHD').trigger("chosen:updated");

    $('#editGVPB').val(data[3]).change();
    $('#editGVPB').trigger("chosen:updated");
}
document.querySelector('.close_edit').addEventListener('click',
function() {
    document.querySelector('.modal_edit').style.visibility = 'hidden';
    document.querySelector('.modal_edit').style.opacity = '0';
});
function nextPage(){
    $(".paginate_button").click(function(){
        submitDelete();
        nextPage();
    })
}
$(window).on('load',function(){
    submitDelete();
    nextPage();
})
function submitDelete(){
    var form = document.getElementsByClassName("form-delete");
    for(i=0;i<form.length;i++){
        form[i].addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Bạn có chắc muốn xoá?',
                text: "Bạn không thể khôi phục dữ liệu sau khi xoá!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý!',
                cancelButtonText: 'Huỷ.'
            }).then((result) => {
                if (result.isConfirmed)
                    this.submit();
            })
        })
    }
}