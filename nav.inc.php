
        <!-- nav -->
        <div class="row no-gutters nav">
            <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                <a href="index.php"><img src="assets/icons/blackIcons/type=home, state=Default.svg" alt=""></a>
                <a href="index.php"><p>Feed</p></a>
            </div>
            <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                <a href="requests.php"><img src="assets/icons/blackIcons/type=notification, state=Default.svg" alt=""></a>
                <a href="requests.php"><p>Requests</p></a>
            </div>
            <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                <a href="profile.php?id=<?php echo htmlspecialchars($_SESSION["userId"])?>"><img src="assets/icons/blackIcons/type=person, state=Default.svg" alt=""></a>
                <a href="profile.php?id=<?php echo htmlspecialchars($_SESSION["userId"])?>"><p>Profile</p></a>
            </div>
        </div>
