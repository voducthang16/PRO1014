$(document).ready(function() {
    $(".search-btn").click(function(e) {
        e.preventDefault();
        if ($("#search").val().trim() != "") {
            $("#search-form").submit();
        } else {
            alert("Vui long nhap tu khoa");
        }
    })
});