function search_user() {
    let input = document.getElementById('searchUser').value
    input = input.toLowerCase();
    let x = document.getElementsByClassName('membres');

    for (i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display = "none";
        } else {
            x[i].style.display = "list-item";
        }
    }
}

function search_conv() {
    let input = document.getElementById('searchUserConv').value
    input = input.toLowerCase();
    let x = document.getElementsByClassName('messages');

    for (i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display = "none";
        } else {
            x[i].style.display = "list-item";
        }
    }
}

function togglePopup() {
    let popup = document.querySelector('#popup-overlay');
    popup.classList.toggle("open");
}