<h1>Logout</h1>

<?php
session_start();
session_destroy();
header("Location:". "login.php");





