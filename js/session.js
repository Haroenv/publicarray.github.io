function storeSession() {
    sessionStorage.name = document.getElementsByName('name')[0].value;
    sessionStorage.email = document.getElementsByName('email')[0].value;
    sessionStorage.subject = document.getElementsByName('subject')[0].value;
    sessionStorage.message = document.getElementsByName('message')[0].value;
}

function destroySession(doc) {
    if (doc.getElementById('send')) {
        sessionStorage.removeItem('name');
        sessionStorage.removeItem('email');
        sessionStorage.removeItem('subject');
        sessionStorage.removeItem('message');
        sessionStorage.clear();
    }
}

window.onload = (function loadSession() {
    var doc = document;

    destroySession(doc);

    if (sessionStorage.name !== undefined){
        doc.getElementsByName('name')[0].value = sessionStorage.name;
    }
    if (sessionStorage.email!== undefined){
        doc.getElementsByName('email')[0].value = sessionStorage.email;
    }
    if (sessionStorage.email !== undefined){
        doc.getElementsByName('email')[0].value = sessionStorage.email;
    }
    if (sessionStorage.message !== undefined){
        doc.getElementsByName('message')[0].value = sessionStorage.message;
    }

    doc = null;
})();
