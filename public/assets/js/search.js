$(document).ready(function(){
    $('.ze-t51-search').click(function(e){
        e.preventDefault();
        let browserNow = location.href;
        if(browserNow.search(/search/) !== -1) {
            
        } else {
            window.location = "search";
        }
    })
    // $('.ze-t51-search').mouseout(function(e){
    //     e.preventDefault();
    //     let val = $(this).val();
    //     if (val == "") {
    //         history.back();
    //     }
    // })
    $('.ze-t51-search').keyup(function(e){
        e.preventDefault();
        let value = $(this).val();

        $.ajax({
            url: "search/get_data",
            method: "POST",
            data: {
                value: value,
            },
            success:function(data) {
                $('.container-product-search').html(data);
            }
        })
    })
});