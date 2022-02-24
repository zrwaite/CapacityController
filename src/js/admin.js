const loadAdminPage = async() => {
    if (await getUser()){
        let storeId = getCookie("storeId")
        if (storeId && storeId.toString()!=="0") {
            let json = await httpReq("/api/store/?id="+storeId, "GET", )
            let response = JSON.parse(json);
            if (response.success && response.objects) {
                console.log(response.objects);
                loadUsers(storeId);
            } else if (response.errors.length > 0) {
                alert("Failure");
                alert(JSON.stringify(response.errors))
            }
            document.getElementById("editor").style.display = "grid";
            document.getElementById("adder").style.display = "none";
            // return false;
        } else {
            document.getElementById("adder").style.display = "grid";
            document.getElementById("editor").style.display = "none";
        }
        document.getElementById("loading").style.display = "none";
    } else {
        console.log("user not found");
        alert("Not logged in");
        redirect("/home.html");
    }
}

const loadUsers = async(storeId) => {
    let json = await httpReq("/api/user/?store_id="+storeId, "GET", )
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        let userList = document.getElementById("userList");
        userList.innerHTML = "";
        for (let i=0; i<response.objects.length; i++){
            let userItem = document.createElement("li");
            userItem.innerText = response.objects[i].username
            userList.appendChild(userItem);
        }
        console.log(response.objects);
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
}

/*
<label for='new_bname'>Business Name *:</label>
          <input type='text' id='new_bname' name='new_bname' maxlength='80'>
          <label for='new_maxCap'>Maximum Capacity* :</label>
          <input type='number' id='new_maxCap' name='new_maxCap'>
          <label for='new_currCap'>Covid Capacity* :</label>
          <input type='number' id='new_currCap' name='new_currCap'>
          <label for='new_phone'>Phone Number:</label>
          <input type='text' id='new_phone' name='new_phone' maxlength='20'>
          <label for='new_email'>Public Email:</label>
          <input type='text' id='new_email' name='new_email' maxlength='20'>
          <label for='new_hours'>Hours:</label>
          <input type='text' id='new_hours' name='new_hours' maxlength='200'>
          <label for='new_bio'>Bio:</label>
          <input type='text' id='new_bio' name='new_bio' maxlength='200'>
          <label for='new_address'>Address:</label>
          <input type='text' id='new_address' name='new_address' maxlength='80'>
 */

const tryCreateStore = async () => {
    let bnameInput = document.getElementById("new_bname");
    let maxCapInput = document.getElementById("new_maxCap");
    let currCapInput = document.getElementById("new_currCap");
    let phoneInput = document.getElementById("new_phone");
    let emailInput = document.getElementById("new_email");
    let hoursInput = document.getElementById("new_hours");
    let bioInput = document.getElementById("new_bio");
    let addressInput = document.getElementById("new_address");
    let name = bnameInput.value;
    let maxCap = maxCapInput.value;
    let currCap = currCapInput.value;
    let phone = phoneInput.value;
    let email = emailInput.value;
    let hours = hoursInput.value;
    let bio = bioInput.value;
    let address = addressInput.value;
    let username = getCookie("username");

    if (name===""||maxCap===""||currCap===""||username==="") return;
    let postBody = {
        admin_username: username,
        name: name,
        max_capacity: maxCap,
        actual_capacity: currCap,
    }
    if (phone!=="") postBody["phone"] = phone;
    if (email!=="") postBody["public_email"] = email;
    if (hours!=="") postBody["hours"] = hours;
    if (bio!=="") postBody["bio"] = bio;
    if (address!=="") postBody["address"] = address;
    let json = await httpReq("/api/store/", "POST", postBody);
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        alert("Success")
        console.log(response);
        setCookie("storeId", response.objects.id);
        loadAdminPage();
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
}

const tryAddUser = async () => {
    let usernameInput = document.getElementById("username");
    let passwordInput = document.getElementById("pword");

    let password = passwordInput.value;
    let username = usernameInput.value;
    let storeId = getCookie("storeId");
    let json = await httpReq("/api/user/", "POST", {
        password: password,
        username: username,
        store_id: storeId,
        admin: false
    });
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        alert("Success")
        loadUsers(storeId);
        console.log(response);
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
}