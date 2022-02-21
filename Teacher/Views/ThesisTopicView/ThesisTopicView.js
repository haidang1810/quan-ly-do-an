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
$(window).on('load',function(){
    $(".topic_button_search").click(function(){
        let maLop = $(".dsLop").val();
        if(maLop!=-1){
            search(maLop)
        }
        
    })
    
})
function nextPage(){
    $(".paginate_button").click(function(){
        submitDelete();
        nextPage();
    })
}
function search(maLop){
    $.post("../../Models/ThesisTopicModel.php",{
        'search': maLop
    },function(data){
        $(".table").html(data);
        $('#tableTopic').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ],
        });
        submitDelete();
        nextPage();
    })
}
$(".btn-add-topic").click(function(){
    let tenDT = $(".TenDeTai").val();
    let mssv = $(".selectAdd_Mssv").val();
    let maLop = $(".dsLop").val();
    let ghiChu = $(".GhiChu").val();
    if(tenDT==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập tên đề tài!'
        })
        return;
    }
    if(mssv==-1){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập chọn sinh viên!'
        })
        return;
    }
    if(maLop==-1){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa chọn lớp !'
        })
        return;
    }
    $.post("../../Models/ThesisTopicModel.php",{
        'add': "addtopic",
        'tenDT': tenDT,
        'mssv': mssv,
        'maLop': maLop,
        'ghiChu': ghiChu
    },function(data){
        if(data==1){
            Swal.fire(
                'Đã thêm!',
                'Bạn đã thêm đề tài thành công.',
                'success'
            )
            search(maLop);
            document.querySelector('.modal').style.visibility = 'hidden';
            document.querySelector('.modal').style.opacity = '0';
        }else if(data==2){
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Học kỳ đã kết thúc!'
            })
        }else if(data==3){
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Sinh viên đã có đề tài!'
            })
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: data
            })
        }
    })
})
$(".btn-edit-topic").click(function(){
    let maDT = $("#editMaDT").val();
    let tenDT = $("#editTen").val();
    let maLop = $(".dsLop").val();
    let ghiChu = $("#editGhiChu").val();
    if(tenDT==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập tên đề tài!'
        })
        return;
    }
    if(maLop==-1){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa chọn lớp học phần!'
        })
        return;
    }
    $.post("../../Models/ThesisTopicModel.php",{
        'edit': "editTopic",
        'maDT': maDT,
        'tenDT': tenDT,
        'ghiChu': ghiChu
    },function(data){
        if(data==1){
            Swal.fire(
                'Đã cập nhật!',
                'Bạn đã cập nhật đề tài thành công.',
                'success'
            )
            search(maLop);
            document.querySelector('.modal_edit').style.visibility = 'hidden';
            document.querySelector('.modal_edit').style.opacity = '0';
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: data
            })
        }
    })
})

function submitDelete(){
    var form = document.getElementsByClassName("btn_danger");
    for(i=0;i<form.length;i++){
        form[i].addEventListener('click', function(){
            Swal.fire({
                title: 'Bạn có chắc muốn xoá?',
                text: "Bạn sẽ không thể khôi phục dữ liệu đã xoá!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vâng, hãy xoá!',
                cancelButtonText: 'Huỷ.'
            }).then((result) => {
                if (result.isConfirmed) {
                    let maLop = $(".dsLop").val();
                    $.post("../../Models/ThesisTopicModel.php",{
                        'delete': 'deleTopic',
                        'maDT': this.id
                    },function(data){
                        if(data==1){
                            Swal.fire(
                                'Đã xoá!',
                                'Bạn đã xoá đề tài thành công.',
                                'success'
                            )
                            search(maLop);
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: data
                            })
                        }
                    })
                }
            })
        })
    }
}