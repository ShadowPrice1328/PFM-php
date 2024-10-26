$(document).ready(function () {
    $("#search-button").on("click", function () {
        var input = $("#search-field").val().trim();

        if (input !== "") {
            $.ajax({
                url: `categories/search/${input}`,
                method: 'GET',
                dataType: 'json', // Expecting a JSON response
                success: function (response) {
                    $("#categories-body").html(response.content); // Update categories table
                    $("#message").text(response.message); // Display message
                    $("#back-to-list").show(); // Show the back button
                },
                error: function (error) {
                    console.error("Error fetching categories:", error);
                    $("#message").text("Error fetching categories.");
                }
            });
        } else {
            $("#message").text(""); // Clear the message if input is empty
        }
    });
});
