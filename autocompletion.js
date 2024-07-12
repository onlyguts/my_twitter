let userName = [];

var xhttpUser = new XMLHttpRequest();
xhttpUser.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        const response = JSON.parse(xhttpUser.responseText);
        userName = response.map(user => user.at_user_name);
        console.log(userName);
    }
};
xhttpUser.open("GET", "mysql/r_users.php", true);
xhttpUser.send();


const resultBox = document.querySelector(".result-box");
const inputBox = document.getElementById("txtTweet");

inputBox.onkeyup = function () {
    let inputText = inputBox.value;
    if (inputText.startsWith('@')) {
        let searchArobase = inputText.indexOf('@');
        let arobase = inputText.substring(searchArobase);
        console.log(arobase);
        if (arobase.startsWith('@')) {
            console.log('oui3')
            let result = [];
            if (arobase.length) {
                result = userName.filter((keyword) => {
                    return keyword.toLowerCase().includes(arobase.toLowerCase())
                });
                console.log(result);

            }
            displayUser(result);


        }
    }
    else if (inputText.includes('@')) {
        let searchArobase = inputText.indexOf('@');
        let arobase = inputText.substring(searchArobase);
        console.log(arobase);
        if (arobase.startsWith('@')) {
            console.log('oui4')
            let result = [];
            if (arobase.length) {
                result = userName.filter((keyword) => {
                    return keyword.toLowerCase().includes(arobase.toLowerCase())
                });
                console.log(result);

            }
            displayUser(result);
        }
    }
    else {
        resultBox.innerHTML = "";
    }
}

function displayUser(result) {
    let inputText = inputBox.value;
    if (inputText.startsWith('@') || inputText.includes('@')) {
        const content = result.map((list) => {
            return "<li onclick=completeUser(this)>" + list + "</li>";
        }).join('');

        resultBox.innerHTML = "<ul>" + content + "</ul>";
    }
}


function completeUser(list) {
    inputBox.value = inputBox.value.replace("@", "") + list.innerHTML;
    resultBox.innerHTML = '';
}
