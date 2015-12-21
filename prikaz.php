<!Doctype-html>
<html>
<head>
<title>Pregled - školski sportski klub</title>
<meta name="description" content="Pregled učenika, trenera i sportova školskog sportskog kluba">
<meta name="keywords" content="školski sportski klub, pregled, učenici, treneri, sportovi">
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css.css">

</head>

<body id="prikaz">
<h1>POPIS UČENIKA TRENERA I SPORTOVA</h1>
<h2><a href="unos.php">UNOS</a></h2>


<?php

include 'connection.php';



$pdo = new PDO("mysql:host=$host;dbname=$baza", $user, $pass);

$stmt  = $pdo->query("SELECT COUNT(br_ucenika)as rows FROM treneri_ucenici") ->fetch(PDO::FETCH_OBJ);

$po_str = 5;
$posts  = $stmt->rows;
$stranice  = ceil($posts / $po_str);


$get_pages = isset($_GET['page']) ? $_GET['page'] : 1;

$data = array(

			'izbor' => array(
				'max'   => 1,
				'min' => 1,
				'max' => $stranice)
		);

$broj = trim($get_pages);
		$broj = filter_var($broj, FILTER_VALIDATE_INT, $data);
	$limit  = $po_str * ($broj - 1);

	$prev = $broj - 1;
	$next = $broj + 1;

$stmt = $pdo->prepare('SELECT ucenici.br_ucenika, ime_ucenika, prezime_ucenika, adresa, mjesto, br_sporta, naziv_sporta, id, ime_trenera,
prezime_trenera  FROM ucenici JOIN treneri_ucenici
ON treneri_ucenici.br_ucenika=ucenici.br_ucenika JOIN treneri
ON treneri.id=treneri_ucenici.br_trenera JOIN sportovi
ON sportovi.br_sporta=treneri.sport ORDER BY prezime_ucenika LIMIT :limit,  :po_str');
	$stmt->bindParam(':po_str', $po_str, PDO::PARAM_INT);
	$stmt->bindParam(':limit', $limit, PDO::PARAM_INT); 
	$stmt->execute();

	$result = $stmt->fetchAll(PDO::FETCH_OBJ);

	

unset($pdo);



if($result AND count($result) > 0)
 {
	echo "<h3>Ukupno stranica: ($stranice)</h3>";

	
	if($broj <= 1)
	echo "<span><a href=\"?page=$next\">naprijed >></a>";
		# prva stranica			

	elseif($broj >= $stranice)
	echo "<a href=\"?page=$prev\"><< natrag</a> | <span>naprijed >></span>";
					
	    # zadnja stranica
	else
	echo "<a href=\"?page=$prev\"><< natrag</a> | <a href=\"?page=$next\">naprijed >></a>";
				}
       # unutar raspona

	else
	{
	echo "<p>Nema zapisa.</p>";
}
	

?>


</div>

<form method="post">

<?php



if($result AND count($result) > 0)
{

echo '<br>';
 echo '
					
		<table border="1">
							
		<tr>
		<th>Br. učenika</th>
		<th>Ime učenika</th>
		<th>Prezime učenika</th>
		<th>Adresa</th>
		<th>Mjesto </th>
		<th>Sport</th>
		<th>Ime trenera</th>
		<th>Prezime trenera</th>
		<th>Dodaj sport</th>
		<th>Obriši učenika</th>
        </tr>';

foreach($result as $key => $row)
{
		echo '<tr>';
echo '<td>'.$row->br_ucenika."</td>";		
echo '<td>'.$row->ime_ucenika.'</td>';
echo '<td>'.$row->prezime_ucenika.'</td>';
echo '<td>'.$row->adresa.'</td>';
echo '<td>'.$row->mjesto.'</td>';
echo '<td>'.$row->naziv_sporta.'</td>';
echo '<td>'.$row->ime_trenera.'</td>';
echo '<td>'.$row->prezime_trenera.'</td>';
echo '<td>';
# DODAVANJE NOVOG SPORTA I TRENERA, petlja - PDO UNUTAR PDO-a


echo '<select name="novi">';


$pdo2=new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query2='SELECT br_sporta, naziv_sporta, treneri.id, ime_trenera, prezime_trenera FROM treneri
JOIN sportovi ON treneri.sport=sportovi.br_sporta';
$stmt2=$pdo2->query($query2);
$dodaj=$stmt2->fetchAll(PDO::FETCH_OBJ);

foreach ($dodaj as $key => $v) {

echo '<option value="'.$v->id.'">'.$v->id." ".$v->naziv_sporta.", ".$v->ime_trenera." ".$v->prezime_trenera.'</option>';

}

unset($pdo2);


echo '</select>';


echo '<button name="dodaj" type="submit" value="'.$row->br_ucenika.'">Dodaj</button> </td>';
echo '<td><button name="brisi" type="submit" value="'.$row->br_ucenika.'">Obriši</button> </td>';
echo '</tr>';


}
}
echo '</table>';
unset($pdo);

# BRISANJE:
if (isset($_POST["brisi"]))
 {
$pdo=new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);	
$query='DELETE FROM ucenici WHERE br_ucenika = ?';
$stmt=$pdo->prepare($query);
$stmt->bindParam(1, $_POST["brisi"]);
$stmt->execute();
unset($pdo);

}


