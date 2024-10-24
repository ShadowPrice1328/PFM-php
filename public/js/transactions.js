$(document).ready(function () {
    $("#category-selector").on("change", function () {
        console.log("Category selector found!");

        var selectedCategory = $("#category-selector").val();
        var filterBy = 'Category';

        console.log(`Selected category: ${selectedCategory}`);

        $.ajax({
            url: `Transactions/filter-by/${filterBy}/${selectedCategory}`,
            method: 'GET',
            success: function (transactions) {
                console.log("Response received successfully");

                $("#transactions-body").html(transactions);
                $("#back-to-list").show();
            },
            error: function (error) {
                console.error("Error fetching transactions:", error);
            }
        });
    })
});
