function register() {
    email = document.getElementById('reg_email').value;
    username = document.getElementById('reg_username').value;
    password = document.getElementById('reg_passwd').value;
    rep_password = document.getElementById('reg_passwd_rep').value;

    if (email.includes("@") && email.includes(".") && email.length != 0 &&
        username.length != 0 && password.length != 0) {
        if (password != rep_password) {
            alert("Podane hasła nie zgadzają sie ze sobą!");
            return false;
        }

        return true;
    } else {
        alert("Podano niepoprawne dane!");
        return false;
    }
}

function login() {
    username = document.getElementById('username').value;
    password = document.getElementById('passwd').value;

    if (username.length == 0 || password.length == 0){
        alert("Login i haslo nie moga byc puste!");
        return false;
    }

    return true;
}

function getErrorMessage() {
    const queryString = window.location.search;
    const urlParameters = new URLSearchParams(queryString);

    message = document.getElementById( urlParameters.get('type') );
    message.innerHTML = urlParameters.get('message');
}