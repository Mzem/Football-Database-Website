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
			$reqNb = $bdd->prepare('SELECT J.club, COUNT(DISTINCT J.joueur) AS nb FROM joueurs Jr JOIN joue J ON Jr.id = J.joueur WHERE J.club = :id GROUP BY J.club UNION ( SELECT C.id, 0 FROM clubs C WHERE C.id = :id AND C.id NOT IN ( SELECT J.club FROM joueurs Jr JOIN joue J ON J.joueur = Jr.id))');
			$reqNb->execute( array('id' => $donnees['id']) );
			$donneesNb = $reqNb->fetch();
			$reqNb->closeCursor();
		?>	
			<div id="element_page">
				<img src="img/clubs/<?php echo $donnees['id']; ?>.png" />
				<p>
					<strong> <?php echo $donnees['nom']; ?> </strong>
					<br/>
					<a href="joueurs.php?club=<?php echo $donnees['id'];?>">Représenté par <?php echo $donneesNb['nb'];?> joueur(s)</a>
					<br/>
					<?php
					if (isset($_SESSION['email']))
					{
						if ($_SESSION['club'] == $donnees['id']){
							?> <img src="img/etoileFav.png" /> <?php
						} else {
							?> <a href="espaceMembre.php?club=<?php echo $donnees['id']?>"><img src="img/etoile.png" /></a> <?php
						}
					}
					?>
				</p>
				<div class="listing">
					<img src="img/nations/<?php echo $donnees['pays']; ?>.png" />

				</div>			
				<div class="listing">
				<?php
					$reqTroph = $bdd->prepare('SELECT P.club, P.trophe, P.annee FROM palmares P WHERE P.type = "club" AND P.club = :rech GROUP BY P.club, P.trophe, P.annee ORDER BY P.trophe');
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
							<li><a href="nations.php">Nations</a></li>
							<li class="actuel"><a href="clubs.php">Clubs</a></li>
							<li><a href="trophes.php">Trophés</a></li>
							<li><a href="espaceMembre.php"><img src="img/espaceMembre.png" alt="Espace membre" /></a></li>
						</ul>
				</nav>
						
            </header>
			
			<div id="pages_daffichage">
				<section>
					
					<div id="options">

						<form method="post" action="clubs.php">
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
						$reponse = $bdd->prepare(' SELECT * FROM clubs WHERE id = :rech');
						$reponse->execute( array('rech' => htmlspecialchars($_GET['id']) ) );
						afficher($reponse, $bdd);
						$reponse->closeCursor();
					}
					//Recherche d'un element
					elseif ( isset($_POST['recherche']) || isset($_POST['tri']) )
					{
						if ( isset($_POST['tri']) && $_POST['tri'] == "nbTrophes")
						{
							$reponse = $bdd->prepare(' SELECT * FROM clubs C WHERE C.nom LIKE :rech ORDER BY (SELECT COUNT(*) AS nb FROM palmaresclub PC WHERE PC.club = C.id GROUP BY PC.club) DESC');
						} 
						elseif ( isset($_POST['tri']) && $_POST['tri'] == "nbJoueurs")
						{
							$reponse = $bdd->prepare('SELECT * FROM clubs C WHERE nom LIKE :rech ORDER BY (SELECT COUNT(DISTINCT J.joueur) AS nb FROM joueurs Jr JOIN joue J ON Jr.id = J.joueur WHERE J.club = C.id GROUP BY J.club UNION ( SELECT 0 FROM clubs C2 WHERE C2.id = C.id AND C2.id NOT IN ( SELECT J.club FROM joueurs Jr JOIN joue J ON J.joueur = Jr.id))) DESC');
						}
						else
						{
							$reponse = $bdd->prepare(' SELECT * FROM clubs WHERE nom LIKE :rech ORDER BY nom ASC');
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
						$reponse = $bdd->query('SELECT * FROM clubs ORDER BY nom ASC');
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
