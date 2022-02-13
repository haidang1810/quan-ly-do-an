$(".link-topic").click(function(){
    location.href = "../../Views/RegisTopicView/RegisTopicView.php"
})

var linkProcess = document.getElementsByClassName("link-title-process")
for(i=0; i<linkProcess.length;i++){
    linkProcess[i].addEventListener('click', function(){
        $.post("../../Models/DetailClassModel.php",{
            "id-title":this.id
        },function(data){
            if(data==1)
                location.href = "../../Views/SubmitProcessView/SubmitProcessView.php"
        })
    })
}