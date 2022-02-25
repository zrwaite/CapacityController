const loadAdminPage = async() => {
    if (await getUser()){
        let storeId = getCookie("storeId")
        if (storeId && storeId.toString()!=="0") {
            let store = await getStore();
            document.getElementById("bname").value = store.name;
            document.getElementById("phone").value = store.phone;
            document.getElementById("hours").value = store.hours;
            document.getElementById("address").value = store.address;
            document.getElementById("maxCap").value = store.max_capacity;
            document.getElementById("currCap").value = store.actual_capacity;
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

const tryUpdateStore = async () => {
    let bname = document.getElementById("bname").value
    let phone = document.getElementById("phone").value
    let hours = document.getElementById("hours").value
    let address = document.getElementById("address").value
    let maxCap = document.getElementById("maxCap").value
    let currCap = document.getElementById("currCap").value
    let storeId = getCookie("storeId");
    if (!maxCap) {
        alert("maximum capacity needed");
        return false;
    }
    if (!currCap) {
        alert("covid capacity needed");
        return false
    }
    if (!storeId) {
        return false;
    }
    let json = await httpReq("/api/store/", "PUT", {
        "id": storeId,
        "name": bname,
        "max_capacity": maxCap,
        "actual_capacity": currCap,
        "hours": hours,
        "address": address,
        "phone": phone
    })
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        alert("updated");
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
}

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