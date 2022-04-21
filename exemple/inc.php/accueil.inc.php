<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<h1>Bienvenue</h1>
				<a href="index.php?ref=liste">Voir la liste</a>
				<a href="index.php?ref=saisie">Nouvelle entrée</a>
			</article>
			<p>
				Vous pouvez ici ajouter ou modifier les informations des patients !
			</p>
		</section>
		';
					}
	else die("");
?>
