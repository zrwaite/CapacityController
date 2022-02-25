const tryRegister = async () => {
    let usernameInput = document.getElementById("username");
    let passwordInput = document.getElementById("pword");
    let password2Input = document.getElementById("pword2");
    let emailInput = document.getElementById("email");
    let username = usernameInput.value;
    let password = passwordInput.value;
    let password2 = password2Input.value;
    let email = emailInput.value;
    if (username===""||password===""||email==="") return;
    if (password!==password2) {
        alert("passwords don't match");
        return;
    }
    let json = await httpReq("/api/user/", "POST", {
        email: email,
        password: password,
        username: username,
        admin: true
    })
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        alert("Success")
        redirect("/home.html");
        setCookie("username", username);
        setCookie("token", response.objects.token);
        setCookie("storeId", response.objects.store_id);
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
}