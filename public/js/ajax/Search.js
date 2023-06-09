function SearchAjax(Element,APIUrl,ResultDiv,XCSRFTOKEN){
    const XHR = new XMLHttpRequest()
    let Form = new FormData
    Form.append('data', Element)
    XHR.onreadystatechange = function (){
        if (XHR.DONE === XMLHttpRequest.DONE){
            let resultDiv = document.getElementById(ResultDiv)
            resultDiv.innerHTML = XHR.responseText
        }
    }
    XHR.open('POST', APIUrl)
    XHR.setRequestHeader('X-CSRF-TOKEN',XCSRFTOKEN)
    XHR.setRequestHeader('X-Requested-With','XMLHttpRequest')
    XHR.send(Form)
}
