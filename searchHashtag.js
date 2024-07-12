let hashtagName = []

var xhttpHashtag = new XMLHttpRequest();
xhttpHashtag.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        const responseHashtag = JSON.parse(xhttpHashtag.responseText);
        hashtagName = responseHashtag.map(hashtag_list => hashtag_list.hashtag);
        console.log(hashtagName);
    }
};
xhttpHashtag.open("GET", "mysql/fetch_hashtag.php", true);
xhttpHashtag.send();

const resultBoxHashtag = document.querySelector(".box-result");
const inputBoxHashtag = document.getElementById("SearchHashtag");

inputBoxHashtag.onkeyup = function () {
    let inputSearch = inputBoxHashtag.value;

    if (inputSearch.startsWith('#')) {
        let searchHashtag = inputSearch.indexOf('#');
        let hashtag = inputSearch.substring(searchHashtag);
        console.log(hashtag);

        if (hashtag.startsWith('#')) {
            console.log('oui1')
            let result = [];
            hashtag = hashtag.replace("#", "")

            if (hashtag.length) {
                result = hashtagName.filter((keyword) => {
                    return keyword.toLowerCase().includes(hashtag.toLowerCase())
                });
                console.log(result);
            }
            displayHashtag(result);
        }

    } else if (inputSearch.includes('#')) {
        let searchHashtag = inputSearch.indexOf('#');
        let hashtag = inputSearch.substring(searchHashtag);
        console.log(hashtag);

        if (hashtag.startsWith('#')) {
            console.log('oui2')
            let result = [];
            hashtag = hashtag.replace("#", "")

            if (hashtag.length) {
                result = hashtagName.filter((keyword) => {
                    return keyword.toLowerCase().includes(hashtag.toLowerCase())
                });
                console.log(result);
            }
            displayHashtag(result);
        }

    } else {
        resultBoxHashtag.innerHTML = "";
    }
}

function displayHashtag(result) {
    let inputSearch = inputBoxHashtag.value;

    if (inputSearch.startsWith('#') || inputSearch.includes('#')) {
        const content = result.map((list) => {
            return "<li onclick=headerHashtag(this)> #" + list + "</li>";
        }).join('');

        resultBoxHashtag.innerHTML = "<ul>" + content + "</ul>";
    } else {
        resultBoxHashtag.innerHTML = "";
    }
}

function headerHashtag(list) {
    var hashtag = list.innerHTML.substring(1);
    hashtag = hashtag.replace("#", '');
    window.location.href = "tweet/hashtag.php?hashtag=" + hashtag;
}