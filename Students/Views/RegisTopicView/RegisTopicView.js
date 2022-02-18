var remining = 0;
var listSV = new Array();
var Mssv = document.getElementById('currentUser').value;
$(window).on('load', function(){
	const modal = document.querySelector('.modal-offers')
	const iconCloseModal = document.querySelector('.modal-offers-header i')
	
	function toggleModal() {
		modal.classList.toggle('hide')
		allChecked();
	}
	
	iconCloseModal.addEventListener('click', function(){
		toggleModal();
	})
	
	modal.addEventListener('click', (e) => {
		if (e.target == e.currentTarget){
			toggleModal();
		}
	})
})
$(window).on('load', function(){
	const modal = document.querySelector('.modal')
	const iconCloseModal = document.querySelector('.modal__header i')
	
	function toggleModal() {
		modal.classList.toggle('hide')
		allChecked();
	}
	
	iconCloseModal.addEventListener('click', function(){
		toggleModal();
	})
	
	modal.addEventListener('click', (e) => {
		if (e.target == e.currentTarget){
			toggleModal();
		}
	})
})

function openModal(value){
	var modal = document.querySelector('.modal')
	modal.classList.toggle('hide')
	let data =value.split(",");
	listSV.push(Mssv)
	var id = document.getElementById("Id_DT");
	id.value = data[0]
	remining = Number(data[1]);
	remining--;
	if(remining<=0){
		changeCheckbox(true);
	}else
		changeCheckbox(false);
}


$(window).on('load', function(){
	$("#btn-offer").click(function(){
		var modal = document.querySelector('.modal-offers')
		modal.classList.toggle('hide')
	})
})
function allChecked(){
	var checkbox = document.getElementsByClassName("enable");
	for(i=0;i<checkbox.length;i++){
		checkbox[i].checked = false;
	}
	listSV = [];
}
function changeCheckbox(status){
	var checkbox = document.getElementsByClassName("enable");
	for(i=0;i<checkbox.length;i++){
		if(status==true){
			if(checkbox[i].checked==false)
				checkbox[i].disabled = status;
		}
		else 
			checkbox[i].disabled = status;
	}
}
function onChecked(id){
	var currentCB = document.getElementById(id);
	if(currentCB.checked==true){
		listSV.push(id);
		remining-=1;
		if(remining==0)
			changeCheckbox(true);
	}else{
		let index = listSV.indexOf(id);
		listSV.splice(index,1);
		remining++;
		changeCheckbox(false);
	}
}
submitCancel();
$(".paginate_button").click(function(){
	submitCancel();
})
function submitCancel(){
	var form = document.getElementsByClassName("form-cancel");
	for(i=0;i<form.length;i++){
		form[i].addEventListener('submit', function(e){
			e.preventDefault();    
			Swal.fire({
				title: 'Xác nhận huỷ',
				text: "Bạn có chắc muốn huỷ đề tài!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Đồng ý!',
				cancelButtonText: 'Huỷ'
			}).then((result) => {
				if (result.isConfirmed) {
					this.submit();            
				}
			})
		})
	}
}


$(window).on('load',function () {
	$(".modal__button__submit").click(function(){
		var maDT = document.getElementById("Id_DT").value;
		$.post("../../Models/RegisTopicModel.php",{
			'listSV': listSV.toString(),
			'MaDT': maDT
		},function(data){
			if(data!=1){
				Swal.fire({
					icon: 'error',
					title: 'Lỗi...',
					text: data
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.reload()        
					}
				})
				
			}else{
				Swal.fire(
					'Đã đăng ký!',
					'Bạn đã đăng ký đề tài thành công.',
					'success'
				).then((result) => {
					if (result.isConfirmed) {
						window.location.reload()        
					}
				})
			}
		})
	})
})
