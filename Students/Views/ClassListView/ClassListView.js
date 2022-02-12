var Mssv = document.getElementById('currentUser').value;
$(document).ready(function(){
    $(".tab2").click(function(){
        $.post("../../Models/ClassListModel.php",{
            "mssv": Mssv
        }, function(data){
            if(data!=""){
                $(".content-tab").html(data);
                onClickLink();
            }else{
                $(".content-tab").html("<h4>Không tìm thấy lớp thích hợp</h4>");
            }
        })
    })
})
$(document).ready(function(){
    $(".tab1").click(function(){
        $.post("../../Models/ClassListModel.php",{
            "history": Mssv
        }, function(data){
            $(".content-tab").html("");
            if(data!=""){
                $(".content-tab").html(data);
                onClickLink();
            }
        })
    })
})

$(document).ready(function(){
    $(".btn-search").click(function(){
        var key = $(".input-search").val();
        $.post("../../Models/ClassListModel.php",{
            "sv": Mssv,
            "key": key
        }, function(data){
            if(data!=""){
                $(".content-tab").html(data);
                onClickLink();
            }else{
                $(".content-tab").html("<h4>Không tìm thấy lớp thích hợp</h4>");
            }
        })
    })
})
var inputSearch = document.querySelector(".input-search");
inputSearch.addEventListener('focus', function(){
    document.getElementById("input-search").style.paddingRight = '55px';
    var searchBox = document.getElementById("search-box");
    searchBox.classList.add('open');
})
inputSearch.addEventListener('focusout', function(){
    document.getElementById("input-search").style.paddingRight = '0px';
    var searchBox = document.getElementById("search-box");
    searchBox.classList.remove('open');
})

$(window).on('load', function(){
    $.post("../../Models/ClassListModel.php",{
        "history": Mssv
    }, function(data){
        $(".content-tab").html("");
        if(data!=""){
            $(".content-tab").html(data);
            onClickLink();
        }
    })
});
function onClickLink(){
    var linkHP = document.getElementsByClassName("link-course");
    for(i=0;i<linkHP.length;i++){
        linkHP[i].addEventListener('click', function(){
            $.post("../../Models/ClassListModel.php",{
                "MaHP": this.nextElementSibling.value
            },function(data){
                if(data==1)
                    location.href = "../../Views/DetailClassView/DetailClassView.php";
            })
        })
    }
}