
<?php
session_start();
session_destroy();
header("Location: /RecoltePure/index.php?page=login");
exit;
?>