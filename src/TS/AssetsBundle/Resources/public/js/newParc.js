function chgtClient(obj) {
	var numid = obj.value;
	var chpNewClient = document.getElementById("chpNewClient");
	var btnNewClient = document.getElementById("btnNewClient");
	var chpNewSite = document.getElementById("chpNewSite");
	var btnNewSite = document.getElementById("btnNewSite");
	
	if (numid=="autre"){
		chpNewClient.style = "display: inline-block";
		btnNewClient.style = "display: inline-block";
		oSelect = document.getElementById("siteSelect");
		oSelect.innerHTML = "";
		
	}else{
		var xhr   = new XMLHttpRequest();	
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
				readChgtClient(xhr.responseXML);
			} else if (xhr.readyState < 4) {
			}
		};
		
		xhr.open("POST", "newParc_post.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("IdClient="+numid);
		chpNewClient.style = "display: none";
		btnNewClient.style = "display: none";
		chpNewSite.style = "display: none";
		btnNewSite.style = "display: none";
		var nomSite = obj.id;
		var elmtt = document.getElementById("nomClient");
		elmtt.innerHTML=numid;
	}
}

function readChgtClient(oData) {
	var nodes   = oData.getElementsByTagName("opt");
	var oSelect = document.getElementById("siteSelect");
	var oOption, oInner;
	
	oSelect.innerHTML = "";
	
	oOption = document.createElement("option");
	oInner=document.createTextNode(" ");
	oOption.appendChild(oInner);
	oSelect.appendChild(oOption);
	
	oOption = document.createElement("option");
	oInner=document.createTextNode("Nouveau");
	oOption.appendChild(oInner);
	oSelect.appendChild(oOption);
	for (var i=0; i<nodes.length; i++) {
		oOption = document.createElement("option");
		oInner  = document.createTextNode(nodes[i].innerHTML);
		oOption.value = nodes[i].getAttribute("value");
		
		oOption.appendChild(oInner);
		oSelect.appendChild(oOption);
	}
}

function chgtSite(obj) {
	var numid = obj.value,chpNewSite = document.getElementById("chpNewSite"), btnNewSite = document.getElementById("btnNewSite");
	if (numid=="Nouveau"){
		chpNewSite.style = "display: inline-block";
		btnNewSite.style = "display: inline-block";
		
		
	}else{
		chpNewSite.style = "display: none";
		btnNewSite.style = "display: none";/*
		var xhr   = new XMLHttpRequest();	
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
				readChgtClient(xhr.responseXML);
			} else if (xhr.readyState < 4) {
			}
		};
		
		xhr.open("POST", "newParc_post.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("IdClient="+numid);
		chpNewClient.style = "display: none";
		btnNewClient.style = "display: none";
		var nomSite = obj.id;
		var elmtt = document.getElementById("nomClient");
		elmtt.innerHTML=numid;*/
	}
}
function btnNewClient(){
	var chpNewClient = document.getElementById("chpNewClient");
	var chpNewSite = document.getElementById("chpNewSite"); 
	var btnNewSite = document.getElementById("btnNewSite");
	var elmtt = document.getElementById("nomClient");
	chpNewSite.style = "display: inline-block";
	btnNewSite.style = "display: inline-block";
	oSelect = document.getElementById("siteSelect");
	oSelect.innerHTML = "";
	elmtt.innerHTML = chpNewClient.value;
}
function btnNewSite(){
	var chpNewSite = document.getElementById("chpNewSite"); 
	var elmtt = document.getElementById("nomSite");
	var chpNbPostes = document.getElementById("chpNbPostes"); 
	var btnNewPostes = document.getElementById("btnNewPostes");
	elmtt.innerHTML = chpNewSite.value;
	chpNbPostes.style = "display: inline-block";
	btnNewPostes.style = "display: inline-block";
}
function btnNewPostes(){
	var fieldPostes = document.getElementById("fieldPostes"); 
	var chpNbPostes = document.getElementById("chpNbPostes"); 
	var nbPostes = chpNbPostes.value;
	var newChp,newBtn,newSelect,divPoste;
	var br = document.createElement("br");
	fieldPostes.style = "display: inline-block";
	
	for (var i=0;i<nbPostes;i++){
		divPoste = document.createElement("div");
		divPoste.id="Poste"+(i+1);
		fieldPostes.appendChild(divPoste);
		newChp = document.createElement("input");
		newChp.placeholder = "Poste "+(i+1);
		newChp.id = "nomPoste"+(i+1);
		newChp.name="nomPoste";
		newChp.setAttribute("onchange","rafraichir()");
		divPoste.appendChild(newChp);
		newSelect = document.createElement("select");
		newSelect.id="select"+(i+1);
		divPoste.appendChild(newSelect);
		newBtn = document.createElement("input");
		newBtn.type = "button";
		newBtn.value = "Ajouter";
		newBtn.id = "btnNomPoste"+(i+1);
		divPoste.appendChild(newBtn);
		fieldPostes.appendChild(br.cloneNode(false));
		
	}

	typeMateriel();
	rafraichir();
}

function typeMateriel() {
	var xhr   = new XMLHttpRequest();	
	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			readTypeMateriel(xhr.responseXML);
		} else if (xhr.readyState < 4) {
			
		}
	};
	xhr.open("POST", "listMatos_post.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send();
				
}

function readTypeMateriel(oData) {
	var nodes   = oData.getElementsByTagName("opt");
	var oSelect = document.getElementsByTagName("select");
	var oOption, oInner;
	
	for (var j=2; j<oSelect.length;j++){
		oOption = document.createElement("option");
		oInner=document.createTextNode(" ");
		oOption.appendChild(oInner);
		oSelect[j].appendChild(oOption);
		for (var i=0; i<nodes.length; i++) {
			oOption = document.createElement("option");
			oInner  = document.createTextNode(nodes[i].innerHTML);
			//oOption.value = nodes[i].getAttribute("value");
			oOption.appendChild(oInner);
			oSelect[j].appendChild(oOption);
		}
	}
}

function rafraichir() {
	var arbre = document.getElementById('architecture');
	var divPoste = document.getElementsByName('nomPoste');
	arbre.innerHTML=" ";
	for (var i=0; i<divPoste.length;i++){
		var nomPoste=document.getElementById('nomPoste'+(i+1));
		var newDivPoste = document.createElement('div');
		newDivPoste.className="parent";
		newDivPoste.style="font-weight: bold";
		if (nomPoste.value){
			newDivPoste.innerHTML=nomPoste.value;
		}else{
			newDivPoste.innerHTML=nomPoste.placeholder;
		}
		arbre.appendChild(newDivPoste);
	}
	
}