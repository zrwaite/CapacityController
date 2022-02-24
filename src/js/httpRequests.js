const backendBaseURL = "http://localhost/capacitycontroller/backend";
const frontendBaseURL = "http://localhost/capacitycontroller";
const redirect = (subURL) => {
    window.location.assign(frontendBaseURL+subURL);
}
const imagePostReq = async (url, image, email) => {
    url = baseURL + url;
    try {
        let body = new FormData();
        body.append('image', image);
        body.append('email', email);
        body.append('submit', true);
        let response = await fetch(url, {
            method: 'POST',
            body: body
        })
        const data = await response.json();
        if (!response.ok) {
            return Promise.resolve(JSON.stringify(data));
        }
        return Promise.resolve(JSON.stringify(data));
    } catch (error) {
        console.error(error);
        return Promise.reject(JSON.stringify(error));
    }
}

const httpReq = async (url, method = "GET", params = {}) => {
    url = backendBaseURL + url;
    if (method !== "GET" && method !== "POST" && method !== "PUT" && method !== "DELETE") {
        console.error("invalid method");
        return false;
    }
    try {
        let response;
        if (method === "GET") {
            response = await fetch(url, {cache: 'no-cache'});
        } else {
            response = await fetch(url, {
                method: method, // *GET, POST, PUT, DELETE, etc.
                cache: 'no-cache',
                // mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(params) // body data type must match "Content-Type" header
            });
        }
        const data = await response.json();
        if (!response.ok) {
            return Promise.resolve(JSON.stringify(data));
        }
        return Promise.resolve(JSON.stringify(data));
    } catch (error) {
        console.error("HTTP Req error:", error);
        return Promise.reject(JSON.stringify(error));
    }
}