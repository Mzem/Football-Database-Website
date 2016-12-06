<?php
	session_start();

	try{
		$bdd = new PDO('mysql:host=localhost;dbname=Football;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
	}

	//Fonction pour l'affichage de la liste des elements
	function afficher($req, $bdd)
	{
		while ($donnees = $req->fetch())
		{
			//comptage du nombre de joueurs qui ont remporté le trophé :
			$reqNb = $bdd->prepare('SELECT COUNT(DISTINCT R.joueur) AS nb FROM joueurs Jr, remporte R WHERE Jr.id = R.joueur AND R.trophe = :id GROUP BY R.trophe');
			$reqNb->execute( array('id' => $donnees['id']) );
			$donneesNb = $reqNb->fetch();
			$reqNb->closeCursor();
		?>	
			<div id="element_page">
				<img src="img/trophes/<?php echo $donnees['id']; ?>.png" />
				<p>
					<strong> <?php echo $donnees['nom']; ?> </strong>
					<br/>
					<a href="joueurs.php?trophe=<?php echo $donnees['id'];?>">Remportré par <?php echo $donneesNb['nb'];?> joueur(s)</a>
				</p>
				<div class="listing_palmares">
				<?php
				if ($donnees['type'] == "club")
				{
					$reqPal = $bdd->prepare('SELECT P.club, P.annee FROM palmares P WHERE P.trophe = :id GROUP BY P.club, P.trophe, P.annee ORDER BY P.annee ASC');
					$reqPal->execute( array('id' => $donnees['id']) );
					while ($Pal = $reqPal->fetch())
					{
				?>	
						<div>
							<img src="img/clubs/<?php echo $Pal['club']; ?>.png" />
							<?php echo $Pal['annee'];?>
						</div>
				<?php
					}
					$reqPal->closeCursor();
				}
				elseif ($donnees['type'] == "pays")
				{
					$reqPal = $bdd->prepare('SELECT * FROM palmarespays PP WHERE PP.trophe = :id ORDER BY PP.annee ASC');
					$reqPal->execute( array('id' => $donnees['id']) );
					while ($Pal = $reqPal->fetch())
					{
				?>	
						<div>
							<img src="img/nations/<?php echo $Pal['pays']; ?>.png" />
							<?php echo $Pal['annee'];?>
						</div>
				<?php
					}
					$reqPal->closeCursor();
				}
				else
				{
					$reqPal = $bdd->prepare('SELECT P.joueur, P.annee FROM palmares P WHERE P.trophe = :id GROUP BY P.joueur, P.trophe, P.annee ORDER BY P.annee ASC');
					$reqPal->execute( array('id' => $donnees['id']) );
					while ($Pal = $reqPal->fetch())
					{
				?>	
						<div>
							<img src="img/joueurs/<?php echo $Pal['joueur']; ?>.png" />
							<?php echo $Pal['annee'];?>
						</div>
				<?php
					}
					$reqPal->closeCursor();
				}
				?>
				</div>

			</div>			
		<?php
		}
	}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <title>Football Legends</title>
		<link rel="icon" href="img/favicon.png" />
    </head>
	
	
    <body>
		
            <header>
			
                <div id="logo">
                 
                        <img src="img/logo.png" alt="Logo legends" />
                        <h1>Football Legends Database</h1>			
                </div>
					
				<nav>
						<ul>
							<li><a href="acceuil.php">Acceuil</a></li>
							<li><a href="joueurs.php">Joueurs</a></li>
							<li><a href="nations.php">Nations</a></li>
							<li><a href="clubs.php">Clubs</a></li>
							<li class="actuel"><a href="trophes.php">Trophés</a></li>
							<li><a href="espaceMembre.php"><img src="img/espaceMembre.png" alt="Espace membre" /></a></li>
						</ul>
				</nav>
						
            </header>
			
			<div id="pages_daffichage">
				<section>
					
					<div id="options">

						<form method="post" action="trophes.php">
							<p>
								<label for="recherche">Rechercher par nom :</label>
								<input type="search" name="recherche" placeholder="Rechercher un joueur..."/>

								<label for="tri">Trier par :</label>
						       	<select name="tri" id="tri">
						           <option value="nom">Nom</option>
						           <option value="nbJoueurs">Nombre de joueurs</option>
						       	</select>

						       	<input type="submit" value="Appliquer" />
						    </p>
						</form>

					</div>

					


					 <?php
					//Affichage d'un seul element
					if ( isset($_GET['id']) )
					{
						$reponse = $bdd->prepare(' SELECT * FROM trophes WHERE id = :rech');
						$reponse->execute( array('rech' => htmlspecialchars($_GET['id']) ) );
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}
					//Recherche d'un element
					elseif ( isset($_POST['recherche']) || isset($_POST['tri']) )
					{
						if ( isset($_POST['tri']) && $_POST['tri'] == "nbJoueurs")
						{
							$reponse = $bdd->prepare(' SELECT * FROM trophes T WHERE nom LIKE :rech ORDER BY (SELECT COUNT(DISTINCT R.joueur) AS nb FROM joueurs Jr, remporte R WHERE Jr.id = R.joueur AND R.trophe = T.id GROUP BY R.trophe) DESC');
						}
						else
						{
							$reponse = $bdd->prepare(' SELECT * FROM trophes WHERE nom LIKE :rech ORDER BY nom ASC');
						} 
						if ( isset($_POST['recherche']) )
						{
							$reponse->execute( array('rech' => '%'. htmlspecialchars($_POST['recherche']).'%') );
						} 
						else 
						{
							$reponse->execute( array('rech' => '%') );
						}
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}
					//Affichage complet de la liste des elements
					else
					{
						$reponse = $bdd->query('SELECT * FROM trophes ORDER BY type ASC');
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}

					?>
					
				</section>
			</div>
			
			<footer>
				Tous droits réservés - UVSQ 2016
			</footer>
	
	</body>
	
</html>
