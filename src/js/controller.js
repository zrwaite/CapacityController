const tryAdd = async () => {
    changeShoppers("add");

}
const tryRemove = async () => {
    changeShoppers("remove");
}
const changeShoppers = async (command) => {
    let storeId = getCookie("storeId");
    let json = await httpReq(`/api/shopper/`, "PUT", {
        command: command,
        number: 1,
        id:storeId
    })
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        loadController();
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
}
const loadController = async () => {
    let store = await getStore();
    document.getElementById("actualCapacity").innerText = store.num_shoppers;
    document.getElementById("maxCapSpan").innerText = store.actual_capacity;
    let capacityGraph = document.getElementById("capacityGraph");
    capacityGraph.value = store.num_shoppers;
    capacityGraph.max = store.actual_capacity;
    document.getElementById("capacityGraphSpan").innerText = 100*(store.num_shoppers/store.actual_capacity);
    document.getElementById("remainingCapacity").innerText = store.actual_capacity-store.num_shoppers;
    document.getElementById("usualCapacity").innerText = store.max_capacity;
}