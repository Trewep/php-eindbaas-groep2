document.querySelector('.btn').addEventListener("click", function () {
    let btn = document.querySelector('.btn');
    let btn_value = btn.innerHTML;
    let userId = this.dataset.userid;
    let followerId = this.dataset.followerid;
    let clicked = 1;

    /*console.log(btn_value);
    console.log(profileId);*/




    let formData = new FormData();
    formData.append('btn_value', btn_value);
    formData.append('userId', userId);
    formData.append('followerId', followerId);



    fetch('./ajax/profile.php', {
        method: "POST",
        body: formData

    })
    
        .then(response => response.json())
        .then(result => {

           /* let newComment = document.createElement('li');
            newComment.innerHTML = result.body;
            document.querySelector('.post__comments__list')
                .appendChild(newComment);*/
                console.log("succes", result);

        })
        .catch(error => {
           console.error('error', error);

        });


        if(clicked === 1){
            btn.innerHTML = 'Unfollow'
            console.log('Unfollow')
        }else{
            console.log('follow');
        }



})