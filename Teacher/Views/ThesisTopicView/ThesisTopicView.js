function ConfirmSuggest(){
    var x = confirm("Bạn có chắc muốn duyệt đề tài này?");
    if (x)
        return true;
    else
        return false;
}
function showAddTopic() {
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});
function showDetailStudent(value) {
    document.querySelector('.modal_detail').style.visibility = 'visible';
    document.querySelector('.modal_detail').style.opacity = '1';
    var data =value.split(",");
    
    if(data[0]!=null)
        document.getElementById('Mssv').innerHTML = "<b>Mssv: </b>" + data[0];
    if(data[1]!=null)    
        document.getElementById('HoTen').innerHTML = "<b>Họ và tên: </b>" + data[1];
    if(data[2]!=null)
        document.getElementById('NgaySinh').innerHTML = "<b>Ngày sinh: </b>"+ data[2];
    if(data[3]!=null)    
        document.getElementById('SDT').innerHTML = "<b>SDT: </b>" + data[3];
    if(data[4]!=null)
        document.getElementById('DiaChi').innerHTML = "<b>Địa chỉ: </b>" + data[4];
    if(data[5]!=null)    
        document.getElementById('Khoa').innerHTML = "<b>Khoá: </b>" + data[5];
    if(data[6]!=null)
        document.getElementById('Lop').innerHTML = "<b>Lớp: </b>" + data[6];     
}

document.querySelector('.close_detail').addEventListener('click',
function() {
    document.querySelector('.modal_detail').style.visibility = 'hidden';
    document.querySelector('.modal_detail').style.opacity = '0';
});

function showEditTopic(value) {
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    var data =value.split(",");
    
    if(data[0]!=null)
        document.getElementById('editMaDT').value = data[0];
    if(data[1]!=null)    
        document.getElementById('editTen').value = data[1];
    if(data[2]!=null)
        document.getElementById('editGhiChu').value = data[2];
    $('#editMssv').val(data[3]).change();
    $('#editMssv').trigger("chosen:updated");
}
document.querySelector('.close_edit').addEventListener('click',
function() {
    document.querySelector('.modal_edit').style.visibility = 'hidden';
    document.querySelector('.modal_edit').style.opacity = '0';
});
function openTab(e,tabId){
    var i;
    
    var tabContent = document.getElementsByClassName("tab_content");

    for(i=0;i<tabContent.length;i++){
        tabContent[i].style.display = "none";
    }
    tabContent[tabId].style.display = "block";

    var tabLink = document.getElementsByClassName("tab_link");
    for(i=0;i<tabLink.length;i++){
        tabLink[i].className = tabLink[i].className.replace(" active", "");
    }
    event.currentTarget.className += " active";
    var tab = document.getElementById("tab");
    tab.classList.add("tab_active");
}
$(document).ready(function(){
    $(".dsHKNH").change(function(){
        var id = $(".dsHKNH").val();
        $.post("../../Models/ThesisTopicModel.php",{"id": id},function(data){
            if(data=="")
                $(".dsLop").html("<option value='-1'>Chọn lớp luận văn</option>");
            else
                $(".dsLop").html(data);
            $('.dsLop').trigger("chosen:updated");
        })
    })
})

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