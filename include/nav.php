<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Session Handling</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <?php
            // wenn Session personalisiert
            if ($username) {
                echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';

            }
            // wenn Session nicht personalisiert
            else {
                echo '<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>