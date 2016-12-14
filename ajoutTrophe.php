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
						if ( isset($_GET['id']) )
						{
							//On verifie que l'id est bon
							$req = $bdd->prepare( 'SELECT * FROM Joueurs J WHERE J.id = :id' );
							$req->execute( array('id' => htmlspecialchars($_GET['id']) ) );
							if ($donnees = $req->fetch())
							{
								$req->closeCursor();
								$afficherFormulaire = true;

								if (isset($_POST['trophe']) && isset($_POST['annee']) )
								{
									$req = $bdd->prepare( 'SELECT * FROM Remporte WHERE joueur = :id AND trophe = :troph AND annee = :annee' );
									$req->execute( array(	'id' => htmlspecialchars($_GET['id']),
															'troph' => htmlspecialchars($_POST['trophe']),
															'annee' => htmlspecialchars($_POST['annee']),
														) );
									if (!$req->fetch())
									{
										$req->closeCursor();
										$req = $bdd->prepare( 'INSERT INTO Remporte (joueur,trophe,annee) VALUES(:id, :troph, :annee)' );
										$req->execute( array(	'id' => htmlspecialchars($_GET['id']),
																'troph' => htmlspecialchars($_POST['trophe']),
																'annee' => htmlspecialchars($_POST['annee']),
															) );
										?>
										<h2>Ajout Réussi !</h2>
										<?php
										$afficherFormulaire = false;
									}
									else
									{	
										$req->closeCursor();
									?>
										<h1>Erreur !</h1>
										<h3>Le joueur avait déjà remporté ce trophé cette année !<h3/>
									<?php
									}
									$req->closeCursor();
								}
								elseif ($afficherFormulaire)
								{
								?>
									<h2>Ajouter un nouveau trophé pour le joueur <?php echo $donnees['prenom'].' '.$donnees['nom']; ?> :</h2><br />
									<form method="post" action="ajoutTrophe.php?id=<?php echo $_GET['id'];?>">
										<p>							
											<label for="trophe">Trophé : </label> <br />
												<select name="trophe" id="trophe">
												<?php
													lister("trophes",$bdd);
												?>
									       		</select>
											<br />
											<br />
											<label for="annee">Année : </label> <br />
												<input type="number" name="annee" id="annee" min=1900 max = 2100 required/>
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
							}
							else
							{
								$req->closeCursor();
								?>
									<h1>Erreur !</h1>
									<h3>Veuillez préciser un joueur existant !<h3/>
								<?php
							}
						}
						else
						{
							?>
								<h1>Erreur !</h1>
								<h3>Veuillez préciser un joueur !<h3/>
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
