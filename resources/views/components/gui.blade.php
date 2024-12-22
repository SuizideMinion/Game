<!-- Header Start -->
<header class="main-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ul class="d-flex justify-content-center nav-items">
                    <li>
                        <a href="#">
                            <span>achievements</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>chat</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>create character</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>inventory</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>levels</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>quests</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="ranking.html">
                            <span>ranking</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="settings.html">
                            <span>settings</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="shop.html" class="active">
                            <span>shop</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                    <li>
                        <a href="skills.html">
                            <span>skills</span>
                            <div class="b-t-l"></div>
                            <div class="b-t-l-t"></div>
                            <div class="b-t-r"></div>
                            <div class="b-t-r-t"></div>
                            <div class="b-b-l"></div>
                            <div class="b-b-l-b"></div>
                            <div class="b-b-r"></div>
                            <div class="b-b-r-b"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->

<!-- Main Start -->
<main>
    <!-- Page Alert Start -->
    <div class="page-alert position-relative">
        <p class="text-center">
            {{ $title }}
        </p>
        <div class="dismiss-btn">
            <button>
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
    <!-- Page Alert End -->

    {{ $slot }}
</main>
<!-- Main End -->
