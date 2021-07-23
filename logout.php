<?php
session_start();
$_SESSION = [];     // jaga2
session_unset();    // jaga2 jika session tidak hilang
session_destroy();

// hapus cookie
setcookie("id", "", time() - 3600); // kosongkan nilai id dan mundurkan waktu
setcookie("key", "", time() - 3600); // kosongkan nilai id dan mundurkan waktu

echo    "<script>
            alert('Berhasil Logout!');
             document.location.href = 'index.php';
         </script>";

// header("Location: index.php");
exit;
?>