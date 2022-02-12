
function showEditCalen(value){
    document.querySelector('.modal').style.visibility = 'visible';
    document.querySelector('.modal').style.opacity = '1';
    var data =value.split(","); 
    if(data.length>1){               
        if(data[0]!=null)
            document.getElementById('editMaLich').value = data[0];
            $('#editMaHD').val(data[1]).change();
            $('#editMaHD').trigger("chosen:updated");
        if(data[2]!=null){
            var lan1 = data[2].replace(" ","T");
            document.getElementById('editLan1').value = lan1;
        }
            
        if(data[3]!=null){
            var lan2 = data[3].replace(" ","T");
            document.getElementById('editLan2').value = lan2;
            document.getElementById("editLan2").disabled = false;
        }        
        
    }else{
        document.getElementById('editMaLich').value = "";
        document.getElementById('editMssv').value = value;
        $('#editMaHD').val("").change();
        $('#editMaHD').trigger("chosen:updated");
        $('#editLan1').val("mm/dd/yyyy --:-- --");
        $('#editLan2').val("mm/dd/yyyy --:-- --");
        document.getElementById("editLan2").disabled = true;
    }
}
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});

document.querySelector('.close_SV').addEventListener('click',
function() {
    document.querySelector('.modal_SV').style.visibility = 'hidden';
    document.querySelector('.modal_SV').style.opacity = '0';
});
function showDetailStudent(value) {
    document.querySelector('.modal_SV').style.visibility = 'visible';
    document.querySelector('.modal_SV').style.opacity = '1';
    var data =value.split(",");
    
    if(data[0]!=null)
        document.getElementById('Mssv').innerHTML = "<b>Mssv: </b>" + data[0];
    if(data[1]!=null)    
        document.getElementById('HoTen').innerHTML = "<b>Họ và tên: </b>" + data[1];
    if(data[2]!=null)
        document.getElementById('NgaySinh').innerHTML = "<b>Ngày sinh: </b>"+ data[2];
    if(data[3]!=null)    
        document.getElementById('SDT').innerHTML = "<b>SDT: </b>" + data[3];
    if(data[4]!=null)
        document.getElementById('DiaChi').innerHTML = "<b>Địa chỉ: </b>" + data[4];
    if(data[5]!=null)    
        document.getElementById('Khoa').innerHTML = "<b>Khoá: </b>" + data[5];
    if(data[6]!=null)
        document.getElementById('Lop').innerHTML = "<b>Lớp: </b>" + data[6];
}
$(document).ready(function(){
    $(".dsHKNH").change(function(){
        var id = $(".dsHKNH").val();
        $.post("../../Models/ThesisCalenModel.php",{"id": id},function(data){
            if(data=="")
                $(".dsLop").html("<option value='-1'>Chọn lớp HP</option>");
            else
                $(".dsLop").html(data);
            $('.dsLop').trigger("chosen:updated");
        })
    })
})