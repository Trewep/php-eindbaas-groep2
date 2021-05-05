let allLikeButtons = document.querySelectorAll('.like');

for (i = 0; i < allLikeButtons.length; i++) {
    allLikeButtons[i].addEventListener("click", setLike)
}

function setLike(e) {
    let btn_value = e.target.src;
    let userId = this.dataset.userid;
    let postId = this.dataset.postid;
   // let numberOfLikes = document.querySelector('.countLikes').innerHTML;
    //console_log(numberOfLikes)
    let formData = new FormData();

    formData.append('userId', userId);
    formData.append('postId', postId);

    if (e.target.src == "http://localhost/php-project/php-eindbaas-groep2/assets/icons/redIcons/type=heart,%20state=selected.svg") {
        e.target.src = "./assets/icons/blackIcons/type=heart, state=Default.svg";
        btn_value = "unlike";
        //numberOfLikes--;

    } else {
        e.target.src = "./assets/icons/redIcons/type=heart, state=selected.svg";
        btn_value = "like";
        //numberOfLikes++;
    }
    formData.append('btn_value', btn_value);

    fetch('ajax/like.php', {
            method: "POST",
            body: formData
        })

        .then(response => response.json())
        .then(result => {

        })
        .catch(error => {
            console.error('error', error);

        });

};