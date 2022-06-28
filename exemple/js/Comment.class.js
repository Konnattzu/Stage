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

    initHtml(colnumb){
        var that = this;
        var phyl = document.createElement("div");
        phyl.innerHTML = '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 841.9 1190.6" style="enable-background:new 0 0 841.9 1190.6;" xml:space="preserve">	<style type="text/css"> .st4{fill:#02b5ce;stroke:#000000;stroke-width:3;stroke-miterlimit:10;}  .st4:hover{ fill:#5bcedb;} .st5{fill:none;stroke:#000000;stroke-width:7;stroke-miterlimit:10;}.st0{fill:#fff;stroke:#000000;stroke-width:3;stroke-miterlimit:10;}</style><g><path class="st4" d="M373.5,455.1l200-1c0,0,56.9,4.7,56.9-34s0-173,0-173s2.2-36-33-36c-35.2,0-405.2-0.7-405.2-0.7s-35.7-3.9-35.8,36.1S156,419.1,156,419.1s-4.8,35.7,30.2,36c3.1,0,12.3,7.2,13.6,8.7c32.8,38.6,70.2,192.3,70.2,192.3L373.5,455.1z"/><polyline class="st0" points="186.2,455.1 206.5,455.1 248.2,577.5     "/></g><line id="LFinal1" class="st5" x1="240.5" y1="264.7" x2="545.7" y2="264.7"/><line id="LFinal2" class="st5" x1="240.5" y1="324.8" x2="545.7" y2="324.8"/><line id="LFinal3" class="st5" x1="240.5" y1="384.9" x2="545.7" y2="384.9"/></svg>';
        var comcontain = document.createElement("div");
        comcontain.classList.add("dhx_string-cell");
        comcontain.classList.add("dhx_grid-comcell");
        comcontain.setAttribute("data-dhx-col-id", that.colid);
        comcontain.setAttribute("role", "gridcell");
        comcontain.setAttribute("aria-colindex", colnumb);
        comcontain.setAttribute("aria-readonly", "false");
        comcontain.setAttribute("tabindex", "-1");
        comcontain.appendChild(phyl);
        this.html = comcontain;
        this.html.addEventListener('click', function(){ that.comDisp(that); }, false);
    }
    setHtml(html){
        this.html = html;
    }
    getHtml(){
        return this.html;
    }

    comDisp(that){
        event.stopImmediatePropagation();
		var comt = that.value;
		const windowHtml = "<form method='post' action=''><textarea style='min-width:380px; min-height:420px;' tabindex='-1'>"+comt+"</textarea><input type='submit' value='&#9989;'></form>";
		const dhxwindow = new dhx.Window({
			width: 440,
			height: 520,
			title: "Commentaire",
			html: windowHtml
		});
		dhxwindow.show();
		var comwindow = dhxwindow._popup;
		comwindow.style.zIndex = "50";
		var cover = document.createElement("div"); 
		if(document.body.getElementsByClassName("popup-cover").length == 0){
			cover.classList.add("popup-cover"); 
			document.body.insertBefore(cover, document.body.children[1]); 
		}
        var delay = setTimeout(function(){ 
            clearTimeout(delay); 
            var textarea = comwindow.firstChild.childNodes[1].firstChild.firstChild.getElementsByTagName("TEXTAREA")[0];
            textarea.focus();
		    cover.addEventListener("click", function(){ that.comSend(that, comwindow, cover, textarea); }, false);
        }, 100);
    }

    comSend(that, comwindow, cover){
		var newval = comwindow.firstChild.childNodes[1].firstChild.firstChild.getElementsByTagName("TEXTAREA")[0].value;
		var data = new FormData();
		data.append("row", that.rowid);
		data.append("column", that.colid);
		data.append("comt", newval);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4) {
				var results = request.responseText;
				console.log(results);
				console.log(request.responseText);
				//init();
			}
		}
		request.open("POST", "inc.php/parts/send_com.inc.php", true);
		request.setRequestHeader("X-Requested-With", "xmlhttprequest");
		request.send(data);	
		cover.remove();
		comwindow.remove();
		window.location.reload();
    }
}