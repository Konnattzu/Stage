<?php
echo'<section>
      <div id="parent">
<!-- component container -->
<div id="form">
            <div id="croix" onclick="closeForm()">&#10060;</div>
            <form>
                <label>Entrer le nombre de lignes</label>
                <input id="ligne" type="number" min="1" placeholder="nombre de lignes">
            </form>
        </div>
<div id="layout" style="height: 100%;">

</div>
<div id="chart"></div>
</div>
<script>
function redim(){
  if(window.innerWidth>1100){
    document.getElementById("layout").style.width = "50vw";
    document.getElementById("chart").style.width = "50vw";
    document.getElementById("parent").style.display = "flex";
  }else{
    document.getElementById("layout").style.width = "100vw";
    document.getElementById("chart").style.width = "100vw";
    document.getElementById("parent").style.display = "block";
  }
}

  var datasetmenu = [
    {
        "id": "file",
        "value": "Fichier",
        "items": [';
		if($_SESSION["currentpage"] == "saisie") {
            echo'{ "id": "fileOpen", "value": "Ouvrir", "icon": "dxi dxi-folder-open" },';
		}
            echo'{ "id": "fileDownload", "value": "Télécharger", "icon": "dxi dxi-download",

            "items": [
              {
                  id: "impXlsx",
                  type: "button",
                  circle: true,
                  value: "Télécharger en xlsx",
                  size: "small",
                  icon: "dxi dxi-download",
                  full: true
              },


              {
                  id: "impcsv",
                  type: "button",
                  circle: true,
                  value: "Télécharger en csv",
                  size: "small",
                  icon: "dxi dxi-download",
                  full: true
              }
            ]
          }
        ]
    },';
    $balise1= "<img class='menu-item' src='https://snippet.dhtmlx.com/codebase/data/menu/03/img/chart-pie.svg'/><span class='dhx_nav-menu-button__text'>Graphiques</span>";
    $balise2= "<span class='dhx_menu-button__text'> Sankey</span>";
    $balise2_a= "<div class='dhx_menu-button__text btnchart' onclick='Hsimple()'><span class='dhx_menu-button__text' > Simple</span></div>";
    $balise2_b= "<div class='dhx_menu-button__text btnchart' onclick='Hempile()'><span class='dhx_menu-button__text' > Empilée</span></div>";
    $balise2_c= "<div class='dhx_menu-button__text btnchart' onclick='Hhorizontal()'><span class='dhx_menu-button__text' > Horizontale</span></div>";
	$balise3= "<span class='dhx_menu-button__text'> Kaplan</span>";
    $balise3_a= "<div class='dhx_menu-button__text btnchart' onclick='Ganneau()'><span class='dhx_menu-button__text' > Anneau</span></div>";
    $balise3_b= "<div class='dhx_menu-button__text btnchart' onclick='Gradar()'><span class='dhx_menu-button__text' > Radar</span></div>";
    $balise3_c= "<div class='dhx_menu-button__text btnchart' onclick='Gsecteur()'><span class='dhx_menu-button__text' > Secteur</span></div>";
    $balise4= "<img class='menu-item context-menu-item' src='https://snippet.dhtmlx.com/codebase/data/menu/03/img/chart-spline.svg'/><span class='dhx_menu-button__text'> Courbe</span>";
	$balise4_a= "<div class='dhx_menu-button__text btnchart' onclick='Gaire()'><span class='dhx_menu-button__text' > Aires</span></div>";
    $balise4_b= "<div class='dhx_menu-button__text btnchart' onclick='Gcourbe()'><span class='dhx_menu-button__text' > Courbe</span></div>";
    $balise4_c= "<div class='dhx_menu-button__text btnchart' onclick='Gnuage()'><span class='dhx_menu-button__text' > Nuage de points</span></div>";
	$balise5 = "<span class='dhx_menu-button__text'> Ajouter une/des lignes</span>";
    $balise6 = "<span class='dhx_menu-button__text' onclick='openForm()'> Ajouter plusieurs lignes</span>";
    if($_SESSION["currentpage"] == "liste") {
    echo'{
        "id": "charts",
        "html": "'.$balise1.'",
        "items": [
            {
                "id": "sankey",
                "html": "'.$balise2.'"
            },
            {
                "id": "kaplan",
                "html": "'.$balise3.'"
            }

                ]
            },';
        }
            echo'
    {
        "id": "lignes",
        "html": "'.$balise5.'",
        "items": [
        {
            id: "add",
            type: "button",
            circle: true,
            value: "Ajouter une ligne",
            size: "small",
            icon: "mdi mdi-plus",
            full: true
        },
        {
            id: "addmore",
            icon: "dxi dxi-plus",
            "html": "'.$balise6.'"
        }
    ]}';
    if($_SESSION["currentpage"] == "saisie") {
      echo',
    {
        id: "savetable",
        type: "button",
        circle: true,
        value: "Sauvegarder",
        size: "small",
        icon: "dxi dxi-content-save",
        full: true
    }';
    }
