<header>
    <div class="container-fluid block">
        <div class="logo">
            <a href="/">
                FORUM
            </a>
        </div>
        <div class="menu">
            <?php echo empty($_SESSION) ? '<div onclick="window.location.href = \'/user/login/\'"><i class="fas fa-sign-in-alt"></i> <span>SIGN IN</span></div>' : '' ?>
            <?php echo !empty($_SESSION) ? '<div onclick="window.location.href = \'/user/profile/\'"><i class="fas fa-user-circle"></i> <span>PROFILE</span></div>' : '' ?>
            <?php echo !empty($_SESSION) ? '<div onclick="window.location.href = \'/user/logout/\'"><i class="fas fa-sign-out-alt"></i> <span>LOGOUT</span></div>' : '' ?>
            <div></div>
            <div></div>
<!--            <div onclick="showFilter()"><i class="fas fa-filter"></i> <span>FILTER</span></div>-->
        </div>

<!--        <div class="filter">-->
<!--            <div>-->
<!--                <div class="mini-filters">-->
<!--                    <span><i class="far fa-heart"></i> <i class="fas fa-level-up-alt"></i></span>-->
<!--                    <span><i class="far fa-heart"></i> <i class="fas fa-level-down-alt"></i></span>-->
<!--                    <div></div>-->
<!--                    <span><i class="far fa-eye"></i> <i class="fas fa-level-up-alt"></i></span>-->
<!--                    <span><i class="far fa-eye"></i> <i class="fas fa-level-down-alt"></i></span>-->
<!--                    <div></div>-->
<!--                    <span><i class="fas fa-users"></i> <i class="fas fa-level-up-alt"></i></span>-->
<!--                    <span><i class="fas fa-users"></i> <i class="fas fa-level-down-alt"></i></span>-->
<!--                </div>-->
<!--                <div class="filter-by-tags">-->
<!--                    <div class="input-block">-->
<!--                        <i class="fas fa-hashtag"></i>-->
<!--                        <div class="dropdown" >-->
<!--                            <input class="dropbtn" onclick="myFunction()" type="text" id="hash-tags-filter" placeholder="SPORT, MUSIC ... ">-->
<!--                            <div id="myDropdown" class="dropdown-content">-->
<!--                                <a href="#">Link 1</a>-->
<!--                                <a href="#">Link 2</a>-->
<!--                                <a href="#">Link 3</a>-->
<!--                                <a href="#">Link 1</a>-->
<!--                                <a href="#">Link 2</a>-->
<!--                                <a href="#">Link 3</a>-->
<!--                                <a href="#">Link 1</a>-->
<!--                                <a href="#">Link 2</a>-->
<!--                                <a href="#">Link 3</a>-->
<!--                                <a href="#">Link 1</a>-->
<!--                                <a href="#">Link 2</a>-->
<!--                                <a href="#">Link 3</a>-->
<!--                                <a href="#">Link 1</a>-->
<!--                                <a href="#">Link 2</a>-->
<!--                                <a href="#">Link 3</a>-->
<!--                                <a href="#">Link 1</a>-->
<!--                                <a href="#">Link 2</a>-->
<!--                                <a href="#">Link 3</a>-->
<!--                                <a href="#">Link 1</a>-->
<!--                                <a href="#">Link 2</a>-->
<!--                                <a href="#">Link 3</a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="chips-block">-->
<!--                        <div>SPORT <i class="fas fa-times"></i></div>-->
<!--                        <div>SPORT 2 <i class="fas fa-times"></i></div>-->
<!--                        <div>2 <i class="fas fa-times"></i></div>-->
<!--                        <div>SPORT <i class="fas fa-times"></i></div>-->
<!--                        <div>SPORT <i class="fas fa-times"></i></div>-->
<!--                        <div>SPORT <i class="fas fa-times"></i></div>-->
<!--                        <div>SPORT <i class="fas fa-times"></i></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="input-block">-->
<!--                    <i class="fas fa-user-alt"></i>-->
<!--                    <input type="text" placeholder="Author name ... ">-->
<!--                </div>-->
<!--                <button class="search-button">SHOW [found: 122111]</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</header>

<script>
    let filterActive = true;

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }

    function showFilter() {
        if (filterActive) {
            $('.filter').css('visibility', 'visible');
            filterActive = false;
        } else {
            $('.filter').css('visibility', 'hidden');
            filterActive = true;
        }
    }
</script>