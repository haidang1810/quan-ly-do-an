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
function goStudent(){
    location.href = "../../Views/StudentView/StudentView.php";
}
function goTeacher(){
    location.href = "../../Views/TeacherView/TeacherView.php";
}
function goThesis(){
    location.href = "../../Views/ThesisClassView/ThesisClassView.php";
}
function goSemster(){
    location.href = "../../Views/SemesterView/SemesterView.php";
}