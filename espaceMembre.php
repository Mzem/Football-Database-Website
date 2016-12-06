<?php
	session_start();
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
							<li class="actuel"><a href="espaceMembre.php"><img src="img/espaceMembre.png" alt="Espace membre" /></a></li>
						</ul>
				</nav>
             
            </header>
			
			<div id="bloc_espaceMembre">


				<section>
					
					<div id="formulaire">
					
					
					<?php

					//Traitement d'un ajout aux favoris
					if ( isset($_GET['joueur']) ){
						$reqJr = $bdd->prepare( 'SELECT * FROM Joueurs WHERE id = :id' );
						$reqJr->execute( array(':id' => htmlspecialchars($_GET['joueur']) ) );
						if ($reqJr->fetch() != NULL)
						{
							$reqFav = $bdd->prepare( 'UPDATE Utilisateurs SET joueur = :id WHERE email LIKE :email' );
							$reqFav->execute( array('id' => $_GET['joueur'], 'email' => $_SESSION['email'] ) );
							$_SESSION['joueur'] = $_GET['joueur'];
							$reqFav->closeCursor();
						}
						$reqJr->closeCursor();
					}
					elseif ( isset($_GET['club']) ){
						$reqC = $bdd->prepare( 'SELECT * FROM clubs WHERE id = :id' );
						$reqC->execute( array(':id' => htmlspecialchars($_GET['club']) ) );
						if ($reqC->fetch() != NULL)
						{
							$reqFav = $bdd->prepare( 'UPDATE Utilisateurs SET club = :id WHERE email LIKE :email' );
							$reqFav->execute( array('id' => $_GET['club'], 'email' => $_SESSION['email'] ) );
							$_SESSION['club'] = $_GET['club'];
							$reqFav->closeCursor();
						}
						$reqC->closeCursor();
					}
					elseif ( isset($_GET['pays']) ){
						$reqP = $bdd->prepare( 'SELECT * FROM pays WHERE id = :id' );
						$reqP->execute( array(':id' => htmlspecialchars($_GET['pays']) ) );
						if ($reqP->fetch() != NULL)
						{
							$reqFav = $bdd->prepare( 'UPDATE Utilisateurs SET pays = :id WHERE email LIKE :email' );
							$reqFav->execute( array('id' => $_GET['pays'], 'email' => $_SESSION['email'] ) );
							$_SESSION['pays'] = $_GET['pays'];
							$reqFav->closeCursor();
						}
						$reqP->closeCursor();
					}


					//Verification si le joueur s'inscrit ou se connecte
					$afficherFormulaire = true;

					if ( isset($_POST['emailInscription']) && isset($_POST['passInscription1']) && isset($_POST['passInscription2']) )
					{
						//On vérifie que l'utilisateur n'est pas déja inscrit
						$req = $bdd->prepare( 'SELECT * FROM Utilisateurs U WHERE U.email LIKE :email' );
						$req->execute( array('email' => htmlspecialchars($_POST['emailInscription']) ) );
						if ($req->fetch() == NULL)
						{
							$req = $bdd->prepare( 'INSERT INTO Utilisateurs (email, pass) VALUES(:email, :pass)' );
							$req->execute( array('email' => htmlspecialchars($_POST['emailInscription']), 'pass' => htmlspecialchars($_POST['passInscription1']) ) );
							$_SESSION['email'] = htmlspecialchars($_POST['emailInscription']);
							$_SESSION['type'] = "normal";
							$_SESSION['joueur'] = NULL;
							$_SESSION['club'] = NULL;
							$_SESSION['pays'] = NULL;
						?>
							<h2>Inscription Réussie !</h2>
							<h3>Bienvenue <?php echo $_SESSION['email']; ?> !</h3>
						<?php
							$afficherFormulaire = false;
						}
						else
						{
						?>
							<h1>EMAIL DÉJÀ UTILISÉ !<h1/>
						<?php
						}
						$req->closeCursor();
					}
					elseif ( isset($_POST['emailConnection']) && isset($_POST['passConnection']) )
					{
						$req = $bdd->prepare( 'SELECT * FROM Utilisateurs U WHERE U.email LIKE :email AND U.pass LIKE :pass' );
						$req->execute( array('email' => htmlspecialchars($_POST['emailConnection']), 'pass' => htmlspecialchars($_POST['passConnection']) ) );
						if ($donnees = $req->fetch())
						{
							$_SESSION['email'] = htmlspecialchars($_POST['emailConnection']);
							$_SESSION['type'] = $donnees['type'];
							$_SESSION['pays'] = $donnees['pays'];
							$_SESSION['club'] = $donnees['club'];
							$_SESSION['joueur'] = $donnees['joueur'];
						?>
							<h2>BIENVENUE !</h2>
						<?php
							$afficherFormulaire = false;
						}
						else
						{
						?>
							<h1>EMAIL OU MOT DE PASSE INCORRECT !<h1/>
						<?php
						}
						$req->closeCursor();
					}

					//Si l'utilisateur est deja connecté
					if ( isset($_SESSION['email']) )
					{
						?>
							<h2>Espace Membre</h2>
							<h3>Email : <?php echo $_SESSION['email']; ?> </h3>
							<!-- Affichage des favoris -->
							<br/>
							<?php if ($_SESSION['joueur']!=NULL) { ?>
								<img src="img/joueurs/<?php echo $_SESSION['joueur']; ?>.png" />
								<br/>
							<?php
							}
							if ($_SESSION['club']!=NULL) { ?>
								<img src="img/clubs/<?php echo $_SESSION['club']; ?>.png" />
								<br/>
							<?php
							}
							if ($_SESSION['pays']!=NULL) { ?>	
								<img src="img/nations/<?php echo $_SESSION['pays']; ?>.png" />
								<br/>
							<?php
							}
							?>
							<br/>
							<br/>

							<?php
							//Si l'utilisateur a fait une demande de modification du mot de passe, on le met à jour si tout est bon
							if ( isset( $_POST['nouvPass1']) )
							{
								$req = $bdd->prepare( 'SELECT * FROM Utilisateurs U WHERE U.email LIKE :email AND U.pass LIKE :pass' );
								$req->execute( array('email' => htmlspecialchars($_SESSION['email']), 'pass' => htmlspecialchars($_POST['ancienPass']) ) );
								if ($req->fetch() != NULL)
								{
									$req = $bdd->prepare('UPDATE Utilisateurs SET pass = :nouvPass WHERE email = :email');
									$req->execute(array(
										'nouvPass' => htmlspecialchars($_POST['nouvPass1']),
										'email' => htmlspecialchars($_SESSION['email']) 
									));
									?>
										<h3>Mot de passe modifié !</h3>
									<?php
								}
								else
								{
									?>
										<h3>Erreur modification mot de passe !</h3>
									<?php
								}
								$req->closeCursor();
							}
							?>

							<!-- Formulaire modification mot de passe -->
							<form method="post" action="espaceMembre.php">
								<label for="ancienPass">Ancien mot de passe : </label> <br />
									<input type="password" name="ancienPass" placeholder="Ancien mot de passe..." id="ancienPass" required/>
									<br />
									<br />
								<label for="nouvPass1">Nouveau mot de passe : </label> <br />
									<input type="password" name="nouvPass1" placeholder="Nouveau mot de passe..." id="nouvPass1"  required onchange="form.nouvPass2.pattern = this.value;"/>
									<br />
									<br />
								<label for="nouvPass2">Retapez le mot de passe : </label> <br />
									<input type="password" name="nouvPass2" placeholder="Retapez le mot de passe..." id="nouvPass2"  required/>
									<br />
									<br />
								<input type="submit" value="Modifier le mot de passe"/>
							</form>
							<br/>
							<br/>

							<!-- Déconnection -->
							<form method="post" action="acceuil.php">
								<input type="submit" value="Déconnection" name="deconnection"/>
							</form>
							
						<?php
					}
					elseif ($afficherFormulaire)
					{
					?>
						<h2>Connection</h2>
						<form method="post" action="espaceMembre.php">
							<p>
								<label for="emailConnection">Email : </label> <br />
									<input type="email" name="emailConnection" placeholder="Votre email..." id="emailConnection" required/>
								<br />
								<br />
								<label for="passConnection">Mot de passe : </label> <br />
									<input type="password" name="passConnection" placeholder="Votre mot de passe..." id="passConnection" required/>
								<br />
								<br />
								<input type="submit" value="Connection"/>
								<br />
								<br />
							</p>
						</form>
							
						<h2>Nouveau ? Inscription</h2>
						<form method="post" action="espaceMembre.php">
							<p>
								<label for="emailInscription">Email : </label> <br />
									<input type="email" name="emailInscription" placeholder="Votre email..." id="emailInscription" required/>
								<br />
								<br />
								<label for="passInscription1">Mot de passe : </label> <br />
									<input type="password" name="passInscription1" placeholder="Votre mot de passe..." id="passInscription1" required onchange="form.passInscription2.pattern = this.value;"/>
								<br />
								<br />
								<label for="pass">Retapez le mot de passe : </label> <br />
									<input type="password" name="passInscription2" placeholder="Retapez le mot de passe..." id="passInscription2" required/>
								<br />
								<br />
								<input type="submit" value="Inscription"/>
							</p>
						</form>
					
					
					<?php
					}
					?>
					
					
					</div>
					<br />
					<br />
					
					<?php if (isset($_SESSION['email']) && $_SESSION['type'] == "admin") { ?>
						<div id="gestion">	
						<br/>
						<a href="gestionUtilisateurs.php"><h2>GESTION DES UTILISATEURS</h2></a>
						<br/>
						</div>
					<?php
					}
					?>
						
						
				</section>


			</div>
			
			<footer>
				Tous droits réservés - UVSQ 2016
			</footer>
			
    </body>
	
</html>