echo']
const menu = new dhx.Menu("menu", {
css: "dhx_widget--bg_white dhx_widget--bordered"
});
menu.data.parse(datasetmenu);

// Layout initialization
const layout = new dhx.Layout("layout", {
cols: [
  {
      rows: [
          {
              id: "menu",
              height: "content"
          },
          {
              type: "space",
              rows: [
                  {
                      id: "grid"
                  }
              ]
          }
      ]
  }
]
});
var timer = -1;
menu.events.on("click", function (id) {
if (id === "add") {
  const newId = grid.data.add({';
  if($_SESSION["currentpage"] != "saisie" || isset($_SESSION["csv"])) {
    if(isset($header)){
        for($i=0;$i<count($header)-1;$i++){
            echo $header[$i].': "",';
        }
        echo $header[$i].': "",';
    }
  }
 echo'});
dhx.message({
        text: "Une ligne a été ajoutée.", // the text content
    });
    timer++;
    setTimeout(function(){
        document.getElementsByClassName("dhx_message")[timer].remove();
        timer--;
    }, 2000);
}

//export xlsx
if (id === "impXlsx") {
    grid.export.xlsx({
      url: "https://export.dhtmlx.com/excel"
  });
}
//export csv
if (id === "impcsv") {
grid.export.csv();
}
/*import file*/
if (id === "fileOpen") {
let input = document.createElement("input");
  input.type = "file";
  input.onchange = _ => {

            let files = Array.from(input.files);
			var data = new FormData();

		data.append("table", input.files[0]);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				console.log(request);
				fileresults = request.responseText;
				console.log(request.responseText);
				window.location.reload();
			}
		}
		request.open("POST", "inc.php/parts/table_upload.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);
        };
  input.click();
}
});

layout.getCell("menu").attach(menu);
';
if($_SESSION["currentpage"] != "saisie" || isset($_SESSION["csv"])) {
    if(isset($header)&&isset($header[0]) && isset($array) && isset($array[0])){
echo'
// initializing Grid for data vizualization
const grid = new dhx.Grid(null, {
css: "dhx_demo-grid",
columns: [
  {
      width: 75, id: "action", gravity: 1.5, header: [{ text: "Actions", align: "center" }],
      htmlEnable: true, align: "center",
      editable: false,
      autoWidth: false,
      template: function () {';
			$span = "<span class='action-buttons'><a class='remove-button noselect' title='Supprimer'>&#10060;</a></span>";
          echo'return "'.$span.'";
      }
	  },';
      if(isset($header)){
		for($i=0;$i<count($header)-1;$i++){
				echo '{ width: 150, id: "'.$header[$i].'", header: [{ text: "'.$header[$i].'", class: "numb"}, {content: "selectFilter"}], editable: true';
                if($table->getCol()[$i]->getType() == "date"){
                    echo', type: "date", dateFormat: "%Y-%m-%d"';
                }else if($table->getCol()[$i]->getType() == "int"){
                    echo', type: "number"';
                }else if($table->getCol()[$i]->getType() == "enum"){
                    echo', editorType: "combobox", options: ['.$table->getCol()[$i]->getLen().']';
                }else if($table->getCol()[$i]->getType() == "tinyint"){
                    echo', type: "boolean"';
                }
                echo' }, ';
		}
			echo '{ width: 150, id: "'.$header[$i].'", header: [{ text: "'.$header[$i].'"}, {content: "selectFilter"}], editable: true';
            if($table->getCol()[$i]->getType() == "date"){
                echo', type: "date", dateFormat: "%Y-%m-%d"';
            }else if($table->getCol()[$i]->getType() == "int"){
                echo', type: "number"';
            }else if($table->getCol()[$i]->getType() == "enum"){
                echo', editorType: "combobox", options: ['.$table->getCol()[$i]->getLen().']';
            }else if($table->getCol()[$i]->getType() == "tinyint"){
                echo', type: "boolean"';
            }
            echo' }';
        }
    echo'
],
autoWidth: true,
editable: true,
eventHandlers: {
  onclick: {
      "remove-button": function (e, data) {
          grid.data.remove(data.row.id);
      }
  }
}
});

//import test

function importXlsx() {
    grid.load("", "xlsx"); // loads data from a .xlsx file
}
// loading data into Grid
// loading data into Grid
database = ';
include("inc.php/parts/data.inc.php");
echo';
grid.data.parse(database);

// attaching widgets to Layout cells
layout.getCell("grid").attach(grid);

//--------------------------------------------Scripts pour charger les charts---------------------------------------------
document.addEventListener("DOMContentLoaded", (event) => {
    console.log("DOM fully loaded and parsed");
});
//Histogramme simple
function Hsimple(){
//rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
  window.onload = reloadUsingLocationHash();
  window.onresize = redim;
      //rechargement du graphe
  const data = database;




          const config = {
    type: "bar",
    css: "dhx_widget--bg_white dhx_widget--bordered",
    scales: {
        "bottom": {
                      text: "'.$header[0].'"
                  },
                  "left": {
                      maxTicks: 10,
                      max: ';
          				$maxval = 1;
          				for($i=0;$i<count($header);$i++){
          					for($j=0;$j<$row;$j++){
          						if(intval($array[$nbcol[$i]][$j]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][$j]) && $i > 0){
          							if($array[$nbcol[$i]][$j] > $maxval*1.2){
          								$maxval = $array[$nbcol[$i]][$j];
          							}
          						}
          					}
          				}
          				echo $maxval*1.2;
          			echo',
                      min: 0
                  }
              },

              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#81C4E8", fill: "#81C4E8" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#8E4C18", fill: "#8E4C18" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '"'.$header[$j].'", ';
          			}
          		}
          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          			echo '"'.$header[$j].'"';
          		}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
          };

          const chart = new dhx.Chart("chart", config);
		  chart.data.parse(data);
		  document.getElementById("layout").style.width = "50vw";
		  document.getElementById("chart").style.width = "50vw";
		  document.getElementById("parent").style.display = "flex";
}

