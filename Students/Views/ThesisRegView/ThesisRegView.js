var Mssv = document.getElementById('currentUser').value;
function loadData(id,mssv){
    $.post('../../Models/ThesisRegModels.php',{
        'id': id,
        'mssv': mssv
    },function(data){
        if(data!=""){
            //add data
            $(".table-class").html(data);
            $('#tableClass').DataTable({
                "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
            });
            //event form submit
            eventSubmitForm();
        }else{
            var content = "<h4>Không có lớp trong học kỳ này</h4>"
            $(".table-class").html(content);
        }
    },)
}
$(document).ready(function(){
    $(".button_search").click(function(){
        var id = $(".select_hknh").val();
        loadData(id,Mssv);
    })
})

function eventSubmitForm(){
    var form = document.getElementsByClassName("form-register");
    for(i=0;i<form.length;i++){
        form[i].addEventListener('submit', function(e){
            e.preventDefault();    
            const childForm = this.children;
            Swal.fire({
                text: "Bạn có chắc đăng ký lớp "+childForm[1].value+" không?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đăng ký!',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("submit");
                    actionRegister(childForm[0],childForm[1].value,Mssv); 
                }
            })
        })
    }
}

function actionRegister(btn,maLop,mssv){
    $.post("../../Models/ThesisRegModels.php",{
        "maLopLV": maLop,
        "mssv": mssv
        },function(data){
            if(data==1){
                Swal.fire(
                    'Đăng ký thành công!',
                    `Bạn đã đăng ký vào lớp ${maLop}.`,
                    'success'
                )
                btn.remove();
            }
        })
}
