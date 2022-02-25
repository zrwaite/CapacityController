const loadStores = async () => {
    let json = await httpReq("/api/store/?page=" + 1);
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        console.log(response);
        let stores = response.objects;
        showStores(stores);
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
}
const searchStores = async () => {
    let storeName = document.getElementById("storeInput").value;
    if (storeName!=="") {
        let json = await httpReq("/api/store/?name=" + storeName);
        let response = JSON.parse(json);
        if (response.success && response.objects && response.status === 200) {
            console.log(response);
            let stores = response.objects;
            showStores(stores);
        } else if (response.status === 404) {
            let storeList = document.getElementById("storeList");
            storeList.innerHTML = "No Stores found";
        } else if (response.errors.length > 0) {
            alert("Failure");
            alert(JSON.stringify(response.errors))
        }
    } else {
        loadStores()
    }
}

const showStores = (stores) => {
    let storeList = document.getElementById("storeList");
    storeList.innerHTML = "";
    for (i = 0; i < stores.length; i++) {
        let titleLogo = document.createElement("img");
        titleLogo.src = 'files/images/' + stores[i]['image_link'];
        titleLogo.className = "titleLogo";
        let titleName = document.createElement("h3");
        titleName.appendChild(document.createTextNode(stores[i]['name']));
        titleName.className = "titleName";
        let title = document.createElement("div");
        title.className = "title";
        title.appendChild(titleLogo);
        title.appendChild(titleName);

        let address = document.createElement("p");
        address.className = "address";
        address.appendChild(document.createTextNode(stores[i]['address']));
        let hours = document.createElement("p");
        hours.className = "hours";
        hours.appendChild(document.createTextNode(stores[i]['hours']));
        let phone = document.createElement("p");
        phone.className = "phone";
        phone.appendChild(document.createTextNode(stores[i]['phone']));
        let description = document.createElement("div");
        description.className = "description";
        description.appendChild(address);
        description.appendChild(hours);
        description.appendChild(phone);

        let actualPercent = Math.round(100 * parseInt(stores[i]['num_shoppers']) / parseInt(stores[i]['actual_capacity'])) + "%";
        let busyPercent = Math.round(100 * parseInt(stores[i]['num_shoppers']) / parseInt(stores[i]['max_capacity'])) + "%";

        let availability = document.createElement("h4");
        availability.className = "availability";
        availability.appendChild(document.createTextNode(actualPercent));
        let fullness = document.createElement("h4");
        fullness.className = "fullness";
        fullness.appendChild(document.createTextNode(busyPercent));
        let updateInfo = document.createElement("p");
        updateInfo.className = "updateInfo";
        updateInfo.appendChild(document.createTextNode("Last Updated:"));
        let updateTime = document.createElement("p");
        updateTime.className = "updateTime";
        updateTime.appendChild(document.createTextNode("1 min ago"));
        let capacity = document.createElement("div");
        capacity.className = "capacity";
        capacity.appendChild(availability);
        capacity.appendChild(fullness);
        capacity.appendChild(updateInfo);
        capacity.appendChild(updateTime);
        let store = document.createElement("div");
        store.className = "store";
        store.appendChild(title);
        store.appendChild(description);
        store.appendChild(capacity);
        storeList.appendChild(store);
    }
}