//Histogramme empile
function Hempile(){
  //rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
    window.onload = reloadUsingLocationHash();
	window.onresize = redim;
    //rechargement du graphe
    const data = database;

  		 function getConfig(stacked) {
  	    return {
  	        type: "bar",
  	        css: "dhx_widget--bg_white dhx_widget--bordered",
  	        scales: {
  	            "bottom": {
                      text: "'.$header[0].'"
                  },
                  "left": {
                      maxTicks: 10,
                      max: ';
          				$maxval = 1;
          				for($i=0;$i<count($header);$i++){
          					for($j=0;$j<$row;$j++){
          						if(intval($array[$nbcol[$i]][$j]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][$j]) && $i > 0){
          							if($array[$nbcol[$i]][$j] > $maxval*1.2){
          								$maxval = $array[$nbcol[$i]][$j];
          							}
          						}
          					}
          				}
          				echo $maxval*2.4;
          			echo',
                      min: 0
                  }
              },

              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#81C4E8", fill: "#81C4E8", stacked: stacked, color: "none" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#8E4C18", fill: "#8E4C18", stacked: stacked, color: "none" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '"'.$header[$j].'", ';
          			}
          		}
          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          			echo '"'.$header[$j].'"';
          		}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
  	    }
  	}

  	let stacked = true;
    const chart = new dhx.Chart("chart", getConfig(stacked));
  chart.data.parse(data);
  document.getElementById("layout").style.width = "50vw";
  document.getElementById("chart").style.width = "50vw";
  document.getElementById("parent").style.display = "flex";
}

