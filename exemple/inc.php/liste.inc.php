<?php
		echo'
		<section>
			<article>
				<a href="index.php?ref=liste">Retour à l&apos; accueil</a>
				<h1>La liste</h1>';
				$liste = mysqli_query($_SESSION["mysqli"], 'SELECT * FROM exemple;');
				$i = 0;
				echo'<table>';
				while($data = $liste->fetch_assoc()){
					$row[$i] = $data;
					// if($i == 0){
						// echo'<tr>';
						// foreach ($row[$i] as $col => $val) {
							// echo'<td>';
							// echo $col;
							// echo'</td>';
						// }
						// echo'</tr>';
					// }
					echo'<tr>';
					foreach ($row[$i] as $col => $val) {
						echo'<td>';
						echo $val;
						echo'</td>';
					}
					echo'</tr>';
					$i++;
				}
				echo'</table>';
			echo'</article>
		</section>
		';
?>
