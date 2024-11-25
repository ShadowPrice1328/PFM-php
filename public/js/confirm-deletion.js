
$(document).ready(function () {
    const initialDetailsContent = $(".details-section dl").html();

    $("#delete-btn").on("click", function (e) {
        if ($("#delete-btn").val() !== "Yes") {

            e.preventDefault();

            $(".details-section dl").css("margin-left", "3rem");
            $(".details-section dl").css("grid-template-columns", "1fr 1fr");
            $(".details-section dl").html("<h2>Are you sure?</h2>");

            $("#delete-btn").val("Yes");
            $("#back-to-list-btn").text("No");
        }
    });

    $("#back-to-list-btn").on("click", function (e) {
        if ($("#delete-btn").val() === "Yes") {
            e.preventDefault();

            $(".details-section dl").css("margin-left", "1.5rem");
            $(".details-section dl").css("grid-template-columns", "1fr 2fr");

            $(".details-section dl").html(initialDetailsContent);

            $("#delete-btn").val("Delete");
            $("#back-to-list-btn").text("Back");
        }
    });
});
