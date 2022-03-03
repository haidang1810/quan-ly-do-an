$(".link-topic").click(function(){
    location.href = "../../Views/RegisTopicView/RegisTopicView.php"
})
$(".link-calen").click(function(){
    location.href = "../../Views/CalenReportView/CalenReportView.php"
    console.log("click");
})
var linkProcess = document.getElementsByClassName("link-title-process")
for(i=0; i<linkProcess.length;i++){
    linkProcess[i].addEventListener('click', function(){
        $.post("../../Models/DetailClassModel.php",{
            "id-title":this.id
        },function(data){
            if(data==1)
                location.href = "../../Views/SubmitProcessView/SubmitProcessView.php"
        })
    })
}
$(".cancel_class").click(function(){
    console.log("click");
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
            $.post("../../Models/DetailClassModel.php",{
                "id-cancel":this.id
            },function(data){
                if(data==1)
                    location.href = "../../Views/ClassListView/ClassListView.php";
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Môn học đã bắt đầu không thể huỷ'
                    })
                }
            })
        }
    })
})
function hamDropdown() {
    document.querySelector(".noidung_dropdown").classList.toggle("hienThi");
}

window.onclick = function(e) {
    if (!e.target.matches('.nut_dropdown')) {
    var noiDungDropdown = document.querySelector(".noidung_dropdown");
    if (noiDungDropdown.classList.contains('hienThi')) {
        noiDungDropdown.classList.remove('hienThi');
    }
    }
}


