<?php

	if(defined("constante")){
		if(isset($_POST['patient_id'])){
			if(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM patientstest WHERE patient_id=".$_POST["patient_id"].";"))==1){
				$prenom = $_POST["prenom"];
				$nom = $_POST["nom"];
				$sexe = $_POST["sexe"];
				$date = DateTime::createFromFormat('d/m/Y', $_POST["date_naiss"]);
				$date_naiss = $date->format('Y-m-d');
				$grp_sang = $_POST["grp_sang"];
				$taux_antcrps = $_POST["taux_antcrps"];
				$req = mysqli_query($mysqli,"SELECT * FROM patientstest WHERE patient_id=".$_POST["patient_id"].";");
				while($patient = $req->fetch_assoc()){
					mysqli_query($mysqli,"UPDATE patientstest SET `prenom`='".$prenom."', `nom`='".$nom."', `sexe`='".$sexe."', `date_naiss`='".$date_naiss."', `grp_sang`='".$grp_sang."', `taux_antcrps`='".$taux_antcrps."' WHERE patient_id=".$_POST["patient_id"].";");
				}
			}
		}
			}
	else die("");
						?>