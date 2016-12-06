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
    
	<?php
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=Football;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exception $e){
				die('Erreur : ' . $e->getMessage());
		}
	?>
	
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

								if (isset($_POST['club']) && isset($_POST['anneeD']) )
								{
									
									if ( isset($_POST['anneeF']) && htmlspecialchars($_POST['anneeF']) != NULL  ){
										$anneeF = htmlspecialchars($_POST['anneeF']);
									} else {
										$anneeF = 3000;	//càd club actuel
									}
									
									//On vérifie si la période donnée est cohérente
									$req = $bdd->prepare( 'SELECT * FROM Joue J WHERE J.joueur = :id' );
									$req->execute( array('id' => htmlspecialchars($_GET['id']) ) );
									$possible = true;
									while ($AF = $req->fetch())
									{
										if ($_POST['anneeD'] < $AF['anneeFin'] && $AF['anneeFin'] != 3000 ){
											$possible = false;
										}
									}
									$req->closeCursor();
									if ($possible && $_POST['anneeD'] <= $anneeF)
									{
										//Si il joue actuellement dans un club, sa date de fin va etre changée
										$req = $bdd->prepare( 'SELECT * FROM Joue J WHERE J.joueur = :id' );
										$req->execute( array('id' => htmlspecialchars($_GET['id']) ) );
										while ($AF = $req->fetch())
										{
											if ($AF['anneeFin'] == 3000){
												$reqA = $bdd->prepare( 'UPDATE Joue SET anneeFin = :fin WHERE joueur = :id AND club = :club AND anneeDebut = :debut' );
												$reqA->execute( array(	'fin' => htmlspecialchars($_POST['anneeD']),
																		'id' => htmlspecialchars($_GET['id']),
																		'club' => $AF['club'],
																		'debut' => $AF['anneeDebut'],
																		) );
												$reqA->closeCursor();
											}
											break;
										}
										$req->closeCursor();

										$req = $bdd->prepare( 'INSERT INTO Joue (joueur,club,anneeDebut,anneeFin) VALUES(:id, :club, :debut, :fin)' );
										$req->execute( array(	'id' => htmlspecialchars($_GET['id']), 
																'club' => htmlspecialchars($_POST['club']),
																'debut' => htmlspecialchars($_POST['anneeD']),
																'fin' => $anneeF
															) );
										?>
										<h2>Ajout Réussi !</h2>
										<?php
										$afficherFormulaire = false;
									}
									else
									{
									?>
										<h1>Erreur !</h1>
										<h3>Le joueur avait déjà un club affecté pendant cette période (ou la période est incorrecte) !<h3/>
									<?php
									}
									$req->closeCursor();
								}
								elseif ($afficherFormulaire)
								{
								?>
									<h2>Ajouter un nouveau club pour le joueur <?php echo $donnees['prenom'].' '.$donnees['nom']; ?> :</h2><br />
									<form method="post" action="ajoutClub.php?id=<?php echo $_GET['id'];?>">
										<p>							
											<label for="club">Club : </label> <br />
												<select name="club" id="club">
												<?php
													lister("clubs",$bdd);
												?>
									       		</select>
											<br />
											<br />
											<label for="anneeD">Année de début : </label> <br />
												<input type="number" name="anneeD" id="anneeD" min=1900 max = 2100 required/>
											<br />
											<br />								
											<label for="anneeF">Année de fin : </label> <br />
												<input type="number" name="anneeF" id="anneeF" min=1900 max = 2100/><br />
											<label for="anneeF">(laisser vide si c'est le club actuel)</label> 
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
