$(document).ready(function () {
    $("#search-button").on("click", function () {
        
        var input = $("#search-field").val().trim();

        if (input !== "") {
            $.ajax({
                url: `Categories/search/${input}`,
                method: 'GET',
                success: function (categories) {
                    if (categories.trim() === "") {
                        $("#message").text("Nothing found!");
                    } else {
                        $("#categories-body").html(categories);
                        $("#back-to-list").show();
                        $("#message").text("");
                    }
                },
                error: function (error) {
                    console.error("Error fetching categories:", error);
                    $("#message").text("Error fetching categories.");
                }
            });
        } else {
            document.getElementById("message").innerHTML = "";
        }
    });
});
