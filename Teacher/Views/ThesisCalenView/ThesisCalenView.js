
function showEditCalen(value){
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
    var data =value.split(","); 
    if(data.length>1){               
        if(data[0]!=null)
            document.getElementById('editMaLich').value = data[0];
        $('#editMaHD').val(data[1]).change();
        $('#editMaHD').trigger("chosen:updated");
        if(data[2]!=null){
            var lan1 = data[2].replace(" ","T");
            document.getElementById('editLan1').value = lan1;
        }
            
        if(data[3]!=null){
            var lan2 = data[3].replace(" ","T");
            document.getElementById('editLan2').value = lan2;
            document.getElementById("editLan2").disabled = false;
        }        
        
    }else{
        document.getElementById('editMaLich').value = "";
        document.getElementById('editMssv').value = value;
        $('#editMaHD').val("-1").change();
        $('#editMaHD').trigger("chosen:updated");
        $('#editLan1').val("mm/dd/yyyy --:-- --");
        $('#editLan2').val("mm/dd/yyyy --:-- --");
        document.getElementById("editLan2").disabled = true;
    }
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});

document.querySelector('.close_SV').addEventListener('click',
function() {
    document.querySelector('.modal_SV').style.visibility = 'hidden';
    document.querySelector('.modal_SV').style.opacity = '0';
});
function showDetailStudent(value) {
    document.querySelector('.modal_SV').style.visibility = 'visible';
    document.querySelector('.modal_SV').style.opacity = '1';
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
$(document).ready(function(){
    $(".dsHKNH").change(function(){
        var id = $(".dsHKNH").val();
        $.post("../../Models/ThesisCalenModel.php",{"id": id},function(data){
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
            search(maLop);
            loadHD(maLop);
        }
        
    })
    
})
function loadHD(maLop){
    $.post("../../Models/ThesisCalenModel.php",{
        'loadHD': maLop
    },function(data){
        $("#editMaHD").html(data);
        $(".calen_select_Add").chosen({
            allow_single_deselect: true,
            no_results_text: "Không tìm thấy kết quả :",
            width: "70%"
        });
        console.log(data);
    })
    console.log("load hd dc goi");
}
function search(maLop){
    $.post("../../Models/ThesisCalenModel.php",{
        'search': maLop
    },function(data){
        $(".table").html(data);
        $('#tableCalen').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
        });
    })
}
$(".btn-save-calen").click(function(){
    let maLop = $(".dsLop").val();
    let maLich = $("#editMaLich").val();
    let mssv = $("#editMssv").val();
    let maHD = $("#editMaHD").val();
    let lan1 = $("#editLan1").val();
    let lan2 = $("#editLan2").val();
    if(maLop==-1){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa chọn lớp học phần!'
        })
        return;
    }
    if(maHD==-1){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa chọn hội đồng!'
        })
        return;
    }
    if(lan1==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập thời gian bảo vệ lần 1!'
        })
        return;
    }
    if(maLich!=''){
        $.post("../../Models/ThesisCalenModel.php",{
            'edit': "editCalen",
            'maLich': maLich,
            'maHD': maHD,
            'lan1': lan1,
            'lan2': lan2,
        },function(data){
            if(data==1){
                Swal.fire(
                    'Đã cập nhật!',
                    'Bạn đã cập nhật lịch bảo vệ thành công.',
                    'success'
                )
                search(maLop);
                document.querySelector('.modal').style.visibility = 'hidden';
                document.querySelector('.modal').style.opacity = '0';
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: data
                })
            }
        })
    }else{
        $.post("../../Models/ThesisCalenModel.php",{
            'add': "addCalen",
            'maHD': maHD,
            'mssv': mssv,
            'lan1': lan1,
        },function(data){
            if(data==1){
                Swal.fire(
                    'Đã cập nhật!',
                    'Bạn đã xếp lịch bảo vệ thành công.',
                    'success'
                )
                search(maLop);
                document.querySelector('.modal').style.visibility = 'hidden';
                document.querySelector('.modal').style.opacity = '0';
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