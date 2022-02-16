function showAddTopic() {
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});
function showEditTopic(value) {
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    var data =value.split(",");
    
    document.getElementById('nameEdit').value = data[0];
    document.getElementById('idEdit').value = data[1];
    document.getElementById('AmountEdit').value = data[2];
    document.getElementById('noteEdit').innerHTML = data[3];
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
        $.post("../../Models/TopicModel.php",{"id": id},function(data){
            if(data=="")
                $(".dsLop").html("<option value='-1'>Chọn lớp HP</option>");
            else
                $(".dsLop").html(data);
            $('.dsLop').trigger("chosen:updated");
        })
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
                    $.post("../../Models/TopicModel.php",{
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


$(window).on('load',function(){
    $(".topic_button_search").click(function(){
        let maLop = $(".dsLop").val();
        if(maLop!=-1){
            search(maLop)
        }
        
    })
    
})
function search(maLop){
    $.post("../../Models/TopicModel.php",{
        'search': maLop
    },function(data){
        $(".table").html(data);
        $('#tableTopic').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ],
            
        });
        $(".paginate_button").click(function(){
            submitDelete();
        })
        submitDelete();
    })
}

$(".btn-add-topic").click(function(){
    let tenDT = $(".TenDeTai").val();
    let soTV = $(".SoThanVien").val();
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
    if(soTV==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập số thành viên!'
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
    $.post("../../Models/TopicModel.php",{
        'add': "addtopic",
        'tenDT': tenDT,
        'soTV': soTV,
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
    let maDT = $("#idEdit").val();
    let tenDT = $("#nameEdit").val();
    let soTV = $("#AmountEdit").val();
    let maLop = $(".dsLop").val();
    let ghiChu = $("#noteEdit").val();
    if(tenDT==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập tên đề tài!'
        })
        return;
    }
    if(soTV==""){
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Chưa nhập số thành viên!'
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
    $.post("../../Models/TopicModel.php",{
        'edit': "editTopic",
        'maDT': maDT,
        'tenDT': tenDT,
        'soTV': soTV,
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