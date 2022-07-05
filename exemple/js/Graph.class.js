class Graph {
    constructor(graphObj){
        this.data = graphObj.data;
        this.type = graphObj.type;
        this.html = graphObj.html;
    }

    initData(){
        switch(this.type){
            case "kaplan":
                var ext = "csv";
            break;
            case "sankey":
                var ext = "json";
            break;
        }
        this.data = "documents/graphfile."+ext;
    }
    setData(data){
        this.data = data;
    }
    getData(){
        return this.data;
    }

    setType(type){
        this.type = type;
        this.initData();
    }
    getType(){
        return this.type;
    }

    setHtml(html){
        this.html = html;
    }
    getHtml(){
        return this.html;
    }

    newGraph(){
        var win = window.open("index.php?ref="+this.type, '_blank');
        win.focus();
    }
}