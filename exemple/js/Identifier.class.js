class Identifier {
    constructor(){
        this.value = "";
        this.rownumb = 0;
        this.html = "";
    }

    setValue(value){
        this.value = value;
    }
    getValue(){
        return this.value;
    }

    setNumb(numb){
        this.rownumb = numb;
    }
    getNumb(){
        return this.headnumb;
    }

    setHtml(html){
        this.html = html;
    }
    getHtml(){
        return this.html;
    }
}