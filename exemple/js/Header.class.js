class Header {
    constructor(){
        this.value = "";
        this.headnumb = 0;
        this.html = "";
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

    setHtml(html){
        this.html = html;
    }
    getHtml(){
        return this.html;
    }
}