const tryLogin = async () => {
    let usernameInput = document.getElementById("username");
    let passwordInput = document.getElementById("pword");
    let username = usernameInput.value;
    let password = passwordInput.value;
    if (username===""||password==="") return;
    let json = await httpReq("/auth/signin.php/", "POST", {
        password: password,
        username: username,
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