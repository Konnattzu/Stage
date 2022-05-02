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


// attaching widgets to Layout cells
layout.getCell("toolbar").attach(toolbar);
layout.getCell("grid").attach(grid);

</script>
<!--tableur-->';
			echo'<script type="text/javascript" src="js/edit.js"></script>';
?>