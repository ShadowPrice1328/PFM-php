let authenticated = document.getElementById('authenticated').value;
let formToSlide = document.getElementById('formToSlide').value;

console.log(authenticated);

function toggleLoginForm(authenticated) {
    const loginForm = document.getElementById(formToSlide);
    loginForm.classList.toggle('slide');
}

window.onload = function () {
    if (authenticated) {
        console.log(authenticated);
        document.getElementById(formToSlide).classList.add('slide');
    }
};