<?php
	if(defined("constante")){
		echo'
		<section>
			<article>
				<a href="index.php?ref=liste">Voir les données</a>
				<a href="index.php?ref=accueil">Retour à l&apos; accueil</a>
				<h1>La liste</h1>';
				//include("inc.php/parts/edit_data.inc.php");
				include("inc.php/parts/datatype.func.php");
				include("inc.php/parts/clear.func.php");
				$path="documents/";
				include("inc.php/parts/table_upload.inc.php");
				echo'<form action="" method="post" enctype="multipart/form-data">
								<label class="file_input">
									<input type="file" name="table">
								</label>
								<input type="submit" name="send" value="Envoyer">
					</form>
					<a id="savetable">Sauvegarder</a>';
			if((isset($reset) && $reset == true) || (isset($_SESSION["path"]) && $_SESSION["path"] != 'documents/'.$_FILES['table']['name'])){
				mysqli_query($_SESSION["mysqli"], "DELETE FROM step2;");
			}
			
		if(isset($path) && $path != "documents/"){
			$csv = array_map("str_getcsv", file($path));
			$header = array_shift($csv);
			$_SESSION["path"] = $path;
			
			for($j=0;$j<count($header);$j++){
				$nbcol[$j] = array_search($header[$j], $header, true);
			}
			$row=0;
			foreach ($csv as $col) {
				for($j=0;$j<count($header);$j++){
					$array[$nbcol[$j]][$row] = $col[$nbcol[$j]];
				}
				$row++;
			}
			
			if(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM step2;"))==0){
				include("inc.php/parts/create_table.inc.php");
				include("inc.php/parts/add_data.inc.php");
			}
		}
			
			$infotable = mysqli_query($mysqli, 'SELECT 
									TABLE_CATALOG,
									TABLE_SCHEMA,
									TABLE_NAME, 
									COLUMN_NAME, 
									DATA_TYPE, 
									COLUMN_TYPE, 
									CHARACTER_MAXIMUM_LENGTH
									FROM INFORMATION_SCHEMA.COLUMNS
									where TABLE_NAME = "step2";');
			$col = 0;
			$row = 0;
			$header = array();
			$nbcol = array();
			$array = array();
			while($infos = $infotable->fetch_assoc()){
				$header[$col] = $infos["COLUMN_NAME"];
				$charlength[$header[$col]] = $infos["CHARACTER_MAXIMUM_LENGTH"];
				$nbcol[$col] = $col;
				$col++;
			}
			
			$req = mysqli_query($mysqli, "SELECT * FROM step2");
			while($data = $req->fetch_assoc()){
				for($i=0;$i<count($header);$i++){
					$array[$i][$row] = $data[$header[$i]];
				}
				$row++;
			}

			// include("inc.php/parts/grid.inc.php");
			include("inc.php/parts/bllb.inc.php");

			
			
		
	}
	else die("");
?>
