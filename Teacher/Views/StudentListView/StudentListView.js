
document.querySelector('.close').addEventListener('click',
function() {
    document.querySelector('.modal').style.visibility = 'hidden';
    document.querySelector('.modal').style.opacity = '0';
});

function showEditScore(value) {
    document.querySelector('.modal_edit').style.visibility = 'visible';
    document.querySelector('.modal_edit').style.opacity = '1';
    var data =value.split(",");
    
    document.getElementById('editCode').value = data[0];
    document.getElementById('editClass').value = data[1];
    document.getElementById('editDiemSo').value = data[2];
    document.getElementById('editDiemChu').value = data[3];
}
document.querySelector('.close_edit').addEventListener('click',
function() {
    document.querySelector('.modal_edit').style.visibility = 'hidden';
    document.querySelector('.modal_edit').style.opacity = '0';
});

function showEditLV(value) {
    document.querySelector('.modal_editLV').style.visibility = 'visible';
    document.querySelector('.modal_editLV').style.opacity = '1';
    var data =value.split(",");
    
    document.getElementById('editCodeLV').value = data[0];
    document.getElementById('editClassLV').value = data[1];
    document.getElementById('editDiemCTHD').value = data[2];
    document.getElementById('editDiemCBHD').value = data[3];
    document.getElementById('editDiemGVPB').value = data[4];
    document.getElementById('editDiemTB').value = data[5];
    document.getElementById('editDiemChuLV').value = data[6];
}
document.querySelector('.close_editLV').addEventListener('click',
function() {
    document.querySelector('.modal_editLV').style.visibility = 'hidden';
    document.querySelector('.modal_editLV').style.opacity = '0';
});

function subPoint(value){
    if(value>=8.5 && value<=10)
        document.getElementById('editDiemChu').value = "A";
    else if(value>=7.8 && value<=8.4)
        document.getElementById('editDiemChu').value = "B+";
    else if(value>=7.0 && value<=7.7)
        document.getElementById('editDiemChu').value = "B";
    else if(value>=6.3 && value<=6.9)
        document.getElementById('editDiemChu').value = "C+";
    else if(value>=5.5 && value<=6.2)
        document.getElementById('editDiemChu').value = "C";
    else if(value>=4.8 && value<=5.4)
        document.getElementById('editDiemChu').value = "D+";
    else if(value>=4.0 && value<=4.7)
        document.getElementById('editDiemChu').value = "D";
    else if(value <= 4.0)
        document.getElementById('editDiemChu').value = "F";
}
function avgPoint(){
    var diemCTHD = Number(document.getElementById('editDiemCTHD').value);
    var diemCBHD = Number(document.getElementById('editDiemCBHD').value);
    var diemPB = Number(document.getElementById('editDiemGVPB').value);
    var value = (diemCTHD+diemCBHD+diemPB)/3
    document.getElementById('editDiemTB').value = value;
    if(value>=8.5 && value<=10)
        document.getElementById('editDiemChuLV').value = "A";
    else if(value>=7.8 && value<=8.4)
        document.getElementById('editDiemChuLV').value = "B+";
    else if(value>=7.0 && value<=7.7)
        document.getElementById('editDiemChuLV').value = "B";
    else if(value>=6.3 && value<=6.9)
        document.getElementById('editDiemChuLV').value = "C+";
    else if(value>=5.5 && value<=6.2)
        document.getElementById('editDiemChuLV').value = "C";
    else if(value>=4.8 && value<=5.4)
        document.getElementById('editDiemChuLV').value = "D+";
    else if(value>=4.0 && value<=4.7)
        document.getElementById('editDiemChuLV').value = "D";
    else if(value <= 4.0)
        document.getElementById('editDiemChuLV').value = "F";
}