//Histogramme Horizontal
function Hhorizontal(){
  //rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
  window.onload = reloadUsingLocationHash();
  window.onresize = redim;
      //rechargement du graphe
  const data = database;




          const config = {
    type: "xbar",
    css: "dhx_widget--bg_white dhx_widget--bordered",
    scales: {
        "bottom": {
			maxTicks: 10,
                      max: ';
          				$maxval = 1;
          				for($i=0;$i<count($header);$i++){
          					for($j=0;$j<$row;$j++){
          						if(intval($array[$nbcol[$i]][$j]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][$j]) && $i > 0){
          							if($array[$nbcol[$i]][$j] > $maxval*1.2){
          								$maxval = $array[$nbcol[$i]][$j];
          							}
          						}
          					}
          				}
          				echo $maxval*1.2;
          			echo',
                      min: 0
                  },
                  "left": {
                      text: "'.$header[0].'"

                  }
              },

              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#81C4E8", fill: "#81C4E8" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#8E4C18", fill: "#8E4C18" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '"'.$header[$j].'", ';
          			}
          		}
          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          			echo '"'.$header[$j].'"';
          		}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
          };

          const chart = new dhx.Chart("chart", config);
  		chart.data.parse(data);
      document.getElementById("layout").style.width = "50vw";
      document.getElementById("chart").style.width = "50vw";
      document.getElementById("parent").style.display = "flex";
}

//Graphique Anneau
function Ganneau(){
//rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
  window.onload = reloadUsingLocationHash();
  window.onresize = redim;
      //rechargement du graphe
  const data = database;




          const config = {
    type: "donut",
    css: "dhx_widget--bg_white dhx_widget--bordered",


              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#81C4E8", fill: "#81C4E8" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#8E4C18", fill: "#8E4C18" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '"'.$header[$j].'", ';
          			}
          		}
          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          			echo '"'.$header[$j].'"';
          		}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
          };

          const chart = new dhx.Chart("chart", config);
		  chart.data.parse(data);
		  document.getElementById("layout").style.width = "50vw";
		  document.getElementById("chart").style.width = "50vw";
		  document.getElementById("parent").style.display = "flex";
}

//Graphique Radar
function Gradar(){
//rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
  window.onload = reloadUsingLocationHash();
  window.onresize = redim;
      //rechargement du graphe
  const data = database;




          const config = {
    type: "radar",
    css: "dhx_widget--bg_white dhx_widget--bordered",
    scales: {
        "radial": {
                      value: "'.$header[0].'",
                      maxTicks: 10
                  }
              },

              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#81C4E8", fill: "#81C4E8" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#8E4C18", fill: "#8E4C18" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '"'.$header[$j].'", ';
          			}
          		}
          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          			echo '"'.$header[$j].'"';
          		}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
          };

          const chart = new dhx.Chart("chart", config);
		  chart.data.parse(data);
		  document.getElementById("layout").style.width = "50vw";
		  document.getElementById("chart").style.width = "50vw";
		  document.getElementById("parent").style.display = "flex";
}

//Graphique Secteur
function Gsecteur(){
//rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
  window.onload = reloadUsingLocationHash();
  window.onresize = redim;
      //rechargement du graphe
  const data = database;




          const config = {
    type: "pie",
    css: "dhx_widget--bg_white dhx_widget--bordered",


              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#81C4E8", fill: "#81C4E8" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#8E4C18", fill: "#8E4C18" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '"'.$header[$j].'", ';
          			}
          		}
          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          			echo '"'.$header[$j].'"';
          		}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
          };

          const chart = new dhx.Chart("chart", config);
		  chart.data.parse(data);
		  document.getElementById("layout").style.width = "50vw";
		  document.getElementById("chart").style.width = "50vw";
		  document.getElementById("parent").style.display = "flex";
}

