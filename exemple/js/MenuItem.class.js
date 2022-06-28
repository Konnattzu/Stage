class MenuItem {
    constructor(html, name, rank, sheet){
        this.html = html;
        this.name = name;
        var that = this;
        this.html.addEventListener("mouseenter", function(){ var delay = setTimeout(function(){ clearTimeout(delay);that.initItems(that); }, 100) }, false);
        this.subItems = new Array();
        this.rank = rank;
        this.sheet = sheet;
    }

    setHtml(html){
        this.html = html;
    }
    getHtml(){
        return this.html;
    }

    setName(value){
        this.name = value;
    }
    getName(){
        return this.name;
    }

    setRank(numb){
        this.rank = numb;
    }
    getRank(){
        return this.rank;
    }

    initItems(that){
        var sheet = this.sheet;
        if(typeof(document.getElementsByClassName("dhx_menu")[that.getRank()]) != "undefined"){
            var items = document.getElementsByClassName("dhx_menu")[that.getRank()].children;
        }
        if(typeof(items) != "undefined"){
            for(var i=0;i<items.length;i++){
                that.getItems()[i] = new MenuItem(items[i].children[0], items[i].children[0].getAttribute("data-dhx-id"), that.getRank()+1, sheet);
            }
        }
        for(var i=0;i<that.getItems().length;i++){
            switch(that.getItems()[i].getName()){
                case "add":
                    that.getItems()[i].getHtml().addEventListener("click", function(){ var delay = setTimeout(function(){ clearTimeout(delay); sheet.initData(); }, 100) }, false);
                break;
                case "addmore":
                    that.getItems()[i].getHtml().addEventListener("click", function(){ var delay = setTimeout(function(){ clearTimeout(delay); sheet.initData(); }, 100) }, false);
                break;
            }
        }
    }
    setItems(item, pos){
        this.subItems[pos] = item;
    }
    getItems(){
        return this.subItems;
    }
}