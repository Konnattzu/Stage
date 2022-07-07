<?php
if(isset($_GET) && isset($_GET["ref"])) {
            $page = $_GET["ref"];
        }
      echo '<nav id="'.$page.'-nav">
        	<ul id="divAccueil">
        		<li id="btn_accueil"><a href="index.php?ref=accueil">Accueil</a></li>
        	</ul>
        	<ul id="divNormale">
        		<li class="btn_nav" ><a href="index.php?ref=saisie"><div id="Sactive">Nouvelle Entrée</div></a></li>
        		<li class="btn_nav" id="liste" ><a href="index.php?ref=liste"><div id="Lactive">Liste des données</div></a></li>
        	</ul>
        	<ul id="divConnect">
        		<li id="btn_connect"><a href="index.php?ref=compte">Mon compte</a></li>
        	</ul>
        </nav>';
?>
