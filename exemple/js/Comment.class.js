class Comment {
    constructor(){
        this.value = "";
        this.rowid = "";
        this.colid = "";
        this.html = "";
    }

    initValue(){
        var that = this;
        var data = new FormData();
        data.append("row", this.rowid);
        data.append("column", this.colid);
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4) {
                var results = request.responseText;
                that.setValue(results);
            }
        }
        request.open("POST", "inc.php/parts/get_com.inc.php", true);
        request.setRequestHeader("X-Requested-With", "xmlhttprequest");
        request.send(data);
    }
    setValue(value){
        this.value = value;
    }
    getValue(){
        return this.value;
    }

    setRowid(value){
        this.rowid = value;
    }
    getRowid(){
        return this.rowid;
    }

    setColid(value){
        this.colid = value;
    }
    getColid(){
        return this.colid;
    }

    setHtml(html){
        this.html = html;
    }
    getHtml(){
        return this.html;
    }
}