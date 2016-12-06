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
			//comptage du nombre de joueurs représentés :
			$reqNb = $bdd->prepare('SELECT COUNT(*) AS nb FROM joueurs Jr WHERE Jr.pays = :id GROUP BY Jr.pays');
			$reqNb->execute( array('id' => $donnees['id']) );
			$donneesNb = $reqNb->fetch();
			$reqNb->closeCursor();
		?>	
			<div id="element_page">
				<img src="img/nations/<?php echo $donnees['id']; ?>.png" />
				<p>
					<strong> <?php echo $donnees['nom']; ?> </strong>
					<br/>
					<a href="joueurs.php?pays=<?php echo $donnees['id'];?>">Représenté par <?php echo $donneesNb['nb'];?> joueur(s)</a>
					<br/>
					<?php
					if (isset($_SESSION['email']))
					{
						if ($_SESSION['pays'] == $donnees['id']){
							?> <img src="img/etoileFav.png" /> <?php
						} else {
							?> <a href="espaceMembre.php?pays=<?php echo $donnees['id']?>"><img src="img/etoile.png" /></a> <?php
						}
					}
					?>
				</p>
				<div class="listing">
					<?php

					$reqClub = $bdd->prepare('SELECT * FROM clubs C WHERE C.pays = :rech');
					$reqClub->execute( array('rech' => $donnees['id']) );
					while ($club = $reqClub->fetch())
					{
					?>
						<img src="img/clubs/<?php echo $club['id']; ?>.png" />
					<?php
					}
					$reqClub->closeCursor();
					?>
				</div>			
				<div class="listing">
				<?php
					$reqTroph = $bdd->prepare('SELECT DISTINCT R.trophe, R.annee FROM Joueurs Jr, remporte R, trophes T WHERE Jr.id = R.joueur AND R.trophe = T.id AND T.type = "pays" AND Jr.pays = :rech ORDER BY R.annee ASC');
					$reqTroph->execute( array('rech' => $donnees['id']) );
					while ($Troph = $reqTroph->fetch())
					{
				?>	
						<div>
							<img src="img/trophes/<?php echo $Troph['trophe']; ?>.png" />
							<?php echo $Troph['annee'];?>
						</div>
				<?php
					}
					$reqTroph->closeCursor();
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
							<li class="actuel"><a href="nations.php">Nations</a></li>
							<li><a href="clubs.php">Clubs</a></li>
							<li><a href="trophes.php">Trophés</a></li>
							<li><a href="espaceMembre.php"><img src="img/espaceMembre.png" alt="Espace membre" /></a></li>
						</ul>
				</nav>
						
            </header>
			
			<div id="pages_daffichage">
				<section>
					
					<div id="options">

						<form method="post" action="nations.php">
							<p>
								<label for="recherche">Rechercher par nom :</label>
								<input type="search" name="recherche" placeholder="Rechercher un joueur..."/>

								<label for="tri">Trier par :</label>
						       	<select name="tri" id="tri">
						           <option value="nom">Nom</option>
						           <option value="nbTrophes">Nombre de trophés</option>
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
						$reponse = $bdd->prepare(' SELECT * FROM pays WHERE id = :rech');
						$reponse->execute( array('rech' => htmlspecialchars($_GET['id']) ) );
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}
					//Recherche d'un element
					elseif ( isset($_POST['recherche']) || isset($_POST['tri']) )
					{
						if ( isset($_POST['tri']) && $_POST['tri'] == "nbTrophes")
						{
							$reponse = $bdd->prepare(' SELECT * FROM pays P WHERE P.nom LIKE :rech ORDER BY (SELECT COUNT(PP.trophe) FROM palmarespays PP WHERE PP.pays = P.id GROUP BY PP.pays) DESC');
						} 
						elseif ( isset($_POST['tri']) && $_POST['tri'] == "nbJoueurs")
						{
							$reponse = $bdd->prepare(' SELECT * FROM pays P WHERE P.nom LIKE :rech ORDER BY (SELECT COUNT(*) AS nb FROM joueurs Jr WHERE Jr.pays = P.id GROUP BY Jr.pays) DESC');
						}
						else
						{
							$reponse = $bdd->prepare(' SELECT * FROM pays P WHERE P.nom LIKE :rech ORDER BY P.nom ASC');
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
						$reponse = $bdd->query('SELECT * FROM pays P ORDER BY P.nom ASC');
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
