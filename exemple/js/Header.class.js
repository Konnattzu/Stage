class Header {
    constructor(){
        this.value = "";
        this.headnumb = 0;
        this.html = "";
        this.datatype = "";
        this.datalength = 0;
    }

    setValue(value){
        this.value = value;
    }
    getValue(){
        return this.value;
    }

    setNumb(numb){
        this.headnumb = numb;
    }
    getNumb(){
        return this.headnumb;
    }

    setType(type){
        this.datatype = type;
    }
    getType(){
        return this.datatype;
    }

    setLen(len){
        this.datalength = len;
    }
    getLen(){
        return this.datalength;
    }

    setHtml(html){
        this.html = html;
    }
    getHtml(){
        return this.html;
    }
}