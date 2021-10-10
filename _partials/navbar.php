<div class="nav-menu-content">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-dark-gray custom-navbar pad-15">
        <div class="container">
            <a class="navbar-brand" href="<?= $domain; ?>"><img src="<?= $domain; ?>/assets/img/logo.png" draggable="false"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <?php
            if (!isset($_SESSION['loggedin'])) {
                session_start();
            ?>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $domain; ?>/#index">Home <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $domain; ?>/team">Team</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Content
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?= $domain; ?>/studentarea/courses/">GCSE Topics</a>
                                <a class="dropdown-item" href="<?= $domain; ?>/studentarea/#">Interactive Lessons</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link login" href="<?= $domain; ?>/studentarea/">Login or Signup</a>
                        </li>
                    </ul>
                </div>
            <?php
            } else {
            ?>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $domain; ?>/studentarea/">Dashboard<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $domain; ?>/studentarea/courses/">Courses</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= getData("accounts", "username", "id", $id) ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?= $domain; ?>/studentarea/profile"> Account Settings</a>
                                <a class="dropdown-item" href="<?= $domain; ?>/studentarea/statistics/profile/<?= getData("accounts", "username", "id", $id) ?>"> My Statistics</a>
                            </div>
                        </li>
                        <?php
                        if (determineAccountType($type) == "Administrator" || determineAccountType($type) == "Teacher") {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Switch
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php
                                    if (determineAccountType($type) == "Administrator") {
                                    ?>
                                        <a class="dropdown-item" href="<?= $domain; ?>/secure/adminarea/"><i class="fas fa-external-link-alt"></i> Admin Dashboard</a>
                                    <?php
                                    }
                                    ?>
                                    <a class="dropdown-item" href="<?= $domain; ?>/secure/teacherarea/"><i class="fas fa-external-link-alt"></i> Teacher Dashboard</a>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link login" href="<?= $domain; ?>/studentarea/logout">Logout</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </nav>
</div>
<!-- JS here -->
<script src="<?= $domain; ?>/assets/js/vendor/jquery-3.2.1.min.js"></script>
<script src="<?= $domain; ?>/assets/js/popper.min.js"></script>
<script src="<?= $domain; ?>/assets/js/bootstrap.min.js"></script>

<style>
    .banner-question {
        background-image: url("<?= $domain ?>/assets/img/background.webp");
        background-size: cover;
        background-position: bottom;
        height: 300px;
        margin-top: 105px;
    }
</style>