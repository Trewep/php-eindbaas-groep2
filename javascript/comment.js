let allCommentButtons = document.getElementsByClassName("btnAddComment");

for (i=0; i<allCommentButtons.length; i++) {
    allCommentButtons[i].addEventListener("click", addComment);
}

function addComment(e) {
    console.log(e.path);
    e.preventDefault();
    
    //Variabelen
    let postId = this.dataset.postid;
    let comment = e.path[1].children[0].value;
    let userId;
    let time;
    let currentCommentWrapper = e.path[3].children[2];

    //Post naar de databank sturen door middel van AJAX
    let formData = new FormData();
    formData.append('comment', comment);
    formData.append('postId', postId);
    formData.append('userId', userId);
    formData.append('time', time);

    fetch('ajax/saveComment.php', {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            //HTML elementen aanmaken, klasses en id's geven, parents aan children linken, innerHTML aanpassen, ...
            let newContainer = document.createElement("div");
            newContainer.classList.add("comment");
            //newContainer.setAttribute("id","commentContainer");
            newContainer.classList.add("commentContainer");
            
            let newUserContainer = document.createElement("p");
            //newUserContainer.setAttribute("id","newUserContainer");
            newUserContainer.classList.add("newUserContainer");
            newContainer.appendChild(newUserContainer);
                
            //console.log(newContainer);
            
            let newUser = document.createElement("a");
            newUser.classList.add("feedLink");
            newUser.classList.add("commentName");
            newUser.setAttribute("href","profile.php?id=" + result.userId);
            newUser.innerHTML = "@" + result.user;
            newUserContainer.appendChild(newUser);
                
            let newComment = document.createElement("p");
            newComment.innerHTML = result.body;
            newContainer.appendChild(newComment);
                
            let newTime = document.createElement("p");
            newTime.classList.add("time");
            newTime.innerHTML = result.time;
            newContainer.appendChild(newTime);
                
            currentCommentWrapper
                .prepend(newContainer);
                
            //input veld leegmaken
            e.path[1].children[0].value = "";
    })
        .catch(error => {
        console.error('Error:', error);
    });

    //Als er een antwoord komt, tonen we de comment onderaan
}