let authenticated = document.getElementById('authenticated').value;
console.log(authenticated);

function toggleLoginForm(authenticated) {
    const loginForm = document.getElementById('loginForm');
    loginForm.classList.toggle('slide');
}

window.onload = function () {
    if (authenticated) {
        console.log(authenticated);
        document.getElementById('loginForm').classList.add('slide');
    }
};