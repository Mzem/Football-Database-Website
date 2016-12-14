<?php
	session_start();
	//echo <script type="text/javascript">window.alert("msssg");></script>;

	function lister($type, $bdd)
	{
		if ($type == "pays"){
			$req = $bdd->query('SELECT * FROM pays');
		} elseif ($type == "clubs") {
			$req = $bdd->query('SELECT * FROM clubs');
		} elseif ($type == "trophes") {
			$req = $bdd->query('SELECT * FROM trophes');
		}
		while ($donnees = $req->fetch()) {
			?> <option value=<?php echo $donnees['id'];?> ><?php echo $donnees['nom'];?></option> <?php
		}
		$req->closeCursor();
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
    
	<?php include("bdd.php");?>
	
    <body>
		
            <header>
			
                <div id="logo">
                        <img src="img/logo.png" alt="Logo legends" />
                        <h1>Football Legends Database</h1>			
                </div>
					
				<nav>
						<ul>
							<li><a href="index.php">Acceuil</a></li>
							<li><a href="joueurs.php">Joueurs</a></li>
							<li><a href="nations.php">Nations</a></li>
							<li><a href="clubs.php">Clubs</a></li>
							<li><a href="trophes.php">Trophés</a></li>
							<li><a href="espaceMembre.php"><img src="img/espaceMembre.png" alt="Espace membre" /></a></li>
						</ul>
				</nav>
             
            </header>
			
			<div id="bloc_espaceMembre">


				<section>
					
					<div id="formulaire">

						<?php

						$afficherFormulaire = true;

						if (isset($_FILES['id']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['annee']) && isset($_POST['poste']) && isset($_POST['note']) && isset($_POST['pays'])  )
						{
							if ($_FILES['id']['error'] == 0 && $_FILES['id']['size'] <= 1000000)
							{
							    $infosfichier = pathinfo($_FILES['id']['name']);
							    $extension_upload = $infosfichier['extension'];
							    $extensions_autorisees = array('png');
							    if (in_array($extension_upload, $extensions_autorisees))
							    {
							    	move_uploaded_file($_FILES['id']['tmp_name'], 'img/joueurs/' . basename($_FILES['id']['name']));

									//On enlève l'extension du nom de fichier
									$extensions = array(".png");
									$suppression = array("");
									$id = str_replace($extensions, $suppression, htmlspecialchars($_FILES['id']['name']) );

									//On vérifie si le joueur n'est pas déja présent
									$req = $bdd->prepare( 'SELECT * FROM Joueurs J WHERE J.id = :id' );
									$req->execute( array('id' => $id ) );
									if ($req->fetch() == NULL)
									{
										$req = $bdd->prepare( 'INSERT INTO Joueurs (id,prenom,nom,annee,poste,note,pays) VALUES(:id, :prenom, :nom, :annee, :poste, :note, :pays)' );
										$req->execute( array('id' => $id, 'prenom' => htmlspecialchars($_POST['prenom']), 'nom' => htmlspecialchars($_POST['nom']), 'annee' => htmlspecialchars($_POST['annee']), 'poste' => htmlspecialchars($_POST['poste']), 'note' => htmlspecialchars($_POST['note']), 'pays' => htmlspecialchars($_POST['pays'])  ) );
										?>
										<h2>Ajout Réussi !</h2>
										<?php
										$afficherFormulaire = false;
									}
									else
									{
									?>
										<h1>Erreur !</h1>
										<h3>Un joueur avec la meme photo est déjà présent, veuillez changer le nom de la photo, ou bien changer de joueur !<h3/>
										<br/>
									<?php
									}
									$req->closeCursor();
								}
								else
								{
								?>
									<h1>Erreur !</h1>
									<h3>Type du fichier non valide ! Utilisez une image .png !<h3/>
									<br/>
								<?php
								}
							}
							else
							{
							?>
								<h1>Erreur !</h1>
								<h3>L'upload du fichier n'a pas réussi, vérifiez que la taille de l'image est inférieur à 1MO !<h3/>
								<br/>
							<?php
							}
						}
						if ($afficherFormulaire)
						{
						?>
							<h2>Ajouter un nouveau joueur :</h2><br />
							<form method="post" action="ajoutJoueur.php" enctype="multipart/form-data">
								<p>							
									<label for="prenom">Prénom du joueur : </label> <br />
										<input type="text" name="prenom" placeholder="Prénom du joueur..." id="prenom" required/>
									<br />
									<br />								
									<label for="nom">Nom du joueur : </label> <br />
										<input type="text" name="nom" placeholder="Nom du joueur..." id="nom" required/>
									<br />
									<br />
									<label for="pays">Pays du joueur : </label> <br />
										<select name="pays" id="pays">
										<?php
											lister("pays",$bdd);
										?>
							       		</select>
									<br />
									<br />
									<label for="poste">Poste du joueur : </label> <br />
										<select name="poste" id="poste">
										<option value="D">Défenseur</option>
										<option value="M">Milieu</option>
										<option value="A">Attaquant</option>
										</select>
									<br />
									<br />	
									<label for="annee">Année de naissance : </label> <br />
										<input type="number" name="annee" placeholder="Année..." id="annee" min=1900 max=2010 required/>
									<br />
									<br />								
																	
									<label for="note">Note sur 100 du joueur : </label> <br />
										<input type="number" name="note" placeholder="Note..." id="note" min=0 max=99 required/>
									<br />
									<br />								

									<label for="id">Photo : </label> <br /><br />
										<input type="file" name="id" id="id" required/>
									<br />
									<br />	
									<br />	
									<input type="submit" value="Ajouter"/>
									<br />
									<br />
								</p>
							</form>

						<?php
						}
						?>
					
					
					</div>
				
				</section>


			</div>
			
			<footer>
				Tous droits réservés - UVSQ 2016
			</footer>
			
    </body>
	
</html>
