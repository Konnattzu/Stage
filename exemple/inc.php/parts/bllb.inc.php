<?php
echo'<section>
      <div class="parent">
<div id="layout" style="height: 100%;"></div>
</div>';

			echo'</section>';
echo'<script>
const toolbarData = [
  {
      id: "add",
      type: "button",
      circle: true,
      value: "Add a new row",
      size: "small",
      icon: "mdi mdi-plus",
      full: true
  },

  {
            type: "spacer"
  },

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
  },

  {
            type: "spacer"
  },

  {
            type: "spacer"
  },

  {
            type: "spacer"
  }
];

// Layout initialization
const layout = new dhx.Layout("layout", {
cols: [
  {
      rows: [
          {
              id: "toolbar",
              height: "content"
          },
          {
              type: "space",
              rows: [
                  {
                      id: "grid"
                  },
				  {
						id: "chart",
					}
              ]
          }
      ]
  }
]
});

// Toolbar initialization
const toolbar = new dhx.Toolbar(null, {
css: "toolbar_template_a",
});
// loading structure into Toolbar
toolbar.data.parse(toolbarData);
// assign the handler to the Click event of the button with the id="add"
// pressing the Add button will add a new item to the grid and open the form for editing this item

toolbar.events.on("click", function (id) {
if (id === "add") {
  const newId = grid.data.add({ //data a renseigner
      A: "",
      B: "",
      average_rating: "",
      publication_date: ""/*YOUHOU*/
  });
}

/*export xlsx*/
if (id === "impXlsx") {
  grid.export.xlsx({
      url: "https://export.dhtmlx.com/excel"
  });
}
/*export csv*/
if (id === "impcsv") {
grid.export.csv();
}
});

// initializing Grid for data vizualization
const grid = new dhx.Grid(null, {
css: "dhx_demo-grid",
columns: [
  {
      id: "action", gravity: 1.5, header: [{ text: "Actions", align: "center" }],
      htmlEnable: true, align: "center",
      editable: false,
      autoWidth: false,
      template: function () {';
			$span = "<span class='action-buttons'><a class='remove-button noselect'>&#10060;</a></span>";
          echo'return "'.$span.'";
      }
	  },';
		for($i=0;$i<count($header)-1;$i++){
				echo '{ id: "'.$header[$i].'", header: [{ text: "'.$header[$i].'"}], editable: true }, ';
		}
			echo '{ id: "'.$header[$i].'", header: [{ text: "'.$header[$i].'"}], editable: true } ';
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

// loading data into Grid
dataset = ';
include("inc.php/parts/data.inc.php");
echo';
grid.data.parse(dataset);


// config graph

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


// attaching widgets to Layout cells
layout.getCell("toolbar").attach(toolbar);
layout.getCell("grid").attach(grid);
layout.getCell("chart").attach(chart);

</script>
<!--tableur-->';
			echo'<script type="text/javascript" src="js/edit.js"></script>';
?>