document.querySelector('.close_GV').addEventListener('click',
function() {
    document.querySelector('.modal_GV').style.visibility = 'hidden';
    document.querySelector('.modal_GV').style.opacity = '0';
});
function showDetailTea(value) {
    document.querySelector('.modal_GV').style.visibility = 'visible';
    document.querySelector('.modal_GV').style.opacity = '1';
    var data =value.split(",");
    
    if(data[0]!=null)
        document.getElementById('MaGV').innerHTML = "<b>Mssv: </b>" + data[0];
    if(data[1]!=null)    
        document.getElementById('HoTen').innerHTML = "<b>Họ và tên: </b>" + data[1];
    if(data[2]!=null)
        document.getElementById('Gmail').innerHTML = "<b>Địa chỉ: </b>" + data[2];
    
}
function showAddClass() {
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});
function showEditClass(value) {
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    var data =value.split(",");
    
    document.getElementById('editMaLop').value = data[0];
    document.getElementById('editTen').value = data[1];
    $('#editGV').val(data[2]).change();
    $('#editGV').trigger("chosen:updated");
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
$(window).on("load",function(){
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
                text: "Bạn sẽ không thể khôi phục dữ liệu đã xoá!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vâng, hãy xoá!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();            
                }
            })
        })
    }
}