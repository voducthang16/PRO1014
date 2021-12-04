function notification(type,content){
    if (type == "success") {
        color = '#4BB543';  
    } else {
        color = '#FC100D';
    };
    let str = content.split(' ').join('');
    $('div').remove('.'+str+'');
    let html = '<div class="notification '+str+'" style="--color-noTi:'+color+'"><p class="content">'+content+'.</p></div>';
    $('.container-app-user').append(html);
    setTimeout(function(){
        $('.notification').css({
            'right':'-110%',
            'animation': 'notification-remove 2s'
        });
        setTimeout(function(){
            $('div').remove('.'+str+'');
        }, 500);
    }, 2000);
}
