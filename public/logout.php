<?php
session_start();
session_destroy();

print_r(json_encode([
    "redirect"=>"login.php"
]));
exit();
?>