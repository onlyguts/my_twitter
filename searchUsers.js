let userArobase = [];

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        const response = JSON.parse(xhttp.responseText);
        userArobase = response.map(user => user.at_user_name);
        console.log(userArobase);
    }
};
xhttp.open("GET", "mysql/r_users.php", true);
xhttp.send();

const resultBoxUsers = document.querySelector(".boxResult");
const inputBoxUsers = document.getElementById("SearchUser");

inputBoxUsers.onkeyup = function () {
    let input = inputBoxUsers.value;

    if (input.startsWith('@')) {
        let searchArobase = input.indexOf('@');
        let arobase = input.substring(searchArobase);
        console.log(arobase);

        if (arobase.startsWith('@')) {
            console.log('oui3')
            let result = [];

            if (arobase.length) {
                result = userArobase.filter((keyword) => {
                    return keyword.toLowerCase().includes(arobase.toLowerCase())
                });
                console.log(result);
            }
            displayUser(result);
        }

    } else if (input.includes('@')) {
        let searchArobase = input.indexOf('@');
        let arobase = input.substring(searchArobase);
        console.log(arobase);

        if (arobase.startsWith('@')) {
            console.log('oui4')
            let result = [];

            if (arobase.length) {
                result = userArobase.filter((keyword) => {
                    return keyword.toLowerCase().includes(arobase.toLowerCase())
                });
                console.log(result);
            }
            displayUser(result);
        }

    } else {
        resultBoxUsers.innerHTML = "";
    }
}

function displayUser(result) {
    let input = inputBoxUsers.value;
    if (input.startsWith('@') || input.includes('@')) {
        const content = result.map((list) => {
            return "<li onclick=headerUser(this)>" + list + "</li>";
        }).join('');

        resultBoxUsers.innerHTML = "<ul>" + content + "</ul>";
    } else {
        resultBoxUsers.innerHTML = "";
    }
}

function headerUser(list) {
        var user = list.innerHTML;
        window.location.href = "Utilisateur/user_profil.php?id_user=" + encodeURIComponent(user);
}
