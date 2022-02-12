function showAddTopic() {
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});
function showEditTopic(value) {
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    var data =value.split(",");
    
    document.getElementById('nameEdit').value = data[0];
    document.getElementById('idEdit').value = data[1];
    document.getElementById('AmountEdit').value = data[2];
    document.getElementById('noteEdit').innerHTML = data[3];
}
document.querySelector('.close_edit').addEventListener('click',
function() {
    document.querySelector('.modal_edit').style.visibility = 'hidden';
    document.querySelector('.modal_edit').style.opacity = '0';
});
function ConfirmDelete(){
    var x = confirm("Bạn có chắc muốn xoá?");
    if (x)
        return true;
    else
        return false;
}
function openTab(e,tabId){
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
    var tab = document.getElementById("tab");
    tab.classList.add("tab_active");
}

$(document).ready(function(){
    $(".dsHKNH").change(function(){
        var id = $(".dsHKNH").val();
        $.post("../../Models/TopicModel.php",{"id": id},function(data){
            if(data=="")
                $(".dsLop").html("<option value='-1'>Chọn lớp HP</option>");
            else
                $(".dsLop").html(data);
            $('.dsLop').trigger("chosen:updated");
        })
    })
})

var form = document.getElementsByClassName("form-delete");
for(i=0;i<form.length;i++){
    form[i].addEventListener('submit', function(e){
        e.preventDefault();    
        Swal.fire({
            title: 'Bạn có chắc muốn xoá?',
            text: "Bạn sẽ không thể khôi phục dữ liệu đã xoá!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Vâng, hãy xoá!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();            
            }
        })
    })
}

