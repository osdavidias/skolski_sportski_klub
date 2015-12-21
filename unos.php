<!Doctype-html>
<html>
<head>
<title>Unos - školski sportski klub</title>
<meta charset="UTF-8">
<meta name="description" content="Unos učenika, trenera i sportova školskog sportskog kluba">
<meta name="keywords" content="školski sportski klub, unos, učenici, treneri, sportovi">
<link rel="stylesheet" type="text/css" href="css.css">

</head>

<body id="unos">


<?php
include 'connection.php';

?>	

<h1>ŠKOLSKI SPORTSKI KLUB</h1>
<img src="slika.png">

<h2><a href="prikaz.php">Popis učenika, trenera i sportova</a><h2>


<h3>Unesi trenera:</h3>

<form method="post">
Ime trenera:	
<input type="text" name="ime_tren">
<br>
Prezime trenera:
<input type"text" name="prezime_tren">
<br>
Sport:
<select name="sport">
<?php 	

$pdo=new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="SELECT br_sporta, naziv_sporta FROM sportovi ORDER BY naziv_sporta";
$stmt=$pdo->query($query);
$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);
foreach ($rezultat as $key => $value) {
	echo '<option value="'.$value->br_sporta.'">'.$value->naziv_sporta;
	echo '</option>'; 

}
unset($pdo);
?>

</select>
<br> <input type="submit" name="dugme1" value="Pošalji">
</form>

<h3>Unesi učenika:</h3>
Ime:<br>
<form method="post">
<input type="text" name="ime_ucenika">
<br> Prezime:
<input type="text" name="prezime_ucenika">
<br> Razred:
<select name="razred">
<?php
$pdo =new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="SELECT br_razreda, naziv_razreda FROM razredi";
$stmt=$pdo->query($query);
$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);
foreach ($rezultat as $key => $value) {
	echo '<option value="'.$value->br_razreda.'">'.$value->naziv_razreda;
    echo '</option>';
}
unset($pdo);
?>
</select>
<br> Trener i sport koji trenira:
<select name="trener">
<?php
$pdo = new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="SELECT id, ime_trenera, prezime_trenera, naziv_sporta FROM treneri JOIN sportovi ON sportovi.br_sporta=treneri.sport";
$stmt=$pdo->query($query);
$rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);
foreach ($rezultat as $key => $value) {
	 echo '<option value="'.$value->id.'">'.$value->ime_trenera." ".$value->prezime_trenera.", ".$value->naziv_sporta;
     echo '</option>';
}
unset($pdo);
?>
</select>
<br> Adresa:
<input type="text" name="adresa">
<br> Mjesto: <input type="text" name="mjesto">
<br> Broj telefona: <input type="text" name="telefon">
<br> <input type="submit" name="dugme2" value="Pošalji">

</form>	

<?php
if (isset($_POST["dugme1"]))
 {

$pdo=new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="INSERT INTO treneri (ime_trenera, prezime_trenera, sport)";
$query.="VALUES (?, ?, ?)";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_POST["ime_tren"]);
$stmt->bindParam(2, $_POST["prezime_tren"]);
$stmt->bindParam(3, $_POST["sport"]);
$stmt->execute();
unset($pdo);

}

if (isset($_POST["dugme2"]))
 {

$pdo=new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="INSERT INTO ucenici (ime_ucenika, prezime_ucenika, razred, adresa, mjesto, telefon)";
$query.="VALUES (?, ?, ?, ?, ?, ?)";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_POST["ime_ucenika"]);
$stmt->bindParam(2, $_POST["prezime_ucenika"]);
$stmt->bindParam(3, $_POST["razred"]);
$stmt->bindParam(4, $_POST["adresa"]);
$stmt->bindParam(5, $_POST["mjesto"]);
$stmt->bindParam(6, $_POST["telefon"]);
$stmt->execute();
$z= $pdo->lastInsertId();

unset($pdo);

$pdo=new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query="INSERT INTO treneri_ucenici VALUES (?, ?)";
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_POST["trener"]);
$stmt->bindParam(2, $z);
$stmt->execute();
unset($pdo);


}





?>


</body>

</html>
