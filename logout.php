<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['role']);
session_unset();
session_destroy();
		echo '<script>document.location.href="login";</script>'
?>  