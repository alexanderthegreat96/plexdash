<?php
include "class.movietrailer.php";
new MovieTrailer(@$_GET['movie'], @$_GET['year']);
?>