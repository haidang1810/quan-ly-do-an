function suggest(){
    var form = document.getElementsByClassName("btn_suggest");
    for(i=0;i<form.length;i++){
        form[i].addEventListener('click', function(){
            Swal.fire({
                title: 'Bạn có chắc duyệt đề tài?',
                text: "Bạn sẽ không thể khôi phục dữ liệu sau khi duyệt!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vâng, hãy xoá!',
                cancelButtonText: 'Huỷ.'
            }).then((result) => {
                if (result.isConfirmed) {
                    let maDT = $(".MaDX-suggest").val();
                    let tenDT = $(".TenDT").val();
                    let ghiChu = $(".GhiChu").val();
                    let maLop = $(".dsLop").val();
                    $.post("../../Models/TopicSuggestModel.php",{
                        'suggest': 'suggestTopic',
                        'maDT': maDT,
                        'tenDT': tenDT,
                        'ghiChu': ghiChu,
                        'maLop': maLop
                    },function(data){
                        if(data==1){
                            Swal.fire(
                                'Đã cập nhật!',
                                'Bạn đã duyệt đề tài thành công.',
                                'success'
                            )
                            search(maLop);
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: data
                            })
                        }
                    })
                }
            })
        })
    }
}
function refuse(){
    var form = document.getElementsByClassName("btn_refuse");
    for(i=0;i<form.length;i++){
        
        form[i].addEventListener('click', function(){
            Swal.fire({
                title: 'Bạn có chắc muốn từ chối đề tài?',
                text: "Bạn sẽ không thể khôi phục dữ liệu sau khi duyệt!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vâng, hãy xoá!',
                cancelButtonText: 'Huỷ.'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = this.id;
                    let maLop = $(".dsLop").val();
                    $.post("../../Models/TopicSuggestModel.php",{
                        'refuse': 'refuseTopic',
                        'id_refuse': id
                    },function(data){
                        if(data==1){
                            Swal.fire(
                                'Đã cập nhật!',
                                'Bạn đã từ chỗi đề tài thành công.',
                                'success'
                            )
                            search(maLop);
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: data
                            })
                        }
                    })
                }
            })
        })
    }
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
$(window).on('load',function(){
    $(".topic_button_search").click(function(){
        let maLop = $(".dsLop").val();
        if(maLop!=-1){
            search(maLop)
        }
        
    })
    
})
function search(maLop){
    $.post("../../Models/TopicSuggestModel.php",{
        'search': maLop
    },function(data){
        $(".table").html(data);
        $('#tableTopic').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ],
        });
        suggest();
        refuse()
        $(".paginate_button").click(function(){
            suggest();
            refuse()
        })
    })
}