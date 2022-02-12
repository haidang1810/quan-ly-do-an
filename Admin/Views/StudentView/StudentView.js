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
    if(data[3]!=null)
        document.getElementById('editNamSinh').value = data[3];
    if(data[4]!=null)
        document.getElementById('editSDT').value = data[4];
    if(data[5]!=null)
        document.getElementById('editDiaChi').value = data[5];
    if(data[6]!=null)
        document.getElementById('editKhoa').value = data[6];
    if(data[7]!=null)
        document.getElementById('editLop').value = data[7];

    document.querySelector('.form_edit_Stu').style.display = 'block';
}
function showAdd(){
    var tabContent = document.getElementsByClassName("tab_content");
    for(i=0;i<tabContent.length;i++){
        tabContent[i].style.display = "none";
    }
    document.querySelector('.form_add_Stu').style.display = 'block';
}

function showPass(){
    
    var currentPass = document.getElementById("currentPass").value;
    var pass = document.getElementById("pass").value;
    var rowShow = document.getElementById("rowShow").value;
    if(currentPass==pass){
        document.getElementById(rowShow).type='text';
        document.querySelector('.modal').style.visibility = 'hidden';
        document.querySelector('.modal').style.opacity = '0';     
        document.getElementById("pass").value="";   
    }        
    else{
        document.querySelector('.modal').style.visibility = 'hidden';
        document.querySelector('.modal').style.opacity = '0'; 
        document.getElementById("pass").value="";
        alert("Sai mật khẩu");
    }
    
}
function showModalPass(value){
    var data =value.split(",");
    if(document.getElementById(data[0]).type=='password'){
        document.querySelector('.modal').style.visibility = 'visible';
        document.querySelector('.modal').style.opacity = '1';        
        document.getElementById('currentPass').value = data[1];
        document.getElementById('rowShow').value = data[0];
    }else
        document.getElementById(data[0]).type='password';
    
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});
function ConfirmDisable(){
    var x = confirm("Bạn có chắc muốn vô hiệu hoá tài khoản?");
    if (x)
        return true;
    else
        return false;
}
function ConfirmEnable(){
    var x = confirm("Bạn có chắc muốn kích hoạt tài khoản?");
    if (x)
        return true;
    else
        return false;
}