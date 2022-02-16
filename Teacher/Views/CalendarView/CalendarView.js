function showDetailStudent(value) {
    document.querySelector('.modal_view').style.visibility = 'visible';
    document.querySelector('.modal_view').style.opacity = '1';
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
document.querySelector('.close2').addEventListener('click',
function() {
    document.querySelector('.modal_view').style.visibility = 'hidden';
    document.querySelector('.modal_view').style.opacity = '0';
});

function showAddCalen() {
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});

function ConfirmDelete(){
    var x = confirm("Bạn có chắc muốn Xoá?");
    if (x)
        return true;
    else
        return false;
}
function showEditCalen(value) {
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    var data =value.split(",");
    
    document.getElementById('editHidden').value = data[0];
    document.getElementById('editDate').value = data[1];
    console.log(data[1]);
    document.getElementById('editTimeStart').value = data[2];
    document.getElementById('editAmount').value = data[3];
}
document.querySelector('.close_edit').addEventListener('click',
function() {
    document.querySelector('.modal_edit').style.visibility = 'hidden';
    document.querySelector('.modal_edit').style.opacity = '0';
});

$(document).ready(function(){
    $(".dsHKNH").change(function(){
        var id = $(".dsHKNH").val();
        $.post("../../Models/CalendarModel.php",{"id": id},function(data){
            if(data=="")
                $(".dsLop").html("<option value='-1'>Chọn lớp HP</option>");
            else
                $(".dsLop").html(data);
            $('.dsLop').trigger("chosen:updated");
        })
    })
})
$(window).on('load',function(){
    $(".button_search").click(function(){
        let maLop = $(".dsLop").val();
        if(maLop!=-1){
            search(maLop)
        }
        
    })
    
})
function search(maLop){
    $.post("../../Models/CalendarModel.php",{
        'search': maLop
    },function(data){
        $(".table").html(data);
        $('#tableCalen').DataTable({
            "lengthMenu": [ 5, 10],
        });
        submitDelete();
        $(".paginate_button").click(function(){
            submitDelete();
        })
    })
}
$(".btn-add-calen").click(function(){
    let maLop = $(".dsLop").val();
    let ngayBC = $(".NgayBC").val();
    let thoiGianBD = $(".ThoiGianBD").val();
    let soNhom = $(".SoNhomBC").val();
    if(maLop==-1){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa chọn lớp học phần!'
        })
        return;
    }
    if(thoiGianBD==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa thời gian bắt đầu!'
        })
        return;
    }
    if(ngayBC==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa chọn ngày báo cáo!'
        })
        return;
    }
    if(soNhom==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập số nhóm báo cáo!'
        })
        return;
    }
    $.post("../../Models/CalendarModel.php",{
        'add': "addCalen",
        'thoiGianBD': thoiGianBD,
        'maLop': maLop,
        'soNhom': soNhom,
        'ngayBC': ngayBC
    },function(data){
        if(data==1){
            Swal.fire(
                'Đã thêm!',
                'Bạn đã thêm lịch thành công.',
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
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: data
            })
        }
    })
})
$(".btn-edit-calen").click(function(){
    let id = $("#editHidden").val();
    let maLop = $(".dsLop").val();
    let ngayBC = $("#editDate").val();
    let thoiGianBD = $("#editTimeStart").val();
    let soNhom = $("#editAmount").val();
    if(maLop==-1){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa chọn lớp học phần!'
        })
        return;
    }
    if(thoiGianBD==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa thời gian bắt đầu!'
        })
        return;
    }
    if(ngayBC==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa chọn ngày báo cáo!'
        })
        return;
    }
    if(soNhom==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập số nhóm báo cáo!'
        })
        return;
    }
    $.post("../../Models/CalendarModel.php",{
        'edit': "addCalen",
        'id': id,
        'thoiGianBD': thoiGianBD,
        'maLop': maLop,
        'soNhom': soNhom,
        'ngayBC': ngayBC
    },function(data){
        if(data==1){
            Swal.fire(
                'Đã cập nhật!',
                'Bạn đã cập nhật lịch thành công.',
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
                    $.post("../../Models/CalendarModel.php",{
                        'delete': 'deleCalen',
                        'maLich': this.id
                    },function(data){
                        if(data==1){
                            Swal.fire(
                                'Đã xoá!',
                                'Bạn đã xoá tiến độ thành công.',
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
