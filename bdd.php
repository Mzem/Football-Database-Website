	<?php
		if (isset($_SESSION['email']) && $_SESSION['type'] == "normal")
		{
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=Football;charset=utf8', 'Normal', 'normal', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			catch (Exception $e){
					die('Erreur : ' . $e->getMessage());
			}
		}		
		elseif (isset($_SESSION['email']) && $_SESSION['type'] == "admin")
		{
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=Football;charset=utf8', 'Admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			catch (Exception $e){
					die('Erreur : ' . $e->getMessage());
			}
		}
		else
		{
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=Football;charset=utf8', 'Invite', 'invite', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			catch (Exception $e){
					die('Erreur : ' . $e->getMessage());
			}
		}
	?>