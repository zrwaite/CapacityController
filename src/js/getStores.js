var pullInfo = new XMLHttpRequest();
pullInfo.onload = function() {
    var stores = JSON.parse(this.responseText);
    var storeList = document.getElementById("storeList");
    for (i=0; i<stores.length; i++){
        /*
        var img = document.createElement("img");
        img.src = '../files/images/'+allInfo[i]['image_file_name'];
        img.className = "productImage"
        var namePrice = document.createElement("h5");
        namePrice.appendChild(document.createTextNode(allInfo[i]['name']+":  $"+allInfo[i]['price']));
        var description = document.createElement("p");
        description.appendChild(document.createTextNode(allInfo[i]['description']));
        var item = document.createElement("a");
        item.className="item";
        item.href="product.php?product="+allInfo[i]['id'];
        item.appendChild(img);
        item.appendChild(namePrice);
        item.appendChild(description);
        storeList.appendChild(item);
        */
    }
};
pullInfo.open("get", "../src/php/getStores.php", true);
pullInfo.send();
