
var linkProcess = document.getElementsByClassName("link-title-process")
for(i=0; i<linkProcess.length;i++){
    linkProcess[i].addEventListener('click', function(){
        $.post("../../Models/DetailThesisModel.php",{
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
            $.post("../../Models/DetailThesisModel.php",{
                "id-cancel":this.id
            },function(data){
                if(data==1)
                    location.href = "../../Views/ThesisListView/ThesisListView.php";
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
$(window).on('load', function(){
	const modal = document.querySelector('.modal')
	const iconCloseModal = document.querySelector('.modal__header i')
	const btnClose = document.querySelector('.btn-close')

	function toggleModal() {
		modal.classList.toggle('hide')
	}
	btnClose.addEventListener('click', function(){
		toggleModal();
	})
	iconCloseModal.addEventListener('click', function(){
		toggleModal();
	})
	
	modal.addEventListener('click', (e) => {
		if (e.target == e.currentTarget){
			toggleModal();
		}
	})
    $(".link-topic").click(function(){
        let data = this.id.split(",");
        openModal(data);
    })
})

function openModal(data){
	var modal = document.querySelector('.modal')
	modal.classList.toggle('hide')
    
    $("#tenDT").val(data[0]);
    $("#GhiChu").val(data[1]);
}