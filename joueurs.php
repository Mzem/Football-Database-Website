<?php
	session_start();

	try{
		$bdd = new PDO('mysql:host=localhost;dbname=Football;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
	}

	//Fonction pour l'affichage de la liste des joueurs
	function afficher($req, $bdd)
	{
		while ($donnees = $req->fetch())
		{
		?>	
			<div id="element_page">
				<img src="img/joueurs/<?php echo $donnees['id']; ?>.png" />
				<p>
					<strong> <?php echo $donnees['prenom'] . ' ' . $donnees['nom']; ?> </strong>
						<br />
					<?php	$age = date('Y') - $donnees['annee'];
					echo $age;
					?> ans
					<br/>

					<?php
					if (isset($_SESSION['email']))
					{
						if ($_SESSION['joueur'] == $donnees['id']){
							?> <img src="img/etoileFav.png" /> <?php
						} else {
							?> <a href="espaceMembre.php?joueur=<?php echo $donnees['id']?>"><img src="img/etoile.png" /></a> <?php
						}
					}
					?>
				</p>
				<div class="listing">
					<?php

					$reqClub = $bdd->prepare('SELECT * FROM joue J WHERE J.joueur = :rech ORDER BY J.anneeDebut ASC');
					$reqClub->execute( array('rech' => $donnees['id']) );
					while ($club = $reqClub->fetch())
					{
					?>	
						<div>
							<img src="img/clubs/<?php echo $club['club']; ?>.png" />
							<?php
								if ($club['anneeFin'] == 3000){
									echo $club['anneeDebut'].' - ';
								} else {
									echo $club['anneeDebut'].' - '.$club['anneeFin']; 
								}
							?>
						</div>
					<?php
					}
					if (isset($_SESSION['email']) && ($_SESSION['type'] == "admin") ){
						?><a href="ajoutClub.php?id=<?php echo$donnees['id'];?>"><img src="img/ajout.png" /></a><?php
					}
					$reqClub->closeCursor();
					?>
				</div>			
				<div class="listing">
					<?php

					$reqTroph = $bdd->prepare('SELECT trophe, COUNT(*) AS nb FROM remporte WHERE joueur = :rech GROUP BY trophe');
					$reqTroph->execute( array('rech' => $donnees['id']) );
					while ($Troph = $reqTroph->fetch())
					{
					?>	
						<div>
							<img src="img/trophes/<?php echo $Troph['trophe']; ?>.png" />
							<?php echo 'x '.$Troph['nb'];?>
						</div>
					<?php
					}
					if (isset($_SESSION['email']) && ($_SESSION['type'] == "admin") ){
					?><a href="ajoutTrophe.php?id=<?php echo$donnees['id'];?>"><img src="img/ajout.png" /></a><?php
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
							<li class="actuel"><a href="joueurs.php">Joueurs</a></li>
							<li><a href="nations.php">Nations</a></li>
							<li><a href="clubs.php">Clubs</a></li>
							<li><a href="trophes.php">Trophés</a></li>
							<li><a href="espaceMembre.php"><img src="img/espaceMembre.png" alt="Espace membre" /></a></li>
						</ul>
				</nav>
						
            </header>
			
			<div id="pages_daffichage">
				<section>
					
					<div id="options">

						<form method="post" action="joueurs.php">
							<p>
								<label for="recherche">Rechercher par nom :</label>
								<input type="search" name="recherche" placeholder="Rechercher un joueur..."/>

								<label for="tri">Trier par :</label>
						       	<select name="tri" id="tri">
						           <option value="note">Note</option>
						           <option value="nom">Nom</option>
						           <option value="age">Age</option>
						           <option value="nbClubs">Nombre de clubs</option>
						           <option value="nbTrophes">Nombre de trophés</option>
						       	</select>

						       	<input type="submit" value="Appliquer" />
						       	
						       	<?php if (isset($_SESSION['email']) && ($_SESSION['type'] == "admin") ){
						       	?><a href="ajoutJoueur.php"><img src="img/ajout.png" /></a><?php
						       	}
						       	?>
						    </p>

						</form>

					</div>

					


					 <?php
					//Affichage d'un seul joueur
					if ( isset($_GET['id']) )
					{
						$reponse = $bdd->prepare(' SELECT * FROM Joueurs Jr WHERE Jr.id = :rech');
						$reponse->execute( array('rech' => htmlspecialchars($_GET['id']) ) );
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}
					//Affichage selon critères
					elseif ( isset($_GET['pays']) )
					{
						$reponse = $bdd->prepare(' SELECT * FROM Joueurs Jr WHERE Jr.pays = :rech');
						$reponse->execute( array('rech' => htmlspecialchars($_GET['pays']) ) );
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}
					elseif ( isset($_GET['club']) )
					{
						$reponse = $bdd->prepare(' SELECT DISTINCT Jr.id, Jr.prenom, Jr.nom, Jr.annee, Jr.poste, Jr.note, Jr.pays FROM Joueurs Jr, joue J WHERE Jr.id = J.joueur AND J.club = :rech');
						$reponse->execute( array('rech' => htmlspecialchars($_GET['club']) ) );
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}
					elseif ( isset($_GET['trophe']) )
					{
						$reponse = $bdd->prepare(' SELECT DISTINCT Jr.id, Jr.prenom, Jr.nom, Jr.annee, Jr.poste, Jr.note, Jr.pays FROM Joueurs Jr, remporte R WHERE Jr.id = R.joueur AND R.trophe = :rech');
						$reponse->execute( array('rech' => htmlspecialchars($_GET['trophe']) ) );
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}
					//Recherche d'un joueur
					elseif ( isset($_POST['recherche']) || isset($_POST['tri']) )
					{
						if ( isset($_POST['tri']) && $_POST['tri'] == "nom")
						{
							$reponse = $bdd->prepare(' SELECT * FROM Joueurs Jr WHERE Jr.prenom LIKE :rech OR Jr.nom LIKE :rech ORDER BY Jr.nom ASC');
						} 
						elseif ( isset($_POST['tri']) && $_POST['tri'] == "age")
						{
							$reponse = $bdd->prepare(' SELECT * FROM Joueurs Jr WHERE Jr.prenom LIKE :rech OR Jr.nom LIKE :rech ORDER BY Jr.annee DESC, Jr.nom ASC');
						}
						elseif ( isset($_POST['tri']) && $_POST['tri'] == "nbClubs")
						{
							$reponse = $bdd->prepare(' SELECT * FROM joueurs Jr WHERE Jr.prenom LIKE :rech OR Jr.nom LIKE :rech ORDER BY (SELECT COUNT(*) AS nb FROM joue J WHERE J.joueur = Jr.id GROUP BY J.joueur) DESC');
						}						
						elseif ( isset($_POST['tri']) && $_POST['tri'] == "nbTrophes")
						{
							$reponse = $bdd->prepare(' SELECT * FROM joueurs Jr WHERE Jr.prenom LIKE :rech OR Jr.nom LIKE :rech ORDER BY (SELECT COUNT(*) AS nb FROM remporte R WHERE R.joueur = Jr.id GROUP BY R.joueur) DESC');
						}
						else
						{
							$reponse = $bdd->prepare(' SELECT * FROM Joueurs Jr WHERE Jr.prenom LIKE :rech OR Jr.nom LIKE :rech ORDER BY Jr.note DESC, Jr.nom ASC');
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
					//Affichage complet de la liste des joueurs
					else
					{
						$reponse = $bdd->query('SELECT * FROM Joueurs Jr ORDER BY Jr.note DESC, Jr.nom ASC');
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
