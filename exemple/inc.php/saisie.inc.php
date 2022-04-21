<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=liste">Voir la liste</a>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
			</article>
			<form action="" method="post">
				<input type="text" name="nom" placeholder="Nom du patient...">
				<input type="submit" name="submit" value="Ajouter"
			</form>
		</section>
		';			
		}
	else die("");
?>
