function dongho(){
    let date = new Date();
    let timeEnd = new Date(document.getElementById('timeEnd').value);
    
    if(timeEnd<date){
        var diff = new Date(date.getTime() - timeEnd.getTime());
        let value = "Tháng: "+diff.getUTCMonth()+" Ngày: "+(diff.getUTCDate()-1)+
        " Giờ: "+diff.getUTCHours()+ " Phút: "+diff.getUTCMinutes()
        + " Giây: "+diff.getUTCSeconds();
        $('#timeRemaining').html("<p style='color:red;'>Đã quá hạn "+value+"</p>");
    }else{
        var diff = new Date(timeEnd.getTime() - date.getTime());
        let value = "Tháng: "+diff.getUTCMonth()+" Ngày: "+(diff.getUTCDate()-1)+
        " Giờ: "+diff.getUTCHours()+ " Phút: "+diff.getUTCMinutes()
        + " Giây: "+diff.getUTCSeconds();
        $('#timeRemaining').html("<p>"+value+"</p>");
    }
    setTimeout(() => {
        dongho();
    }, 1000);
}
dongho();

