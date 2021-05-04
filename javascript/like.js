let allLikeButtons =document.querySelectorAll('.like');
//let likeButtons = allLikeButtons.length;
   // let btn = document.querySelector('.like');


for(i=0; i<allLikeButtons.length; i++){
    allLikeButtons[i].addEventListener("click", setLike)
}
function setLike (e) {
    let btn_value =e.target.src;
   // let btn_value = btn.src ;
    let userId = this.dataset.userid;
    let postId = this.dataset.postid;
    let formData = new FormData();
   // console.log("clicked");
    formData.append('userId', userId);
    formData.append('postId', postId);
    if(e.target.src=="http://localhost/php-project/php-eindbaas-groep2/assets/icons/redIcons/type=heart,%20state=selected.svg"){
        e.target.src = "./assets/icons/blackIcons/type=heart, state=Default.svg";
        btn_value = "unlike";
        //formData.append('btn_value', "unlike");
         //console.log('Unlike');
       }else{
        e.target.src = "./assets/icons/redIcons/type=heart, state=selected.svg";
         btn_value = "like";
         // formData.append('btn_value', "like");
          // console.log('like');
          // console.log(btn.src);
       }
      // console.log(btn.src);
       //console.log(btn_value);
     
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

//console.log(clicked);