var remining = 0;
var listSV = new Array();
$(window).on('load', function(){
	const modal = document.querySelector('.modal')
	const iconCloseModal = document.querySelector('.modal__header i')
	const buttonCloseModal = document.querySelector('.modal__footer button')
	
	function toggleModal() {
		modal.classList.toggle('hide')
	}
	
	iconCloseModal.addEventListener('click', function(){
		toggleModal();
		allChecked();
	})
	buttonCloseModal.addEventListener('click', function(){
		toggleModal();
		allChecked();
	})
	
	modal.addEventListener('click', (e) => {
		if (e.target == e.currentTarget){
			toggleModal();
			allChecked();
		}
	})
})

function openModal(value){
	var modal = document.querySelector('.modal')
	modal.classList.toggle('hide')
	let data =value.split(",");
	remining = Number(data[1]);
	remining--;
	if(remining<=0){
		changeCheckbox(true);
	}else
		changeCheckbox(false);
}
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