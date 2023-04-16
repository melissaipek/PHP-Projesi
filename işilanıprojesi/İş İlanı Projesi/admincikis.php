<?php
// session oturumunu başlattık, bu işemi her oturum açmak istediğimiz php dosyasnda yapıyoruz  
session_start();

// tüm sessionları siliyoruz
session_destroy();

// tekrar oturum açmak için index.php dosyasına yönlediriyoruz

header("Location:admingiris.php?sonuc=cikis");

exit;
?>