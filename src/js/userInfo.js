const getUser = async () => {
    let username = getCookie("username");
    if (!username) return false;
    let json = await httpReq("/api/user/?username="+username, "GET", )
    let response = JSON.parse(json);
    if (response.success && response.objects) {
        setCookie("storeId", response.objects.store_id);
        return true;
    } else if (response.errors.length > 0) {
        alert("Failure");
        alert(JSON.stringify(response.errors))
    }
    return false;
}