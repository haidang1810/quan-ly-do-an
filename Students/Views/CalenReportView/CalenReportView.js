var form = document.getElementsByClassName("form-cancel");
for(i=0;i<form.length;i++){
    form[i].addEventListener('submit', function(e){
        e.preventDefault();    
        Swal.fire({
            title: 'Xác nhận huỷ',
            text: "Bạn có chắc muốn huỷ lịch báo cáo!",
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