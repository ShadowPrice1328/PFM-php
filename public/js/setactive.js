document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll("ul li a");
    const currentPath = window.location.pathname;

    navLinks.forEach(function (link) {
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");
        }

        link.addEventListener("click", function (event) {
            event.preventDefault();
            
            navLinks.forEach(function (link) {
                link.classList.remove("active");
            });

            this.classList.add("active");

            window.location.href = this.getAttribute("href");
        });
    });
});
