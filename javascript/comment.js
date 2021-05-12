/*let allCommentButtons = document.querySelectorAll('.btnAddComment');

for (i = 0; i < allCommentButtons.length; i++) {
    allCommentButtons[i].addEventListener("click", addComment());
}

function addComment() {
    //Wat is de postID?
    let postId = this.dataset.postid;
    
    //Wat is de comment text?
    let text = document.querySelector("#commentText").value;

    //Post naar de databank sturen door middel van AJAX
    let formData = new FormData();
    formData.append('text', text);
    formData.append('postId', postId);

    fetch('ajax/saveComment.php', {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            let newComment = document.createElement("li");
            newComment.innerHTML = result.body;
            document
                .querySelector("#testcomment")
                .appendChild(newComment);
    })
        .catch(error => {
        console.error('Error:', error);
    });

    //Als er een antwoord komt, tonen we de comment onderaan
}*/

document.querySelector("#btnAddComment").addEventListener("click", function(e){
    e.preventDefault();
    
    //Variabelen
    let postId = this.dataset.postid;
    let text = document.querySelector("#commentText").value;

    //Post naar de databank sturen door middel van AJAX
    let formData = new FormData();
    formData.append('text', text);
    formData.append('postId', postId);

    fetch('ajax/saveComment.php', {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            let newComment = document.createElement("p");
            newComment.innerHTML = result.body;
            document
                .querySelector("#testcomment")
                .appendChild(newComment);
    })
        .catch(error => {
        console.error('Error:', error);
    });

    //Als er een antwoord komt, tonen we de comment onderaan
});