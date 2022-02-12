function showAddModal() {
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});
function showEditModal(value) {
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    console.log(value);
    var data =value.split(".");
    console.log(data[0]);
    console.log(data[1]);
    console.log(data[2]);
    console.log(data[3]);
    document.getElementById('editId_hknh').value = data[0];
    document.getElementById('editNgayBD').value = data[2];
    document.getElementById('editNgayKT').value = data[3];
    var hk = data[1].split(" , ");
    $('#editHK').val(hk[0]).change();
    $('#editHK').trigger("updated");
    var nam = hk[1].split(" - ");
    document.getElementById('editStartYear').value = nam[0];
    document.getElementById('editEndYear').value = nam[1];
}
document.querySelector('.close_edit').addEventListener('click',
function() {
    document.querySelector('.modal_edit').style.visibility = 'hidden';
    document.querySelector('.modal_edit').style.opacity = '0';
});

function getYear(){
    var input = Number(document.getElementById('StartYear').value);
    document.getElementById('EndYear').value = input+1;
}
function getYearEdit(){
    var input = Number(document.getElementById('editStartYear').value);
    document.getElementById('editEndYear').value = input+1;
}
var form = document.getElementsByClassName("changStatus");
for(i=0;i<form.length;i++){
    form[i].addEventListener('submit', function(e){
        e.preventDefault();    
        Swal.fire({
            title: 'Xác nhận học kỳ hiện tại?',
            text: "Bạn có chắc muốn đổi học kỳ hiện tại!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đổi!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();            
            }
        })
    })
}