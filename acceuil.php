<?php
	session_start();
	if ( isset($_POST['deconnection']) )
	{
		session_destroy();
	}

	try{
		$bdd = new PDO('mysql:host=localhost;dbname=Football;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
	}

	//Fonction pour l'affichage de la liste des joueurs
	function afficher($req, $bdd, $dossier)
	{
		while ($donnees = $req->fetch())
		{
		?>	
			<a href="<?php echo $dossier.'.php?id='.$donnees['id'];?>"><img src="img/<?php echo $dossier.'/'.$donnees['id']; ?>.png" /></a>		
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
							<li class="actuel"><a href="acceuil.php">Acceuil</a></li>
							<li><a href="joueurs.php">Joueurs</a></li>
							<li><a href="nations.php">Nations</a></li>
							<li><a href="clubs.php">Clubs</a></li>
							<li><a href="trophes.php">Trophés</a></li>
							<li><a href="espaceMembre.php"><img src="img/espaceMembre.png" alt="Espace membre" /></a></li>
						</ul>
				</nav>
             
            </header>
			
			<div id="bloc_acceuil">

				<section>
					
					<div id="champ_recherche">
						<img src="img/logoGlow.png" alt="Logo legends" />
						
						<form method="post" action="acceuil.php#element_acceuil">
							<p>
								<h2>Rechercher quelque chose... :</h2>
								<input type="search" name="recherche" placeholder="Rechercher..." required/>
								<br />
								<br />
								<input type="submit" value="Rechercher"/>
							</p>
						</form>
					</div>
					
				</section>

				<div id="element_acceuil">
					<?php
					//Recherche d'un joueur
					if ( isset($_POST['recherche']) )
					{
						$reponse = $bdd->prepare('SELECT * FROM Joueurs WHERE nom LIKE :rech OR prenom LIKE :rech ORDER BY note DESC, nom ASC');
						$reponse->execute( array('rech' => '%'. htmlspecialchars($_POST['recherche']).'%' ));
						afficher($reponse, $bdd, "joueurs");
						$reponse->closeCursor();
						$reponse = $bdd->prepare('SELECT * FROM pays WHERE nom LIKE :rech ORDER BY nom ASC');
						$reponse->execute( array('rech' => '%'. htmlspecialchars($_POST['recherche']).'%' ));
						afficher($reponse, $bdd, "nations");
						$reponse->closeCursor();									
						$reponse = $bdd->prepare('SELECT * FROM clubs WHERE nom LIKE :rech ORDER BY nom ASC');
						$reponse->execute( array('rech' => '%'. htmlspecialchars($_POST['recherche']).'%' ));
						afficher($reponse, $bdd, "clubs");
						$reponse->closeCursor();						
						$reponse = $bdd->prepare('SELECT * FROM trophes WHERE nom LIKE :rech ORDER BY nom ASC');
						$reponse->execute( array('rech' => '%'. htmlspecialchars($_POST['recherche']).'%' ));
						afficher($reponse, $bdd, "trophes");
						$reponse->closeCursor();
					}
					//Affichage complet de la liste des joueurs
					else
					{
						$reponse = $bdd->query('SELECT * FROM Joueurs ORDER BY note DESC, nom ASC');
						afficher($reponse, $bdd, "joueurs");
						$reponse->closeCursor();
						$reponse = $bdd->query('SELECT * FROM pays ORDER BY nom ASC');
						afficher($reponse, $bdd, "nations");
						$reponse->closeCursor();									
						$reponse = $bdd->query('SELECT * FROM clubs ORDER BY nom ASC');
						afficher($reponse, $bdd, "clubs");
						$reponse->closeCursor();						
						$reponse = $bdd->query('SELECT * FROM trophes ORDER BY nom ASC');
						afficher($reponse, $bdd, "trophes");
						$reponse->closeCursor();
					}

					?>
				</div>


			</div>
			
			<footer>
				Tous droits réservés - UVSQ 2016
			</footer>
			
    </body>
	
</html>
