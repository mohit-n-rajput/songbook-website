<div id="navBarContainer">
    <nav class="navBar">
        <!-- tabindex=0 means if user press tab then it will not goes on other nav items. -->
        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="/songbook/assets/images/logo/songbook.png" alt="logo">
        </span>

        <div class="group">
            <div class="navItem">
                <span role='link' tabindex='0' onclick="openPage('search.php')" class="navItemLink">Search
                    <img src="/songbook/assets/images/icons/search.png" class="icon" alt="search">
               </span>
            </div>
        </div>
        <div class="group">
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
            </div>
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Your Music</span>
            </div>
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
            </div>

            <div>
                <span id="copyright">&copy;2018 Songbook</span>
            </div>
        </div>

    </nav>

</div>

