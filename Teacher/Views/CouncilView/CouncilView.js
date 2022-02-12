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
function ConfirmDelete(){
    var x = confirm("Bạn có chắc muốn xoá?");
    if (x)
        return true;
    else
        return false;
}