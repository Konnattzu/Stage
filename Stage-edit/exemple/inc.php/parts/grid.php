<?php
echo'<a href="../index.html"><p>Retour</p></a>
     <!-- component container -->
     <div style="height: 600px;"
     <div style="height: calc(100% - 60px); width: 100%" id="grid"></div>
</div>
   <script>
   var dataset = [
   {
           "country": "China",
           "population": "1415045928",
           "yearlyChange": "0.0039",
           "netChange": "5528531",
           "density": "151",
           "area": "9388211",
           "migrants": "-339690",
           "fert": "1.6",
           "age": "37",
           "urban": "0.5800",
           "id": "1"
   },
   {
           "country": "India",
           "population": "1354051854",
           "yearlyChange": "0.0111",
           "netChange": "14871727",
           "density": "455",
           "area": "2973190",
           "migrants": "-515643",
           "fert": "2.4",
           "age": "27",
           "urban": "0.3200",
           "id": "2",
           "custom": true
   },
   {
           "country": "U.S.",
           "population": "326766748",
           "yearlyChange": "0.0071",
           "netChange": "2307285",
           "density": "36",
           "area": "9147420",
           "migrants": "900000",
           "fert": "1.9",
           "age": "38",
           "urban": "0.8300",
           "id": "3"
   },
   {
           "country": "Indonesia",
           "population": "266794980",
           "yearlyChange": "0.0106",
           "netChange": "2803601",
           "density": "147",
           "area": "1811570",
           "migrants": "-167000",
           "fert": "2.5",
           "age": "28",
           "urban": "0.5400",
           "id": "4"
   },
   {
           "country": "Brazil",
           "population": "210867954",
           "yearlyChange": "0.0075",
           "netChange": "1579676",
           "density": "25",
           "area": "8358140",
           "migrants": "3185",
           "fert": "1.8",
           "age": "31",
           "urban": "0.8400",
           "id": "5"
       },
       {
           "country": "Pakistan",
           "population": "200813818",
           "yearlyChange": "0.0193",
           "netChange": "3797863",
           "density": "260",
           "area": "770880",
           "migrants": "-236384",
           "fert": "3.7",
           "age": "22",
           "urban": "0.3800",
           "id": "6"
       },
       {
           "country": "Nigeria",
           "population": "195875237",
           "yearlyChange": "0.0261",
           "netChange": "4988926",
           "density": "215",
           "area": "910770",
           "migrants": "-60000",
           "fert": "5.7",
           "age": "18",
           "urban": "0.4900",
           "id": "7"
       },
       {
           "country": "Bangladesh",
           "population": "166368149",
           "yearlyChange": "0.0103",
           "netChange": "1698398",
           "density": "1278",
           "area": "130170",
           "migrants": "-505297",
           "fert": "2.2",
           "age": "26",
           "urban": "0.3500",
           "id": "8"
       },
       {
           "country": "Russia",
           "population": "143964709",
           "yearlyChange": "-0.0002",
           "netChange": "-25045",
           "density": "9",
           "area": "16376870",
           "migrants": "203577",
           "fert": "1.7",
           "age": "39",
           "urban": "0.7300",
           "id": "9"
       },
       {
           "country": "Mexico",
           "population": "130759074",
           "yearlyChange": "0.0124",
           "netChange": "1595798",
           "density": "67",
           "area": "1943950",
           "migrants": "-60000",
           "fert": "2.3",
           "age": "28",
           "urban": "0.7800",
           "id": "10"
       }
       ],
       data: dataset,
       selection: "row",
       adjust: true
   });
Datepicker
   grid.selection.events.on("afterSelect", function (row) {
       document.getElementById("value").value = row.id;
   });

   grid.selection.setCell("1");

   function getSellectionId() {
       return grid.selection.getCell().row.id;
   };

   function showRow() {
       grid.showRow(getSellectionId());
   };

   function hideRow() {
       grid.hideRow(getSellectionId());
   };

   function isHidden() {
       document.getElementById("output").value = grid.isRowHidden(getSellectionId());
   };
';
?>
