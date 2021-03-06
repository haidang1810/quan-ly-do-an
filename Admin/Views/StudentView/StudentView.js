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
    document.querySelector('.form_edit_Stu').style.display = 'none';
    document.querySelector('.form_add_Stu').style.display = 'none';
}

function showEdit(value){
    var data =value.split(",");
    var tabContent = document.getElementsByClassName("tab_content");
    for(i=0;i<tabContent.length;i++){
        tabContent[i].style.display = "none";
    }
    var mail = data[2].split("@")
    if(data[0]!=null)
        document.getElementById('editMssv').value = data[0];
    if(data[1]!=null)
        document.getElementById('editHoten').value = data[1];    
    if(data[2]!=null)
        document.getElementById('editGmail').value = "@"+mail[1]; 

    document.querySelector('.form_edit_Stu').style.display = 'block';
}
function showAdd(){
    var tabContent = document.getElementsByClassName("tab_content");
    for(i=0;i<tabContent.length;i++){
        tabContent[i].style.display = "none";
    }
    document.querySelector('.form_add_Stu').style.display = 'block';
}


function disableAcc(){
    var form = document.getElementsByClassName("form-disable");
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