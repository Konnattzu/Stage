<?php
echo'<section>
      <div style="height: 600px;">
      <!-- component container -->
<div id="layout" style="height: 100%;"></div>
</div>';

			echo'</section>';
echo'<script>
    const companiesData = [';
		
		for($j=0;$j<$row-1;$j++){
			echo'{ ';
			echo 'numero: "'.$array[$nbcol[0]][$j].'", ';
			for($i=0;$i<count($header);$i++){
					echo '"'.$header[$i].'": "'.$array[$nbcol[$i]][$j].'", ';
			}
			echo'},';
		}
		echo '{ ';
		echo 'numero: "'.$array[$nbcol[0]][$j].'", ';
		for($i=0;$i<count($header);$i++){
				echo '"'.$header[$i].'": "'.$array[$nbcol[$i]][$j].'", ';
		}
		echo'}';
    echo'
	]; 
	
    const dataset = new dhx.DataCollection();
dataset.parse(companiesData);

const layout = new dhx.Layout("layout", {
    type: "space",
    rows: [
        {
            id: "grid",
            height: "35%"
        },
        {
            id: "chart",
        },
    ]
});

const grid = new dhx.Grid(null, {
	columns: [';
		for($i=0;$i<count($header)-1;$i++){
				echo '{ id: "'.$header[$i].'", header: [{ text: "'.$header[$i].'"}], editable: true }, ';
		}
			echo '{ id: "'.$header[$i].'", header: [{ text: "'.$header[$i].'"}], editable: true } ';
    echo'],
    editable: true,
    autoWidth: true,
    data: dataset
}); 


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
				echo $array[$nbcol[$j]][0];
			}
		}
			if(intval($array[$nbcol[$j]][0]) && !preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/",$array[$nbcol[$j]][0]) && $j > 0){
			echo '"'.$header[$j].'"';
		}
		echo'],
        halign: "right",
        valign: "top"
    },
    data: dataset
};

const chart = new dhx.Chart(null, config);

layout.getCell("grid").attach(grid);
layout.getCell("chart").attach(chart);

    </script>';
			echo'<script type="text/javascript" src="js/edit.js"></script>';
?>
