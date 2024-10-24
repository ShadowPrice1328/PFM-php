$("#back-to-list").on("click", function () {
    $.ajax({
        url: $("#link").val(),
        method: 'GET',
        success: function (entities) {
            if ($("#link").val() == "categories/search") {
                $("#categories-body").html(entities);
            } else {
                $("#transactions-body").html(entities);
            }
            $("#back-to-list").hide();
        },
        error: function (error) {
            console.error("Error fetching data:", error);
            $("#message").text("Error fetching data.");
        }
    });
});