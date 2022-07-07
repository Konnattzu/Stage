class Login {
    constructor(){
        this.table;
        this.connForm;
        this.inscForm;
        this.html = new Array();
    }
    dataFill(dataArray){
        this.table = dataArray.table;
        this.html = dataArray.html;
        this.initBtns();
        console.log(this);
    }

    setTable(name){
        this.table = name;
    }
    getTable(){
        return this.name;
    }

    setHtml(html, place){
        this.html[place] = html;
        this.initBtn();
    }
    getHtml(){
        return this.html;
    }

    initBtns(){
        var that = this;
        this.connForm = document.getElementById("connexion-form");
        this.connForm.addEventListener("keypress", function(){ if(event.key == "Enter"){ event.preventDefault(); that.signIn(that); } }, false);
        this.inscForm = document.getElementById("inscription-form");
        this.inscForm.addEventListener("keypress", function(){ if(event.key == "Enter"){ event.preventDefault(); that.subscribe(that); } }, false);
        var passEyeConn = document.getElementById("eye-conn");
        passEyeConn.addEventListener("click", function(){ that.showPass(); }, false);
        var passEyeInsc = document.getElementById("eye-insc");
        passEyeInsc.addEventListener("click", function(){ that.showPass(); }, false);
        var connBtn = document.getElementById("conn-btn");
        connBtn.addEventListener("click", function(){ that.signIn(that); }, false);
        var inscBtn = document.getElementById("insc-btn");
        inscBtn.addEventListener("click", function(){ that.subscribe(that); }, false);
    }

    signIn(that){
        event.preventDefault();
        if(event.target.getAttribute("name") == "connexion" || event.key == "Enter"){
            var data = new FormData(that.connForm);
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState === 4) {
                    var results = request.responseText;
                    console.log(results);
                    console.log(request.responseText);
                    if(parseInt(results) == results){
                        window.location.href = "index.php?ref=compte&user="+results;
                    }
                }
            }
            request.open("POST", "inc.php/func/connexion.func.php", true);
            request.setRequestHeader("X-Requested-With", "xmlhttprequest");
            request.send(data);
        }
    }

    subscribe(that){
        event.preventDefault();
        if(event.target.getAttribute("name")=="inscription"){
            var data = new FormData(that.inscForm);
            console.log(data);
            console.log(that.inscForm);
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState === 4) {
                    var results = request.responseText;
                    console.log(results);
                    console.log(request.responseText);
                    if(parseInt(results) == results){
                        window.location.href = "index.php?ref=compte&user="+results;
                    }
                }
            }
            request.open("POST", "inc.php/func/inscription.func.php", true);
            request.setRequestHeader("X-Requested-With", "xmlhttprequest");
            request.send(data);
        }
    }

    showPass(){
        console.log(event);
        var image = event.target;
        if(image.getAttribute('id') == "eye-conn"){
            var password = document.getElementById('pass');
            if (password.type === "password") {
                password.type = "text";
                image.setAttribute('src', 'images/eyeshow.png');
            } else if (password.type === "text"){
                password.type = "password";
                image.setAttribute('src', 'images/eyehide.png');
            }
        }else if(image.getAttribute('id') == "eye-insc"){
            var password = document.getElementById('pass1');
            var confirm = document.getElementById('pass2');
            if (password.type === "password",confirm.type === "password") {
                password.type ="text";
                confirm.type ="text";
                image.setAttribute('src', 'images/eyeshow.png');
            } else if (password.type === "text",confirm.type === "text"){
                password.type = "password";
                confirm.type = "password";
                image.setAttribute('src', 'images/eyehide.png');
            }
        }
    }
}