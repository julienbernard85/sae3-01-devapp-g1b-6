<?php session_start();
if (!isset($_SESSION['access'])) {
	header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="include/formulaireGestion1.css">
    <title>Ajouter du stock</title>
	<link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
</head>
<?php include("./include/header.php");?>

<body>
<?php require_once("connect.inc.php"); 
                error_reporting(0);
 ?>
 
 <div class = "titre" style = "text-align: center;
    position: absolute;
    font-size: 50px;
    font-weight: 500;
    color: #06395a;
    margin-top: -25%;
    border: 9px solid black;
    border-style: dashed;
    padding: 10px;">Augmenter le stock d'un article</div>
 
<form method ="POST" class = "form1" action="formulaireGestion1.php" style = "background-color : #1AE2F9;">
            <label class ="lab">Article :</label>
            <select name="select" style="height:30px; width:205px;padding:5px;  " required>
            <option value="" disabled selected hidden > Veuillez choisir un article </option>
<?php
$nomarticle = "SELECT * FROM ARTICLE ORDER BY NOMARTICLE ASC";
$nomA = oci_parse($connect, $nomarticle);
oci_execute($nomA); 
while (($affichage = oci_fetch_assoc($nomA)) != false){
    echo ' <option value="' . $affichage["IDARTICLE"] . '">'. $affichage["NOMARTICLE"].'</option>';
}
?>
            </select>
            <label class ="lab">Quantité :</label>
            <input type="number" name="tentacles" min="1" max="100" value ="1" required>
            <input type="submit" name= "Valider" value="Valider">
        </form>

        <?php 
        
        if(isset($_POST["Valider"]) AND isset($_POST["tentacles"]) ){
            $procedure = "BEGIN AjoutArticle(:id, :stock); END;";
			
            $proc = oci_parse($connect, $procedure);
			
            oci_bind_by_name($proc, ":id",$_POST["select"]);
			
            oci_bind_by_name($proc, ":stock",$_POST["tentacles"]);
			
            oci_execute($proc);
			
            oci_commit($connect);
			
			echo'<script language="JavaScript" type="text/javascript"> 
					alert("'.$_POST['tentacles'].' article.s ajout\u00e9.s !"); 
					location.href = "GestionProduit.php";
				</script>';
           
        }   
		
        ?>
    <button id = "retour"><a href="GestionProduit.php">Retour à la gestion </a></button>
</body>
<?php include("./include/footer3.php");?>
</html>



