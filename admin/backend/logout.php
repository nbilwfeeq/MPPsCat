<?php

session_start();
session_destroy();
header("Location: ../loading-page.php?target=index.php?status=loggedOut");

?>