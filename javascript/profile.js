// kijk na of er op de follower button geklikt wordt
document.querySelector('.btn').addEventListener("click", function () {
    //neem de waarden van de follower button
    let btn = document.querySelector('.btn');
    let btn_value = btn.innerHTML;
    let userId = this.dataset.userid;
    let followerId = this.dataset.followerid;

    //maak nieuwe formdata aan en geef de waarden van de button hier aan mee
    let formData = new FormData();
    formData.append('btn_value', btn_value);
    formData.append('userId', userId);
    formData.append('followerId', followerId);

    //voer het fetch request uit/geef de fomdata mee aan de Profile classe
    fetch('./ajax/profile.php', {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            console.log("succes", result);
            //kijk welke waarde de follower button heeft (waarde gemaakt aan de hand van de db) en zet de tegengestelde waarde op de button
            if (btn_value === 'follow') {
                btn.innerHTML = 'Unfollow'
                console.log('Unfollow');
            } else {
                btn.innerHTML = 'follow'
                console.log('follow');
            }
        })
        .catch(error => {
            console.error('error', error);
        });
})