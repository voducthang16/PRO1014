$(document).ready(function() {
    $(".search-btn").click(function(e) {
        e.preventDefault();
        if ($("#search").val().trim() != "") {
            $("#search-form").submit();
        } else {
            notification({  title : 'Warning',
                                    message : 'Vui lòng nhập từ khoá',
                                    type : 'warning',
                                    duration : 3000});
        }
    })
});