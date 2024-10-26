$("#back-to-list").on("click", function () {
    $.ajax({
        url: $("#link").val(),
        method: 'GET',
        success: function (entities) {
            window.location.href = `${$("#link").val()}`;
        },
        error: function (error) {
            console.error("Error fetching data:", error);
            $("#message").text("Error fetching data.");
        }
    });
});