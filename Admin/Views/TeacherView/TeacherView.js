function openTab(e, tabId){
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
    document.querySelector('.form_edit_tea').style.display = 'none';
    document.querySelector('.form_add_tea').style.display = 'none';
}

function showEdit(value){
    var data =value.split(",");
    var tabContent = document.getElementsByClassName("tab_content");
    for(i=0;i<tabContent.length;i++){
        tabContent[i].style.display = "none";
    }
    
    if(data[0]!=null)
        document.getElementById('editMaGV').value = data[0];
    if(data[1]!=null)
        document.getElementById('editHoten').value = data[1];  
    $('#editHocVi').val(data[2]).change();
    $('#editHocVi').trigger("chosen:updated");
    if(data[3]!=null)
        document.getElementById('editGmail').value = data[3];      
    if(data[4]!=null && data[4]!=0){
        $('#editLoai').val(data[4]).change();
        $('#editLoai').trigger("chosen:updated");
        document.querySelector('.select_type').style.display = 'inline-block';
    }else{
        document.querySelector('.select_type').style.display = 'none';
        $('#editLoai').val("0").change();
        $('#editLoai').trigger("chosen:updated");
    }

    document.querySelector('.form_edit_tea').style.display = 'block';
}
function showAdd(){
    var tabContent = document.getElementsByClassName("tab_content");
    for(i=0;i<tabContent.length;i++){
        tabContent[i].style.display = "none";
    }
    document.querySelector('.form_add_tea').style.display = 'block';
}

function disableAcc(){
    var form = document.getElementsByClassName("form-disable");
    console.log(form.length);
    for(i=0;i<form.length;i++){
        form[i].addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Vô hiệu hoá?',
                text: "Bạn có chắc muốn vô hiệu hoá tài khoản!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý!',
                cancelButtonText: 'Huỷ.'
            }).then((result) => {
                if (result.isConfirmed)
                    this.submit();
            })
        })
    }
}

function enableAcc(){
    var form = document.getElementsByClassName("form-enable");
    for(i=0;i<form.length;i++){
        form[i].addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Khôi phục tài khoản?',
                text: "Bạn có chắc muốn khôi phục tài khoản!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý!',
                cancelButtonText: 'Huỷ.'
            }).then((result) => {
                if (result.isConfirmed)
                    this.submit();
            })
        })
    }
}


function nextPage(){
    $(".paginate_button").click(function(){
        resetPass();
        enableAcc();
        disableAcc();
        nextPage();
    })
}
$(window).on('load',function(){
    resetPass();
    enableAcc();
    disableAcc();
    nextPage();
})

function resetPass(){
    var form = document.getElementsByClassName("reset-pass");
    for(i=0;i<form.length;i++){
        form[i].addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Khôi phục mật khẩu?',
                text: "Bạn có chắc muốn khôi phục mật khẩu  về mặc định là 123!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý!',
                cancelButtonText: 'Huỷ.'
            }).then((result) => {
                if (result.isConfirmed)
                    this.submit();
            })
        })
    }
}