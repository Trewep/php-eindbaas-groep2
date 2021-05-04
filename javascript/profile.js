
document.querySelector('.btn').addEventListener("click", function () {
    let btn = document.querySelector('.btn');
    let btn_value = btn.innerHTML;
    let userId = this.dataset.userid;
    let followerId = this.dataset.followerid;




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

          

        })
        .catch(error => {
           console.error('error', error);

        });
        
        
      

        if(btn_value === 'follow'){
            btn.innerHTML = 'Unfollow'
            console.log('Unfollow');
        }else{
           btn.innerHTML = 'follow'
            console.log('follow');
        }

console.log(clicked);

})

console.log(clicked);
