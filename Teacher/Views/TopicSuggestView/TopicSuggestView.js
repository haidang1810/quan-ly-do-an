var form_suggest = document.getElementsByClassName("form-suggest");
for(i=0;i<form_suggest.length;i++){
    form_suggest[i].addEventListener('submit', function(e){
        e.preventDefault();    
        Swal.fire({
            title: 'Bạn có chắc duyệt đề tài?',
            text: "Bạn sẽ không thể khôi phục dữ liệu sau khi duyệt!",
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
var form_refuse = document.getElementsByClassName("form-refuse");
for(i=0;i<form_refuse.length;i++){
    form_refuse[i].addEventListener('submit', function(e){
        e.preventDefault();    
        Swal.fire({
            title: 'Bạn có chắc muốn từ chối đề tài?',
            text: "Bạn sẽ không thể khôi phục dữ liệu sau khi duyệt!",
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
$(document).ready(function(){
    $(".dsHKNH").change(function(){
        var id = $(".dsHKNH").val();
        $.post("../../Models/TopicSuggestModel.php",{"id": id},function(data){
            if(data=="")
                $(".dsLop").html("<option value='-1'>Chọn lớp HP</option>");
            else
                $(".dsLop").html(data);
            $('.dsLop').trigger("chosen:updated");
        })
    })
})