//Graphique en Aire
function Gaire(){
//rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
  window.onload = reloadUsingLocationHash();
  window.onresize = redim;
      //rechargement du graphe
  const data = database;




          const config = {
    type: "area",
    css: "dhx_widget--bg_white dhx_widget--bordered",
    scales: {
        "bottom": {
                      text: "'.$header[0].'"
                  },
                  "left": {
                      maxTicks: 10,
                      max: ';
          				$maxval = 1;
          				for($i=0;$i<count($header);$i++){
          					for($j=0;$j<$row;$j++){
          						if(intval($array[$nbcol[$i]][$j]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][$j]) && $i > 0){
          							if($array[$nbcol[$i]][$j] > $maxval*1.2){
          								$maxval = $array[$nbcol[$i]][$j];
          							}
          						}
          					}
          				}
          				echo $maxval*1.2;
          			echo',
                      min: 0
                  }
              },

              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#81C4E8", fill: "#81C4E8" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#8E4C18", fill: "#8E4C18" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '"'.$header[$j].'", ';
          			}
          		}
          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          			echo '"'.$header[$j].'"';
          		}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
          };

          const chart = new dhx.Chart("chart", config);
		  chart.data.parse(data);
		  document.getElementById("layout").style.width = "50vw";
		  document.getElementById("chart").style.width = "50vw";
		  document.getElementById("parent").style.display = "flex";
}
//Graphique Courbe
function Gcourbe(){
//rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
  window.onload = reloadUsingLocationHash();
  window.onresize = redim;
      //rechargement du graphe
  const data = database;

          const config = {
    type: "line",
    css: "dhx_widget--bg_white dhx_widget--bordered",
    scales: {
        "bottom": {
                      text: "'.$header[0].'"
                  },
                  "left": {
                      maxTicks: 10,
                      max: ';
          				$maxval = 1;
          				for($i=0;$i<count($header);$i++){
          					for($j=0;$j<$row;$j++){
          						if(intval($array[$nbcol[$i]][$j]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][$j]) && $i > 0){
          							if($array[$nbcol[$i]][$j] > $maxval*1.2){
          								$maxval = $array[$nbcol[$i]][$j];
          							}
          						}
          					}
          				}
          				echo $maxval*1.2;
          			echo',
                      min: 0
                  }
              },

              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#81C4E8", fill: "#81C4E8" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '{ id: "'.$header[$j].'", value: "'.$header[$j].'", color: "#8E4C18", fill: "#8E4C18" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          				echo '"'.$header[$j].'", ';
          			}
          		}
          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
          			echo '"'.$header[$j].'"';
          		}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
          };

          const chart = new dhx.Chart("chart", config);
		  chart.data.parse(data);
		  document.getElementById("layout").style.width = "50vw";
		  document.getElementById("chart").style.width = "50vw";
		  document.getElementById("parent").style.display = "flex";
}

