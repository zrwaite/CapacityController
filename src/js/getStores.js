$(document).ready(function(){
    var pullInfo = new XMLHttpRequest();
    pullInfo.onload = function() {
        var stores = JSON.parse(this.responseText);
        var storeList = document.getElementById("storeList");
        for (i=0; i<stores.length; i++){
            
            var titleLogo = document.createElement("img");
            titleLogo.src = 'files/images/'+stores[i]['image_link'];
            titleLogo.className = "titleLogo";
            var titleName = document.createElement("h3");
            titleName.appendChild(document.createTextNode(stores[i]['business_name']));
            titleName.className = "titleName";
            var title = document.createElement("div");
            title.className = "title";
            title.appendChild(titleLogo);
            title.appendChild(titleName);

            var address = document.createElement("p");
            address.className = "address";
            address.appendChild(document.createTextNode(stores[i]['store_address']));
            var hours = document.createElement("p");
            hours.className = "hours";
            hours.appendChild(document.createTextNode(stores[i]['store_hours']));
            var phone = document.createElement("p");
            phone.className = "phone";
            phone.appendChild(document.createTextNode(stores[i]['phone']));
            var description = document.createElement("div");
            description.className = "description";
            description.appendChild(address);
            description.appendChild(hours);
            description.appendChild(phone);

            var actualPercent = Math.round(100*parseInt(stores[i]['actual_capacity'])/parseInt(stores[i]['current_capacity']))+"%";
            var busyPercent = Math.round(100*parseInt(stores[i]['actual_capacity'])/parseInt(stores[i]['max_capacity']))+"%";

            var availability = document.createElement("h4");
            availability.className = "availability";
            availability.appendChild(document.createTextNode(actualPercent));
            var fullness = document.createElement("h4");
            fullness.className = "fullness";
            fullness.appendChild(document.createTextNode(busyPercent));
            var updateInfo = document.createElement("p");
            updateInfo.className = "updateInfo";
            updateInfo.appendChild(document.createTextNode("Last Updated:"));
            var updateTime = document.createElement("p");
            updateTime.className = "updateTime";
            updateTime.appendChild(document.createTextNode("1 min ago"));
            var capacity = document.createElement("div");
            capacity.className = "capacity";
            capacity.appendChild(availability);
            capacity.appendChild(fullness);
            capacity.appendChild(updateInfo);
            capacity.appendChild(updateTime);
            var store = document.createElement("div");
            store.className = "store";
            store.appendChild(title);
            store.appendChild(description);
            store.appendChild(capacity);

            storeList.appendChild(store);
            
        }
    };
    pullInfo.open("get", "src/php/getStores.php", true);
    pullInfo.send();
});