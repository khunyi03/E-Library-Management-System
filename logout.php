<?php
session_start();
session_destroy();
header('Location: Final Project.php?logout=1');
exit();