//Graphique Nuage
function Gnuage(){
//rechargement du graphe
  var parent=document.getElementById("chart");
  console.log(parent);
  var enfant=document.getElementById("chart").childNodes[0];
  console.log(enfant);
  if(typeof(enfant)!= "undefined"){
  parent.removeChild(enfant);
  }
  const reloadUsingLocationHash = () => {
      window.location.hash = "chart";
    }
  window.onload = reloadUsingLocationHash();
  window.onresize = redim;
      //rechargement du graphe
  const data = database;


          const config = {
    css: "dhx_widget--bg_white dhx_widget--bordered",
    scales: {
        "bottom": {
                      title: "'.$header[count($header)-1].'",
					  max: ';
          				$maxval = 1;
          				for($i=0;$i<count($header);$i++){
          					for($j=0;$j<$row;$j++){
          						if(intval($array[$nbcol[$i]][$j]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][$j]) && $i > 0){
          							if($array[$nbcol[$i]][$j] > $maxval*1.2){
          								$maxval = $array[$nbcol[$i]][$j];
          							}
          						}
          					}
          				}
          				echo $maxval*1.2;
          			echo',
                      min: 0,
					  scalePadding: 25
                  },
                  "left": {
                      maxTicks: 10,
                      title: "';
					  $find = false;
					  for($j=0;$j<count($header)-1;$j++){
						if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0 && $find == false){
							echo $header[$j];
							$find = true;
						}
					  }
					  echo'",
                      max: ';
          				$maxval = 1;
          				for($i=0;$i<count($header);$i++){
          					for($j=0;$j<$row;$j++){
          						if(intval($array[$nbcol[$i]][$j]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][$j]) && $i > 0){
          							if($array[$nbcol[$i]][$j] > $maxval*1.2){
          								$maxval = $array[$nbcol[$i]][$j];
          							}
          						}
          					}
          				}
          				echo $maxval*1.2;
          			echo',
                  }
              },

              series: [';
          		for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
						$val1 = $header[$j];
						if(isset($header[$j+1])){
					$taken = false;
							for($i=$j+1;$i<count($header);$i++){
								if(intval($array[$nbcol[$i]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][0]) && $i > 0){
									$val2 = $header[$i];
									$taken = true;
								}
								if($taken == false){
									for($k=$j-1;$k>0;$k--){
										if(intval($array[$nbcol[$k]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$k]][0]) && $k > 0){
											$val2 = $header[$k];
										}
									}
								}
							}
						}else{
							for($i=$j-1;$i>0;$i--){
								if(intval($array[$nbcol[$i]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][0]) && $i > 0){
									$val2 = $header[$i];
								}
							}
						}
						if(!isset($val2)){
							$val2 = $val1;
						}
          				echo '{ id: "'.$val1.'_'.$val2.'", type: "scatter", value: "'.$val1.'", valueY: "'.$val2.'", color: "#81C4E8", fill: "#81C4E8", pointType: "circle" },';
          			}
          		}
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
						$val1 = $header[$j];
						if(isset($header[$j+1])){
					$taken = false;
							for($i=$j+1;$i<count($header);$i++){
								if(intval($array[$nbcol[$i]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][0]) && $i > 0){
									$val2 = $header[$i];
									$taken = true;
								}
								if($taken == false){
									for($k=$j-1;$k>0;$k--){
										if(intval($array[$nbcol[$k]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$k]][0]) && $k > 0){
											$val2 = $header[$k];
										}
									}
								}
							}
						}else{
							for($i=$j-1;$i>0;$i--){
								if(intval($array[$nbcol[$i]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][0]) && $i > 0){
									$val2 = $header[$i];
								}
							}
						}
						if(!isset($val2)){
							$val2 = $val1;
						}
          				echo '{ id: "'.$val1.'_'.$val2.'", type: "scatter", value: "'.$val1.'", valueY: "'.$val2.'", color: "#81C4E8", fill: "#81C4E8", pointType: "circle" }';
          			}
              echo'
          	],
          	legend: {
                  series: [';
				  for($j=0;$j<count($header)-1;$j++){
          			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
						$val1 = $header[$j];
						if(isset($header[$j+1])){
					$taken = false;
							for($i=$j+1;$i<count($header);$i++){
								if(intval($array[$nbcol[$i]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][0]) && $i > 0){
									$val2 = $header[$i];
									$taken = true;
								}
								if($taken == false){
									for($k=$j-1;$k>0;$k--){
										if(intval($array[$nbcol[$k]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$k]][0]) && $k > 0){
											$val2 = $header[$k];
										}
									}
								}
							}
						}else{
							for($i=$j-1;$i>0;$i--){
								if(intval($array[$nbcol[$i]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][0]) && $i > 0){
									$val2 = $header[$i];
								}
							}
						}
						if(!isset($val2)){
							$val2 = $val1;
						}
          				echo '"'.$val1.'_'.$val2.'",';
          			}
          		}

          		if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
						$val1 = $header[$j];
						if(isset($header[$j+1])){
					$taken = false;
							for($i=$j+1;$i<count($header);$i++){
								if(intval($array[$nbcol[$i]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][0]) && $i > 0){
									$val2 = $header[$i];
									$taken = true;
								}
								if($taken == false){
									for($k=$j-1;$k>0;$k--){
										if(intval($array[$nbcol[$k]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$k]][0]) && $k > 0){
											$val2 = $header[$k];
										}
									}
								}
							}
						}else{
							for($i=$j-1;$i>0;$i--){
								if(intval($array[$nbcol[$i]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$i]][0]) && $i > 0){
									$val2 = $header[$i];
								}
							}
						}
						if(!isset($val2)){
							$val2 = $val1;
						}
          				echo '"'.$val1.'_'.$val2.'"';
          			}
          		echo'],
                  halign: "right",
                  valign: "top"
              }
          };

          const chart = new dhx.Chart("chart", config);
		  chart.data.parse(data);
		  document.getElementById("layout").style.width = "50vw";
		  document.getElementById("chart").style.width = "50vw";
		  document.getElementById("parent").style.display = "flex";
}
';
    }
}
echo'
    function openForm() {
        document.getElementById("form").style.display = "block";
    }
    function closeForm() {
        document.getElementById("form").style.display = "none";
    }
    const ligne = document.getElementById("ligne");

    ligne.addEventListener("keypress", (event)=> {
    if (event.keyCode === 13) { // key code of the keybord key
    event.preventDefault();
    nbLigne = ligne.value;
    console.log(nbLigne);
    for(i=0;i<nbLigne;i++){
    const newId = grid.data.add({});
    }
    document.getElementById("form").style.display = "none";
    dhx.message({
        text: nbLigne + " lignes ont été ajoutées.", // the text content
    });
    timer++;
    setTimeout(function(){
    document.getElementsByClassName("dhx_message")[timer].remove();
        timer--;
    }, 2000);}
    });

</script>

<!--tableur-->';
			echo'<script type="text/javascript" src="js/edit.js"></script>';
?>