?>
</form>
</div>


<!-- TRAŽILICA -->
<form method="post">

Pretraži: <br>
  <input type="text" name="trazi">
  <input type="submit" name="dugme" value="Traži">

<br>
</form>

<?php


if (isset($_POST["dugme"])) {
  

  $a=$_POST["trazi"];
  $b="%".$a."%";
  $pdo=new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
  $query='SELECT ime_ucenika, prezime_ucenika, adresa, mjesto, naziv_sporta, ime_trenera,
prezime_trenera  FROM ucenici JOIN treneri_ucenici
ON treneri_ucenici.br_ucenika=ucenici.br_ucenika JOIN treneri
ON treneri.id=treneri_ucenici.br_trenera JOIN sportovi
ON sportovi.br_sporta=treneri.sport WHERE  ime_ucenika LIKE :b
OR prezime_ucenika LIKE :b OR adresa LIKE :b
OR mjesto LIKE :b OR naziv_sporta LIKE :b
OR ime_trenera LIKE :b OR prezime_trenera LIKE :b';
  $stmt=$pdo->prepare($query);
  
  $stmt->bindValue(":b", $b);
  $stmt->execute();
 
 $rezultat=$stmt->fetchAll(PDO::FETCH_OBJ);

if (empty($rezultat) OR $rezultat== false)
{
  echo "<br><div id='div1'>NIŠTA NIJE PRONAĐENO!</div>";
}

else
{
  echo '<br><div id="div2">PRONAĐENO:</div>';
  echo "<div id='div2'>";
  echo '<table border="1">';
  echo '<tr>
        <th>Ime učenika</th>
		<th>Prezime učenika</th>
		<th>Adresa</th>
		<th>Mjesto </th>
		<th>Sport</th>
		<th>Ime trenera</th>
		<th>Prezime trenera</th>
  </tr>';
foreach ($rezultat as $key => $r) {
  
  echo '<tr>';
echo '<td>'.$r->ime_ucenika.'</td>';
echo '<td>'.$r->prezime_ucenika.'</td>';
echo '<td>'.$r->adresa.'</td>';
echo '<td>'.$r->mjesto.'</td>';
echo '<td>'.$r->naziv_sporta.'</td>';
echo '<td>'.$r->ime_trenera.'</td>';
echo '<td>'.$r->prezime_trenera.'</td>';
  echo '<tr>';
  

}
echo'</table>';
  echo'</div>';

 }
 //unset($pdo);
}

# DODAVANJE SPORTA
if (isset($_POST["dodaj"])) {
	echo $_POST["dodaj"]." ".$_POST["novi"];

$trener=$_POST["novi"];
$ucenik=$_POST["dodaj"];	
$pdo=new PDO ("mysql:host=$host; dbname=$baza", $user, $pass);
$query='INSERT INTO treneri_ucenici (br_trenera, br_ucenika) VALUES (:trener, :ucenik )';
$stmt=$pdo->prepare($query);
$stmt->bindValue(':trener', $trener);
$stmt->bindValue(':ucenik', $ucenik);
$stmt->execute();
unset($pdo);	

	
}

echo "<br>";
echo "<pre>";
print_r($_POST);
echo "</pre>";
?>





</body>


</html>