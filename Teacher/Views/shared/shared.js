function showSubItem(a) {
    nameBtn = "group_"+a;
    nameIcon = "angle_"+a;
    if(document.getElementById(nameBtn).className == "hidden")
    {
        document.getElementById(nameBtn).classList.remove("hidden");
        document.getElementById(nameIcon).classList.remove("fa-angle-right");
        document.getElementById(nameBtn).classList.add("show");
        document.getElementById(nameIcon).classList.add("fa-angle-down");
    }
    else
    {
        document.getElementById(nameBtn).classList.remove("show");
        document.getElementById(nameIcon).classList.remove("fa-angle-down");
        document.getElementById(nameBtn).classList.add("hidden");
        document.getElementById(nameIcon).classList.add("fa-angle-right");
    }

}
function hideMenu(){
    let hiddenMenu = document.querySelector('.menu');
    hiddenMenu.classList.toggle('menu_hide');
    let hiddenNav = document.querySelector('.nav');
    hiddenNav.classList.toggle('nav_hide');
    let hiddenContent = document.querySelector('.content');
    hiddenContent.classList.toggle('content_hide');
    let hiddenfooter = document.querySelector('.footer');
    hiddenfooter.classList.toggle('footer_hide');
    
    var hiddenTitle = document.getElementsByClassName("showTitle");
    for(i=0;i<hiddenTitle.length;i++){
        hiddenTitle[i].classList.toggle('title');
    }
}
function goDashboard(){
    location.href = "../../Views/DashboardView/DashboardView.php";
}
function goClass(){
    location.href = "../../Views/ClassView/ClassView.php";
}
function goThesisClass(){
    location.href = "../../Views/ThesisClassView/ThesisClassView.php";
}
function goThesisTopic(){
    location.href = "../../Views/ThesisTopicView/ThesisTopicView.php";
}
function goThesisPro(){
    location.href = "../../Views/ThesisProView/ThesisProView.php";
}
function goDashboard(){
    location.href = "../../Views/DashboardView/DashboardView.php";
}
function goProcess(){
    location.href = "../../Views/ProcessView/ProcessView.php";
}
function goTopicSugg(){
    location.href = "../../Views/TopicSuggestView/TopicSuggestView.php";
}
function goTopic(){
    location.href = "../../Views/TopicView/TopicView.php";
}
function goCalen(){
    location.href = "../../Views/CalendarView/CalendarView.php";
}
function goCouncil(){
    location.href = "../../Views/CouncilView/CouncilView.php";
}
function goThesisCalen(){
    location.href = "../../Views/ThesisCalenView/ThesisCalenView.php";
}