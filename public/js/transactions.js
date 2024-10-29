$(document).ready(function () {
    $("#category-selector").on("change", function () {
        console.log("Category selector found!");

        var selectedCategory = $("#category-selector").val();
        var filterBy = 'Category';

        console.log(`Selected category: ${selectedCategory}`);

        $.ajax({
            url: `transactions/filter?filterBy=${filterBy}&filterString=${selectedCategory}`,
            method: 'GET',
            success: function (response) {
                console.log("Response received successfully");
                $("#transactions-body").html(response.content);
                $("#back-to-list").show();
            },
            error: function (error) {
                console.error("Error fetching transactions:", error);
            }
        });
    })
});
