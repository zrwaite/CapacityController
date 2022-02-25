const getUser = async () => {
    let username = getCookie("username");
    if (!username) return false;
    let json = await httpReq("/api/user/?username="+username)
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        setCookie("storeId", response.objects.store_id);
        return response.objects;
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
    return false;
}
const getStore = async () => {
    let storeId = getCookie("storeId");
    if (!storeId) return false;
    let json = await httpReq("/api/store?id="+storeId);
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        return response.objects;
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
    return false;
}