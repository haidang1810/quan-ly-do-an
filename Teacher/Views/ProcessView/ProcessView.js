function showAddProcess() {
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});

function showEditProcess(value){
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    var data =value.split(",");

    document.getElementById('editID').value = data[0];
    document.getElementById('editTitle').value = data[1];
    document.getElementById('editNote').value = data[2];
    var timeBD = data[3].replace(" ","T");
    document.getElementById('editBD').value = timeBD;
    var timeKT = data[4].replace(" ","T");
    document.getElementById('editKT').value = timeKT;
}
document.querySelector('.close_edit').addEventListener('click',
function() {
    document.querySelector('.modal_edit').style.visibility = 'hidden';
    document.querySelector('.modal_edit').style.opacity = '0';
});



$(document).ready(function(){
    $(".dsHKNH").change(function(){
        var id = $(".dsHKNH").val();
        $.post("../../Models/ProcessModel.php",{"id": id},function(data){
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
function nextPage(){
    $(".paginate_button").click(function(){
        submitDelete();
        submitDetail();
        nextPage();
    })
}
function search(maLop){
    $.post("../../Models/ProcessModel.php",{
        'search': maLop
    },function(data){
        if(data!=""){
            $(".table").html(data);
            $('#tablePro').DataTable({
                "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
            });
            submitDelete();
            submitDetail();
            nextPage();
        }else{
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'Lớp chưa có tiến độ',
                showConfirmButton: false,
                toast: true,
                width: '290px',
                timer: 1500,
                background: 'rgba(221, 75, 57, 0.966)',
                color: '#fff'
            })
            $(".table").html("");
        }
        
    })
}
$(".btn-add-process").click(function(){
    let maLop = $(".dsLop").val();
    let tieuDe = $(".TieuDe").val();
    let ghiChu = $(".GhiChu").val();
    let thoiGianBD = $(".ThoiGianBD").val();
    let thoiGianKT = $(".ThoiGianKT").val();
    let cbSP = document.getElementById("cbSP");
    let sanPham = 0;
    if(cbSP.checked)
        sanPham = 1;
    if(tieuDe==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập tiêu đề!'
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
    if(thoiGianBD==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa thời gian bắt đầu!'
        })
        return;
    }
    if(thoiGianKT==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa thời gian kết thúc!'
        })
        return;
    }
    $.post("../../Models/ProcessModel.php",{
        'add': "addProcess",
        'tieuDe': tieuDe,
        'thoiGianBD': thoiGianBD,
        'thoiGianKT': thoiGianKT,
        'maLop': maLop,
        'ghiChu': ghiChu,
        'sanPham': sanPham
    },function(data){
        if(data==1){
            Swal.fire(
                'Đã thêm!',
                'Bạn đã thêm tiến độ thành công.',
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
                text: 'Lớp đã có địa chỉ nộp sản phẩm!'
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
$(".btn-edit-process").click(function(){
    let id = $("#editID").val();
    let maLop = $(".dsLop").val();
    let tieuDe = $("#editTitle").val();
    let ghiChu = $("#editNote").val();
    let thoiGianBD = $("#editBD").val();
    let thoiGianKT = $("#editBD").val();
    if(tieuDe==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập tiêu đề!'
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
    if(thoiGianBD==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa thời gian bắt đầu!'
        })
        return;
    }
    if(thoiGianKT==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa thời gian kết thúc!'
        })
        return;
    }
    $.post("../../Models/ProcessModel.php",{
        'edit': "addProcess",
        'id': id,
        'tieuDe': tieuDe,
        'thoiGianBD': thoiGianBD,
        'thoiGianKT': thoiGianKT,
        'maLop': maLop,
        'ghiChu': ghiChu,
    },function(data){
        if(data==1){
            Swal.fire(
                'Đã cập nhật!',
                'Bạn đã cập nhật tiến độ thành công.',
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
                    $.post("../../Models/ProcessModel.php",{
                        'delete': 'deleTopic',
                        'maTD': this.id
                    },function(data){
                        if(data==1){
                            Swal.fire(
                                'Đã xoá!',
                                'Bạn đã xoá tiến độ thành công.',
                                'success'
                            )
                            search(maLop);
                        }else if(data==2){
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Tiến độ đã có sinh viên nộp bài không thể xoá!'
                            })
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
function submitDetail(){
    var form = document.getElementsByClassName("btn_detail");
    for(i=0;i<form.length;i++){
        form[i].addEventListener('click', function(){
            let id = this.id;
            $.post("../../Models/ProcessModel.php",{
                'id-detail': this.id
            },function(data){
                if(data!=""){
                    $(".table-detail").html(data);
                    $('#tableDetail').DataTable({
                        "lengthMenu": [ 5, 10, 15, 20]
                    });
                }
            })
        })
    }
}

