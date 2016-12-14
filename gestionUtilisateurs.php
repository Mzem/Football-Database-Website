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
							<li class="actuel"><a href="espaceMembre.php"><img src="img/espaceMembre.png" alt="Espace membre" /></a></li>
						</ul>
				</nav>
             
            </header>
			
			<div id="bloc_espaceMembre">


				<section>
					
					<div id="formulaire">
						
						<?php 
						//Par sécurité on vérifie bien que l'utilisateur est un admin
						if (isset($_SESSION['email']) && $_SESSION['type'] == "admin") 
						{
							?>
							<h2>Gestion des droits d'accès des utilisateurs</h2>
							<br/>
							<?php

							if (isset($_POST['type']) && isset($_GET['email']))
							{
								$req = $bdd->prepare( 'SELECT * FROM Utilisateurs U WHERE U.email LIKE :email' );
								$req->execute( array('email' => htmlspecialchars($_GET['email']) ) );
								if ($req->fetch() != NULL)
								{
									$req = $bdd->prepare('UPDATE Utilisateurs SET type = :nouvType WHERE email = :email');
									$req->execute(array(
										'nouvType' => htmlspecialchars($_POST['type']),
										'email' => htmlspecialchars($_GET['email']) 
									));
									?>
										<h3>Type de l'utilisateur "<?php echo htmlspecialchars($_GET['email']); ?>" modifié en "<?php echo htmlspecialchars($_POST['type']); ?>" !</h3>
									<?php
									if (htmlspecialchars($_GET['email']) == $_SESSION['email']){
										$_SESSION['type'] = htmlspecialchars($_POST['type']);
									}
								}
								else
								{
									?>
										<h3>Erreur : l'utilisateur n'existe pas !</h3>
									<?php
								}
								$req->closeCursor();
							}
							else
							{
								$req = $bdd->query( 'SELECT * FROM Utilisateurs ORDER BY email ASC' );
								?>
								<table>
									<tr>
										<th>Email</th>
										<th>Type</th>
									</tr>
								<?php
									while ($user = $req->fetch())
									{
										?>
										<tr>
										<form method="post" action="gestionUtilisateurs.php?email=<?php echo $user['email'];?>">
											<td><?php echo $user['email']; ?></td>
											<td><?php echo $user['type']; ?></td>
											<td><input type="radio" name="type" value="normal" id="normal" checked="checked" /> <label for="normal">Normal</label></td>
											<td><input type="radio" name="type" value="admin" id="admin" /> <label for="admin">Admin</label></td>
											<td><input type="submit" value="Appliquer"/></td>
										</tr>
										</form>
										<?php
									}
									?>
								</table>
								<?php
								$req->closeCursor();
							}	
						}
						else
						{
							?><h3/>Vous n'avez pas le droit d'accéder à ce contenu.</h3><?php
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
