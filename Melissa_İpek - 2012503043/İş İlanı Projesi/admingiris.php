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

	if (!isset ($_SESSION['adminAdi'])) { ?>

		<center>
			<hr>
			|<a href="index.php">Ana Sayfa</a> | <a href="kullanicigiris.php">Başvuru Girişi</a>|
			<hr>

			<h2>İşveren Girişi</h2>
			<form action="admingiris.php" method="POST">
				
				<label for="adminAdi">Kullanıcı Adı:</label>
				<input type="text" name="adminAdi" id="adminAdi">

				<label for="adminParola">Parola:</label>
				<input type="password" name="adminParola" id="adminParola">
				
				<input type="submit" name="adminGiris" value="Giriş Yap">
			</form>
			<br>
			<hr>

			<?php 
			// İlk olarak form kontrolü yapıyoruz
			if (isset($_POST['adminGiris'])) {

    			// formdan gelen verileri karşılaştırıyoruz. tanımladığımız giriş bilgileri doğrumu kontrol ediyoruz
				if (($_POST['adminAdi']=="isveren1" && $_POST['adminParola']=="1234")  || ($_POST['adminAdi']=="isveren2" && $_POST['adminParola']=="6789")) {

        			//Giriş bilgileri doğruysa session atama işlemleri yapıyoruz
					$_SESSION['adminAdi']=$_POST['adminAdi'];
					$_SESSION['adminParola']=$_POST['adminParola'];

    				// Yönlendirme işlemi yapıyoruz. İşlem sonucunu takip için durum GET değişkenini tanımlıyoruz(index sayfası)
					header("Location:admingiris.php?sonuc=#");
					exit;
				}
				else{
    				// İşlem başarısız olduğu zaman işlem sonucunu takip için durum GET değişkeni tanımlıyoruz(index de)
					header("Location:admingiris.php?sonuc=no");
					exit;
				}
			}



			// İşlemlerden GET değeri döndürüyoruz. Bu sayede işlem durumunu takip edebiliyoruz
			// 2. Kısım
			if ($_GET['sonuc']=="no") {
				echo "<br>";

				echo "Giriş işlemi başarısız, lütfen tekrar deneyiniz.";

				header("Refresh: 5; url=http://localhost/%c4%b0%c5%9f%20%c4%b0lan%c4%b1%20Projesi/admingiris.php");
			}
			else if ($_GET['sonuc']=="cikis") {
				echo "<br>";

				echo "Çıkış işlemi başarıyla yapıldı.";

				header("Refresh: 5; url=http://localhost/%c4%b0%c5%9f%20%c4%b0lan%c4%b1%20Projesi/admingiris.php");
			}
		}
		else{
			?>
			<center>

				<hr>	
				|<a href="index.php">Ana Sayfa</a> | <a href="kullanicigiris.php">Başvuru Girişi</a>|
				<hr>

				<h2>İşveren Paneli</h2>

				<p>Sayın <?php echo $_SESSION['adminAdi'] ?>, hoşgeldiniz!</p>

				<p>Aşağıdaki Metin Alanına İş İlanınızı Giriniz</p>

				<script type="text/javascript">
					function checkChar()
					{
						var allowedChar=400;
						var content= document.getElementById("content");
						var contLength=content.value.length;

						if(contLength > allowedChar){
							content.value=content.value.substring(0,allowedChar);
							document.getElementById("report").innerHTML= "<span style='color:white;'>Uyarı: En fazla "+allowedChar+" karakter girebilirsiniz</span>";
						}	
					}
				</script>

				<form action="admingiris.php" method="POST">

					<textarea id="content" name="content" onkeyup="checkChar()" onkeydown="checkChar()" rows="3" cols="40" required></textarea>


					<div id="report"></div>

					<label for="iAdi">Adı:</label>
					<input type="text" name="iAdi" id="iAdi" required>

					<label for="iSoyadi">Soyad:</label>
					<input type="text" name="iSoyadi" id="iSoyadi" required>

					<label for="iTelefon">Telefon:</label>
					<input type="text" name="iTelefon" id="iTelefon" required>
                    
					<br>
                   

					<input type="submit" name="cevapgonder" value="Gönder">

				</form>
				
				<a href="admincikis.php"><button>Çıkış Yap</button></a>
				<br>


				<?php 

				if (isset($_POST['cevapgonder'])) {

					$metin = $_POST['content'];
					$iAdi = $_POST['iAdi'];
					$iSoyadi = $_POST['iSoyadi'];
					$iTelefon = $_POST['iTelefon'];


					$vEkle = "INSERT INTO cevaplartablo (metin, ad, soyad, telefon) VALUES ('$metin', '$iAdi', '$iSoyadi', '$iTelefon')";

					$calistirEkle = mysqli_query($baglanti, $vEkle);

					if ($calistirEkle) {

						echo "Cevabınız kaydedilmiştir";
						echo "<br>";

						header("Refresh: 1; url=http://localhost/%C4%B0%C5%9F%20%C4%B0lan%C4%B1%20Projesi/admingiris.php");
					}
					else{

						echo "Cevabınız kayıt edilemedi";
						header("Refresh: 1; url=http://localhost/%C4%B0%C5%9F%20%C4%B0lan%C4%B1%20Projesi/admingiris.php");

					}

					mysqli_close($baglanti);
				}
				?>


			</center>

			<?php 
		}
		?>

	</center>
</body>
</html>

