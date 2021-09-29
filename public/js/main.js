function getBinance(url){
    let request = new XMLHttpRequest();
    request.open("get", url, false);
    request.send();

    return request.responseText;
}

function main(coin) {
    getPrice = getBinance("https://api.binance.com/api/v3/ticker/price?symbol="+ coin + "BRL");
    console.log(getPrice);
}

