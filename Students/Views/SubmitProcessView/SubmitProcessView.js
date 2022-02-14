function dongho(){
    let date = new Date();
    let timeEnd = new Date(document.getElementById('timeEnd').value);
    
    if(timeEnd<date){
        var diff = new Date(date.getTime() - timeEnd.getTime());
        let value = "Tháng: "+diff.getUTCMonth()+" Ngày: "+(diff.getUTCDate()-1)+
        " Giờ: "+diff.getUTCHours()+ " Phút: "+diff.getUTCMinutes()
        + " Giây: "+diff.getUTCSeconds();
        $('#timeRemaining').html("<p style='color:red;'>Đã quá hạn "+value+"</p>");
    }else{
        var diff = new Date(timeEnd.getTime() - date.getTime());
        let value = "Tháng: "+diff.getUTCMonth()+" Ngày: "+(diff.getUTCDate()-1)+
        " Giờ: "+diff.getUTCHours()+ " Phút: "+diff.getUTCMinutes()
        + " Giây: "+diff.getUTCSeconds();
        $('#timeRemaining').html("<p>"+value+"</p>");
    }
    setTimeout(() => {
        dongho();
    }, 1000);
}
dongho();
var form = document.getElementsByClassName("form-delete-file");
for(i=0;i<form.length;i++){
    form[i].addEventListener('submit', function(e){
        e.preventDefault();    
        Swal.fire({
            title: 'Bạn có chắc muốn xoá file?',
            text: "Bạn sẽ không thể khôi phục dữ liệu đã xoá!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Vâng, hãy xoá!',
            cancelButtonText: 'Huỷ.'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();            
            }
        })
    })
}
