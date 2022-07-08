<?php
	if(defined("constante")){
		echo'
		<section id="accueil">
		<div id="bienvenue">
			<h1>Bienvenue sur la base de données du SIHMEL.</h1>
			<h4>Voici un petit tutoriel avant de commencer à utiliser le service web.</h4>
		</div>
		<div id="console"></div>
	<div id="toc">
			<h3 id="sommaire">Sommaire</h3>
	</div>
	<hr/>
	<div id="contents">
			<h1>Nouvelle Entrée</h1>
			<figure>
		  	<figcaption>Si vous souhaitez importer un fichier Excel, rendez vous dans l\'onglet <b>Nouvelle entrée</b>.</figcaption>
  			<a href="images/tuto1.png"><img class="imgTuto" src="images/tuto1.png" alt="Image tuto1" /></a>
			</figure>
			<figure>
				<figcaption>Les données affichées peuvent être éditées par un clic.</figcaption>
				<a href="images/tuto2.png"><img class="imgTuto" src="images/tuto2.png" alt="Image tuto2" /></a>
			</figure>
			<figure>
				<figcaption>Chaque cellule peut aussi être commentée en cliquant sur la bulle, indépendamment de sa valeur.</figcaption>
				<a href="images/tuto3.png"><img class="imgTuto" src="images/tuto3.png" alt="Image tuto3" /></a>
			</figure>
			<figure>
				<figcaption>Il est possible d\'ajouter ou de supprimer des lignes au besoin.</b>.</figcaption>
				<a href="images/tuto4.png"><img class="imgTuto" src="images/tuto4.png" alt="Image tuto4" /></a>
			</figure>
			<figure>
				<figcaption>Lorsque les données sont telles que vous les souhaitez, vous pouvez fusionner le tableau importé avec le reste de la base de données en cliquant sur <b>Sauvegarder</b>.</figcaption>
				<a href="images/tuto5.png"><img class="imgTuto" src="images/tuto5.png" alt="Image tuto5" /></a>
			</figure>
			<h1>Liste des données</h1>
			<figure>
			<figcaption>L\'ensemble des données présentes sur le serveur sont traitables de la même manière dans l\'onglet <b>Voir les données</b>.</figcaption>
			<a href="images/tuto6.png"><img class="imgTuto" src="images/tuto6.png" alt="Image tuto6" /></a>
			<figcaption><i>Ici, toute modification impactera la base commune.</i></figcaption>
			</figure>
			<figure>
				<figcaption>Les données présentes dans cet onglet peuvent être visualisées à l\'aide de graphiques.</figcaption>
				<a href="images/tuto7.png"><img class="imgTuto" src="images/tuto7.png" alt="Image tuto7" /></a>
			</figure>
			<figure>
				<figcaption>Il est aussi possible de rechercher des données par filtres, facilitant ainsi leur étude.</figcaption>
				<a href="images/tuto8.png"><img class="imgTuto" src="images/tuto8.png" alt="Image tuto8" /></a>
			</figure>
			<h1>Mon compte</h1>
			<figure>
				<img class="imgTuto" src="images/workinprogress.jpg" alt="Image workinprogress" />
			</figure>
	</div>
		</section>
<script>


var c = function() {
    return({
        log: function(msg) {
          consoleDiv = document.getElementById("console");
          para = document.createElement("p");
          text = document.createTextNode(msg);
          para.appendChild(text);
          consoleDiv.appendChild(para);
        }
    });
}();

window.onload = function () {
    var toc = "";
    var level = 0;
    var maxLevel = 3;

    document.getElementById("contents").innerHTML =
        document.getElementById("contents").innerHTML.replace(
            /<h([\d])>([^<]+)<\/h([\d])>/gi,
            function (str, openLevel, titleText, closeLevel) {
                if (openLevel != closeLevel) {
				 c.log(openLevel)
                    return str + " - " + openLevel;
                }

                if (openLevel > level) {
                    toc += (new Array(openLevel - level + 1)).join("<ol>");
                } else if (openLevel < level) {
                    toc += (new Array(level - openLevel + 1)).join("</ol>");
                }

                level = parseInt(openLevel);

                var anchor = titleText.replace(/ /g, "_");
                toc += "<li><a href=\"#" + anchor + "\">" + titleText
                    + "</a></li>";

                return "<h" + openLevel + "><a name=\"" + anchor + "\">"
                    + titleText + "</a></h" + closeLevel + ">";
            }
        );

    if (level) {
        toc += (new Array(level + 1)).join("</ol>");
    }

    document.getElementById("toc").innerHTML += toc;
};
</script>
		';
					}
	else die("");
?>
