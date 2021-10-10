<div class="nav-menu-content">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-dark-gray custom-navbar pad-15">
        <div class="container">
            <a class="navbar-brand" href="<?= $domain; ?>"><img src="<?= $domain; ?>/assets/img/logo.png" draggable="false"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $domain; ?>/secure/teacherarea/">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= $domain; ?>/secure/teacherarea/manage/myclasses">My Classes</a>
                            <a class="dropdown-item" href="<?= $domain; ?>/secure/teacherarea/manage/assignments">My Assignments</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-plus"></i> New
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= $domain; ?>/secure/teacherarea/new/assignment">Class Assignment</a>
                            <a class="dropdown-item" href="<?= $domain; ?>/secure/teacherarea/new/class">Create New Class</a>
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
                                <a class="dropdown-item" href="<?= $domain; ?>/studentarea"><i class="fas fa-external-link-alt"></i> Student Dashboard</a>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link login" href="<?= $domain; ?>/secure/teacherarea/logout">Logout</a>
                    </li>

                </ul>
            </div>
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