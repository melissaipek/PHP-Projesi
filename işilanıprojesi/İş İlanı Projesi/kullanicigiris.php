 <?php 
// session oturumunu başlattık, bu işemi her oturum açmak istediğimiz php dosyasnda yapıyoruz
session_start();
include("baglanti.php");
?> 

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Giriş Yap</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<?php

	// session kontrolü yaparak eğer kullanıcı giriş yapmamışsa giriş formunu, giriş yapmışsa panel ekranını gösteriyoruz

	// isset() fonksiyonu değişken tanımlı mı diye bakar

	if (!isset ($_SESSION['kullaniciAdi'])) { ?>

		<center>
			<hr>
			|<a href="index.php">Ana Sayfa</a> | <a href="admingiris.php">İşveren Girişi</a>|
			<hr>
			<h2>Başvuru Girişi</h2>
			<form action="kullanicigiris.php" method="POST">
				<label for="kullaniciAdi">Kullanıcı Adı: </label>
				<input type="text" name="kullaniciAdi" id="kullaniciAdi">
				<label for="kullaniciParola">Parola:</label>
				<input type="password" name="kullaniciParola" id="kullaniciParola">
				<input type="submit" name="kullaniciGiris" value="Giriş Yap">
			</form>
			<br>
			<hr>

			<?php 
			// İlk olarak form kontrolü yapıyoruz
			if (isset($_POST['kullaniciGiris'])) {

    			// formdan gelen verileri karşılaştırıyoruz. tanımladığımız giriş bilgileri doğrumu kontrol ediyoruz
				if ($_POST['kullaniciAdi']=="kullanici" && $_POST['kullaniciParola']=="123") {

        			//Giriş bilgileri doğruysa session atama işlemleri yapıyoruz
					$_SESSION['kullaniciAdi']=$_POST['kullaniciAdi'];
					$_SESSION['kullaniciParola']=$_POST['kullaniciParola'];

    				// Yönlendirme işlemi yapıyoruz. İşlem sonucunu takip için durum GET değişkenini tanımlıyoruz(index sayfası)
					header("Location:kullanicigiris.php?sonuc=#");
					exit;
				}
				else{
    				// İşlem başarısız olduğu zaman işlem sonucunu takip için durum GET değişkeni tanımlıyoruz(index de)
					header("Location:kullanicigiris.php?sonuc=no");
					exit;
				}
			}



			// İşlemlerden GET değeri döndürüyoruz. Bu sayede işlem durumunu takip edebiliyoruz
			// 2. Kısım
			if ($_GET['sonuc']=="no") {
				echo "<br>";

				echo "Kullanıcı adı veya parola yanlış girilmiştir!";
				header("Refresh: 5; url=http://localhost/%c4%b0%c5%9f%20%c4%b0lan%c4%b1%20Projesi/kullanicigiris.php");
				


			}
			else if ($_GET['sonuc']=="cikis") {
				echo "<br>";

				echo "Çıkış işlemi başarıyla yapıldı!";

				header("Refresh: 5; url=http://localhost/%c4%b0%c5%9f%20%c4%b0lan%c4%b1%20Projesi/kullanicigiris.php");
			}
		}
		else{
			?>
			<center>
				<hr>
				|<a href="index.php">Ana Sayfa</a> | <a href="admingiris.php">İşveren Girişi</a>|
				<hr>
				<h2>Başvuru Paneli</h2>

				<form action="kullanicigiris.php" method="post">
					<label for="kSorgu">Cevapları görüntülemek için göster butonuna tıklayınız</label>

					<br>

					<input type="submit" value="Göster" name="goster" style="width:100px">


				</form>
				<a href="kullanicicikis.php"><button>Çıkış Yap</button></a>

				<?php 

				if (isset($_POST['goster'])) {
					

					$sec = "SELECT * FROM cevaplartablo";
					$sonuc = mysqli_query($baglanti, $sec);

					if ($sonuc->num_rows>0) {
						while ($cek=$sonuc->fetch_assoc()) {

							?>

							<table border="15" cellspacing="10" cellpadding="5">
							
								<?php  

								echo "<tr><td>"."İş İlanı: ".$cek['metin']."</td></tr>"."<br>";
								echo "<tr><td>"."Ad: ".$cek['ad']."</td></tr>"."<br>";
								echo "<tr><td>"."Soyad: ".$cek['soyad']."</td></tr>"."<br>";
								echo "<tr><td>"."Telefon: ".$cek['telefon']."</td></tr>"."<br>";

								?>
							</table>	
							<?php 
						}
					}

					else{

						echo "<br>";

						echo "Veritabanında hiçbir veri bulunamadı";

					}

				}

				?>



			</center>


			<?php 
		}
		?>

	</center>
</body>
</html>