<?php
    class Graph{
        public $data = "";
        public $type = "";
        public $html = Array();

        public function __construct(){
            $this->initHtml();
        }

        public function initData(){
            switch($this->type){
                case "kaplan":
                    $ext = "csv";
                break;
                case "sankey":
                    $ext = "json";
                break;
            }
            $this->data = "documents/graphfile.".$ext;
        }
        public function setData($data){
            $this->data = $data;
        }
        public function getData(){
            return $this->data;
        }

        public function setType($type){
            $this->type = $type;
            $this->initData();
            $this->initHtml();
        }
        public function getType(){
            return $this->type;
        }

        public function initHtml(){
                $html["kaplan"] = '
                <script src="https://d3js.org/d3.v4.min.js"></script>
                <script src="https://d3js.org/d3-selection-multi.v1.min.js"></script>
                <script>
            function dispGraph(){
                //load survival data in.
                d3.csv("'.$this->data.'", function(raw_data){
                
                //Data cleaning:
                var data = raw_data.map(function(d){
                    var new_d = {}
                    new_d.age_entry_year = +d.ageentry/12; //patient start
                    new_d.age_year = +d.age/12;            //patient end
                    new_d.death    = d.death  == "1" ? true : false;
                    new_d.gender   = d.gender == "2" ? "female" : "male"
                    return new_d;
                    })
                    .sort((a,b) => b.age_entry_year - a.age_entry_year)
                    .filter(d => d.gender == "male")
                
                
                //charting code goes here.
                
                var chartWidth  = 960, // default width
                    chartHeight = 500;
                
                var margin = {top: 20, right: 40, bottom: 35, left: 30},
                    width  = chartWidth - margin.left - margin.right,
                    height = chartHeight - margin.top - margin.bottom;
                
                // var svg = d3.select(this).append("svg") //leaving for when packaged up.
                var svg = d3.select("body").append("svg")
                    .attr("width",  width  + margin.left + margin.right)
                    .attr("height", height + margin.top  + margin.bottom)
                .append("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
                
                var min_date = d3.min(data, (d) => d.age_entry_year)
                var max_date = d3.max(data, (d) => d.age_year)
                
                var x = d3.scaleLinear()
                    .range([0, width])
                    .domain([min_date, max_date]);
                
                //y scale for the data chart on top
                var y = d3.scaleLinear()
                    .range([height/2 - 20, 0])
                    .domain([0,data.length]);
                
                //y scale for the survival plot on bottom
                var y_surv = d3.scaleLinear()
                    .range([height, height/2 + 10])
                    .domain([0,1]);
                
                var lines = svg.selectAll(".lifespan")
                    .data(data)
                    .enter().append("line")
                    .attr("class", "lifespan")
                    .attrs({
                        "x1": (d) => x(d.age_entry_year),
                        "x2": (d) => x(d.age_entry_year),
                        "y1": (d,i) => y(i),
                        "y2": (d,i) => y(i),
                        "stroke": (d) => d.death ? "steelblue": "orangered",
                        "stroke-width": 1
                    })
                    .on("mouseover", highlight)
                    .on("mouseout", unhighlight)
                    .transition().duration(500)
                    .delay(function(d, i) { return (data.length - i) * 5; })
                    .attr("x2", (d) => x(d.age_year))
                
                svg.append("g")
                    .attr("class", "axis axis--x")
                    .attr("transform", "translate(0," + height + ")")
                    .call(d3.axisBottom(x))
                        .append("text")
                        .attrs({
                            "class": "axis-title",
                            "y": 20,
                            "x": width/2,
                            "dy": "0.8em"
                        })
                        .styles({
                            "text-anchor": "center",
                            "fill": "black",
                            "font-size": 15
                        })
                        .text("Temps en années");
                
                ////////////////////////////////  Make legend ////////////////////////////////////////////////
                var legend = svg.append("g")
                    .attr("class", "legend")
                    .attr("transform", "translate(" + width + "," + margin.top + ")");
                
                var titleAttributes = {
                    "fill": "#636363",
                    "text-anchor": "end",
                    "font-size": "2em"
                }
                
                var legendAttributes = {
                    "x": -5,
                    "text-anchor": "end",
                }
                
                legend.append("text")
                    .text("Données/Individuelles")
                    .attrs(titleAttributes)
                
                legend.append("text")
                    .text("Evenement")
                    .attrs(legendAttributes)
                    .attrs({
                        "y": "2.5em",
                        "fill": "steelblue"
                    })
                
                legend.append("text")
                    .text("Censuré")
                    .attrs(legendAttributes)
                    .attrs({
                        "y": "3.5em",
                        "fill": "orangered"
                    })
                
                svg.append("text")
                    .text("Courbe de survivabilité K-M")
                    .attrs(titleAttributes)
                    .attr("transform", "translate(" + width + "," + (height/2 + margin.top*2) + ")");
                
                //////////////// Drawing the Survival Function //////////////
                //draw bar above to seperate the two plots from eachother
                svg.append("line")
                    .attrs({
                        x1: 0, x2: width,
                        y1: height/2, y2: height/2,
                        stroke: "black",
                        "stroke-width": 1,
                        opacity: 0.3
                    })
                
                var km_surv = KM_Curve(data);
                km_surv.unshift({"t_i": min_date, "d_i": 0, "Y_i": 0, "s_t": 0, "S_t": 1})
                
                var surv_func = svg.append("g")
                    .attr("class", "survival_function")
                
                var line = d3.line()
                    .curve(d3.curveStepAfter)
                    .x(d => x(d.t_i) )
                    .y(d => y_surv(d.S_t));
                
                surv_func.append("path")
                    .datum(km_surv)
                    .attr("class", "line")
                    .attr("d", line);
                
                function update_survival(newData){
                    surv_func.select(".line")
                        .datum(newData)
                        .transition().duration(500)
                        .attr("d", line);
                }
                
                svg.append("g")
                    .attr("class", "axis axis--y")
                    .call(d3.axisLeft(y_surv))
                
                //////////////  A bar to drag to filter the conditional entry time. //////////////
                drag_behavior = d3.drag()
                    .on("drag", function(){
                        var x_loc = d3.event.x;
                            x_loc = x_loc < 0 ? 0 : x_loc,
                            x_loc = x_loc > width ? width : x_loc,
                            time_loc = x.invert(x_loc);
                
                        //move bar.
                        d3.select(".drag_bar")
                            .attr("transform", "translate(" + x_loc + ",0)")
                            .select("text")
                            .text("entrée ≥ " + time_loc.roundTo(2) + " années");
                        d3.select(this)
                                .attr("x",  x_loc - 15);
                
                        svg.selectAll(".lifespan")
                        .attr("opacity",  (d) => d.age_entry_year < time_loc ? 0.1: 1)
                        .classed("ignored", (d) => d.age_entry_year < time_loc)
                        .classed("dragging", true)
                    } )
                    .on("end", function(){
                        svg.selectAll(".lifespan")
                            .classed("dragging", false)
                
                        //generate new KM curve data.
                        //only include current individuals.
                        km_data = data.filter((d) => d.age_entry_year >= time_loc)
                
                        km_surv = KM_Curve(km_data)
                        km_surv.unshift({"t_i": time_loc, "d_i": 0, "Y_i": 0, "s_t": 0, "S_t": 1})
                        update_survival(km_surv);
                    })
                
                
                //make grabber bar
                //Function javascript should really already have.
                Number.prototype.roundTo = function(digits){
                    return +(Math.round(this + "e+" + digits)  + "e-" + digits);
                }
                
                //grabber box to do the dragging.
                svg.append("rect")
                    .attrs({
                        x: -15,
                        y: height/2 - 25,
                        rx: 2, ry:2,
                        width: 15,
                        height: 25,
                        fill: "#636363",
                        class: "drag_screen"
                    })
                    .call(drag_behavior);
                
                var drag_bar = svg.append("g")
                    .attr("class", "drag_bar")
                    .style("pointer-events", "none")
                
                drag_bar.append("rect")
                    .attrs({
                        x: -1,
                        width: 2,
                        height: height,
                        fill: "#636363",
                        opacity: 0.5,
                        class: "drag_screen"
                    })
                
                drag_bar.append("text")
                    .text("entry ≥ " + min_date.roundTo(2) + " years")
                    .attrs({
                        "y": (height/2) - 3,
                        "x": 3,
                        "fill": "#636363",
                        "text-anchor": "start"
                    })
                
                ////////////// End drag bar //////////////
                
                
                function highlight(){
                    var individual = d3.select(this);
                
                    //dont do behavior for the non-selected individuals or when dragging the bar.
                    if(individual.classed("ignored") || individual.classed("dragging")) return;
                
                    var y_pos = individual.attr("y1")
                
                    individual
                        .attr("stroke-width", "5")
                
                    var ind_data = individual.data()
                        .map(function(d){
                            return {
                                "entry": d.age_entry_year,
                                "exit" : d.age_year
                            }
                        })[0]
                
                    var bound_bar_data = [
                        {side: "left",  x:individual.attr("x1"), value: ind_data.entry.roundTo(3)},
                        {side: "right", x:individual.attr("x2"), value: ind_data.exit.roundTo(3)}
                    ]
                
                    var bounds_bars = svg.append("g")
                        .attr("class", "bounds_bars")
                
                    bounds_bars.selectAll("line")
                        .data(bound_bar_data)
                        .enter().append("line")
                        .attrs({
                            "x1": (d) => d.x,
                            "x2": (d) => d.x,
                            "y1": y_pos,
                            "y2": height,
                            "stroke": "black",
                            "stroke-width": 1
                        })
                
                    bounds_bars.selectAll("text")
                        .data(bound_bar_data)
                        .enter().append("text")
                        .text( (d) => d.value )
                        .attrs({
                            "x": (d) => d.x,
                            "y": height,
                            "text-anchor": (d) => d.side == "left" ? "end" : "start",
                            "font-size": 12
                        })
                }
                
                function unhighlight(){
                    d3.select(this).attr("stroke-width", 1)
                    svg.select(".bounds_bars").remove()
                }
                
                ///////////////////////////// Generate a K-M non-parametric survival curve for data.
                
                function KM_Curve(data){
                    //Source http://stackoverflow.com/questions/11246758/how-to-get-unique-values-in-an-array
                    Array.prototype.contains = function(v) {
                        for(var i = 0; i < this.length; i++) {
                            if(this[i] === v) return true;
                        }
                        return false;
                    };
                    Array.prototype.unique = function() {
                        var arr = [];
                        for(var i = 0; i < this.length; i++) {
                            if(!arr.contains(this[i])) {
                                arr.push(this[i]);
                            }
                        }
                        return arr;
                    }
                
                    //get unique times of death.
                    death_times = data.filter(d => d.death)
                        .map(d => d.age_year)
                        .unique()
                        .sort()
                
                    km_table = death_times.map(t_i => {
                        //Number of deaths at t_i
                        var d_i = data.filter(d => d.age_year == t_i && d.death).length
                
                        //number at risk. Aka       in study,          but  havent had event yet.
                        var Y_i = data.filter(d => d.age_entry_year <= t_i && d.age_year >= t_i).length
                
                        var s_t = 1 - (d_i/Y_i);
                
                        return {"t_i": t_i, "d_i": d_i, "Y_i": Y_i, "s_t": s_t}
                    })
                
                    for (let [i, row] of km_table.entries()) {
                        var t = row.t_i,
                            s_t = row.s_t,
                            last_S_t = i != 0 ? km_table[i-1].S_t : 1;
                        km_table[i].S_t = last_S_t * s_t;
                    }
                
                    // console.table(km_table)
                    return km_table;
                }
                
                
                
                }) //close csv loader
            }
                </script>
                ';
                $html["sankey"] = '
                <script src="https://d3js.org/d3.v7.min.js"></script> 
                <script src="https://unpkg.com/d3-sankey@0.12.3/dist/d3-sankey.min.js"></script>
                <script>
            function dispGraph(){
                // set the dimensions and margins of the graph
                var margin = {top: 10, right: 10, bottom: 10, left: 10},
                    width = 900 - margin.left - margin.right,
                    height = 300 - margin.top - margin.bottom;  
                
                // format variables
                var formatNumber = d3.format(",.0f"), // zero decimal places
                    format = function(d) { return formatNumber(d); },
                    color = d3.scaleOrdinal(d3.schemeCategory10);
                  
                // append the svg object to the body of the page
                var svg = d3.select("body").append("svg")
                    .attr("width", width + margin.left + margin.right)
                    .attr("height", height + margin.top + margin.bottom)
                    .attr("id", "oui")
                    .attr("preserveAspectRatio","xMinYMin meet")
                  .append("g")
                    .attr("transform", 
                          "translate(" + margin.left + "," + margin.top + ")");
                
                // Set the sankey diagram properties
                var sankey = d3.sankey()
                    .nodeWidth(36)
                    .nodePadding(40)
                    .size([width, height]);
                
                var path = sankey.links();
                
                // load the data
                d3.json("'.$this->data.'").then(function(sankeydata) {
                
                  var nodeMap = {};
                  sankeydata.nodes.forEach(function(x) { nodeMap[x.name] = x; });
                  sankeydata.links = sankeydata.links.map(function(x) {
                    return {
                      source: nodeMap[x.source],
                      target: nodeMap[x.target],
                      value: x.value
                    };
                  });
                
                  graph = sankey(sankeydata);
                
                
                // add in the links
                  var link = svg.append("g").selectAll(".link")
                      .data(graph.links)
                    .enter().append("path")
                      .attr("class", "link")
                      .attr("d", d3.sankeyLinkHorizontal())
                      .attr("stroke-width", function(d) { return d.width; });  
                
                // add the link titles
                  link.append("title")
                        .text(function(d) {
                                return d.source.name + " → " + 
                                d.target.name + "\n" + format(d.value); });
                
                // add in the nodes
                  var node = svg.append("g").selectAll(".node")
                      .data(graph.nodes)
                    .enter().append("g")
                      .attr("class", "node");
                
                // add the rectangles for the nodes
                  node.append("rect")
                      .attr("x", function(d) { return d.x0; })
                      .attr("y", function(d) { return d.y0; })
                      .attr("height", function(d) { return d.y1 - d.y0; })
                      .attr("width", sankey.nodeWidth())
                      .style("fill", function(d) { 
                              return d.color = color(d.name.replace(/ .*/, "")); })
                      .style("stroke", function(d) { 
                          return d3.rgb(d.color).darker(2); })
                      .append("title")
                      .text(function(d) { 
                          return d.name + "\n" + format(d.value); });
                
                // add in the title for the nodes
                  node.append("text")
                      .attr("x", function(d) { return d.x0 - 6; })
                      .attr("y", function(d) { return (d.y1 + d.y0) / 2; })
                      .attr("dy", "0.35em")
                      .attr("text-anchor", "end")
                      .text(function(d) { return d.name; })
                    .filter(function(d) { return d.x0 < width / 2; })
                      .attr("x", function(d) { return d.x1 + 6; })
                      .attr("text-anchor", "start");
                
                });
            }
                </script>';
            $this->html = $html;
        }
        public function setHtml($html){
            $this->html = $html;
        }
        public function getHtml(){
            return $this->html;
        }
        function json_encode_private() {
			echo'<script>
			graphObj = new Graph('.json_encode($this->extract_props($this)).');
			</script>';
		}
        function stackVal($value, $name) {
            if(is_array($value)) {
                $public[$name] = [];
                $i=0;
                $keys = array_keys($value);
                foreach ($value as $item) {
                    if (is_object($item)) {
                        $itemArray = $this->extract_props($item);
                        $public[$name][] = $itemArray;
                    } else {
                        $itemArray = $this->stackVal($item, $name);
                        $public[$name][$keys[$i]] = $itemArray;
                    }
                    $i++;
                }
            } else if(is_object($value)) {
                $public[$name] = $this->extract_props($value);
            } else $public[$name] = $value;
            return $public[$name];
        }
        function extract_props($object) {
            $publicObj = [];
    
            $reflection = new ReflectionClass(get_class($object));
    
            
            
            foreach ($reflection->getProperties() as $property) {
                $property->setAccessible(true);
    
                $value = $property->getValue($object);
                $name = $property->getName();
                $publicObj[$name] = $this->stackVal($value, $name);
            }
            // echo'<pre>';
            // print_r($publicObj[$name]);
            // echo'</pre>';
    
            return $publicObj;
        }
        
        function dispGraph(){
            print_r($this->html[$this->type]);
        }
    }
?>