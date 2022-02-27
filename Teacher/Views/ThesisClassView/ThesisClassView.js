
$('.btn_setting').each(function(){
    let value = this.id.split(',');
    var maLop = value[1];
    var currentPas = value[0];
    $(this).click(function(){
        Swal.fire({
            title: 'Nhập vào mật khẩu lớp học',
            input: 'text',
            inputValue: currentPas,
            confirmButtonText: "Xác nhận",
            showCancelButton: true,
            cancelButtonText: 'Huỷ',
            cancelButtonColor: '#d33',
            inputPlaceholder: 'Nhập vào mật khẩu lớp học',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            preConfirm: (pass) => {
                $.post("../../Models/ThesisClassModel.php",{
                    'maLop': maLop,
                    'pass': pass
                },function(data){
                    if(data==1){
                        Swal.fire({
                            title: 'Đã lưu!',
                            text: 'Bạn đã cập nhật mật khẩu vào lớp thành công.',
                            icon: 'success',
                            didClose: ()=>{
                                window.location.href = window.location.href;
                            }
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Vui lòng thử lại!'
                        })
                    }
                })
            }
        });
    })
})