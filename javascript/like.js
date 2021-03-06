let numberOfLikes = document.querySelectorAll('.countLikes');
let allLikeButtons = document.querySelectorAll('.like');

for (i = 0; i < allLikeButtons.length; i++) {
    allLikeButtons[i].addEventListener("click", setLike)
}

function setLike(e) {
    let btn_value = e.target.src;
    let userId = this.dataset.userid;
    let postId = this.dataset.postid;
    let counter = e.path[0].attributes[2].nodeValue;
    let currentSpan = numberOfLikes[parseInt(counter)];
    
    let formData = new FormData();
console.log(e.target.src);
    if (e.target.src == "http://bbchaacht.be/phpFluppe/assets/icons/redIcons/type=heart,%20state=selected.svg") {
                        //http://bbchaacht.be/php/php-eindbaas-groep2/assets/icons/redIcons/type=heart,%20state=selected.svg
        e.target.src = "./assets/icons/blackIcons/type=heart,%20state=Default.svg";
       // console.log(e.target.src);
        btn_value = "unlike";
        

    } else {
        e.target.src = "./assets/icons/redIcons/type=heart,%20state=selected.svg";
        btn_value = "like";
        
    }
    formData.append('userId', userId);
    formData.append('postId', postId);
    formData.append('btn_value', btn_value);
    
    fetch('ajax/like.php', {
            method: "POST",
            body: formData
        })

        .then(response => response.json())
        .then(result => {
            let countLike = currentSpan.innerText;
            if (result['btn_state'] == "like") {
                countLike++;
            } else {
                countLike--;
            }
            currentSpan.innerHTML = countLike;
        })
        .catch(error => {
            console.error('error', error);

        });

}