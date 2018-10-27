<?php
$con = mysqli_connect("localhost", "root", "", "techfest_db") or die("Connection failure");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$duration =60;
