console.log('xfil loadeded...');
console.log(document.cookie);
console.log(window);
console.log(XFIL);
function reqListener () {
    console.log(this.responseText);
}
if (XFIL.xfil_ids.length > 0){
    console.log('reporting sale');
    var oReq = new XMLHttpRequest();
    oReq.addEventListener("load", reqListener);
    oReq.open("POST", XFIL.backend);
    oReq.setRequestHeader("Content-type", "application/json");
    oReq.withCredentials = true;
    oReq.send(JSON.stringify(XFIL));
    console.log("done");
}


