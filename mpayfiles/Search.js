$(document).ready(function () {
    $("#txtsearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".table tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
$(document).ready(function () {
    $("#txtsearchbbps").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".mylist1 li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
$(document).ready(function () {
    $("#txtcategory").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#categoryList li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $("#txtService").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#serviceList li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $("#txtStatus").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#statusList li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});