const ajax = new XMLHttpRequest();

function processText(event) {
    event.preventDefault();
    const vendor = document.getElementById("vendor").value;
    const url = "vendor.php?vendor=" + vendor;
    
    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE) {
            if (ajax.status === 200) {
                document.getElementById("tableBody").innerHTML = ajax.response;
            } else {
                console.error("error: " + ajax.status);
            }
        }
    };

    ajax.open("GET", url, true);
    ajax.send();
}

function processJson(event) {
    event.preventDefault();
    const category = document.getElementById("category").value;
    const url = "category.php?category=" + category;

    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE) {
            if (ajax.status === 200) {
                const data = JSON.parse(ajax.responseText);
                let trs = "";
                for (const item of data) {
                    trs += `<tr><td>${item.name}</td>`;
                    trs += `<td>${item.price}</td>`;
                    trs += `<td>${item.quantity}</td>`;
                    trs += `<td>${item.quality}</td>`;
                    trs += `<td>${item.vendor}</td>`;
                    trs += `<td>${item.category}</td></tr>`;
                }

                document.getElementById("tableBody").innerHTML = trs;
            } else {
                console.error("error: " + ajax.status);
            }
        }
    };

    ajax.open("GET", url, true);
    ajax.send();
}

function processXML(event) {
    event.preventDefault();
    const minPrice = document.getElementById("minPrice").value;
    const maxPrice = document.getElementById("maxPrice").value;
    const url = "price.php?minPrice=" + minPrice + "&maxPrice=" + maxPrice;

    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE) {
            if (ajax.status === 200) {
                const xmlDoc = ajax.responseXML;

                const items = xmlDoc.getElementsByTagName("item");
                let trs = "";

                for (let i = 0; i < items.length; i++) {
                    const item = items[i];
                    const name = item.getElementsByTagName("name")[0].textContent;
                    const price = item.getElementsByTagName("price")[0].textContent;
                    const quantity = item.getElementsByTagName("quantity")[0].textContent;
                    const quality = item.getElementsByTagName("quality")[0].textContent;
                    const vendor = item.getElementsByTagName("vendor")[0].textContent;
                    const category = item.getElementsByTagName("category")[0].textContent;

                    const row = `
                        <tr>
                            <td>${name}</td>
                            <td>${price}</td>
                            <td>${quantity}</td>
                            <td>${quality}</td>
                            <td>${vendor}</td>
                            <td>${category}</td>
                        </tr>
                    `;
                    trs += row;
                }

                document.getElementById("tableBody").innerHTML = trs;
            } else {
                console.error("error: " + ajax.status);
            }
        }
    };

    ajax.open("GET", url, true);
    ajax.send();
}
