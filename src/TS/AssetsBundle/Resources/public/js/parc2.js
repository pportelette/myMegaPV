ObjSelec = null;
function SelectSite(obj)
{
	var idSite = obj.id;
	var nomSite = obj.innerHTML;
	var elmtt = document.getElementById("nomSiteArbre");
	var div = document.getElementById("arborescence");
	div.style = "display: inline-block";
	var div2 = document.getElementById("description");
	div2.style = "display: none";
	elmtt.value=idSite;
	elmtt.innerHTML=nomSite;
	url = "getsite/"+idSite;
	ajaxGet(url, makeTree);
}

function makeTree(oData) {
	var json=JSON.parse(oData);
	var html = "";
	
	json.listAssets.forEach(function (substation) {
		html +="<div class=\"parent\">";
		html += substation.name;
		for (var i = 0; i < substation.equipments.length; i++) {//forEach(function (equipment) {
			html +="<div id=\""+substation.id[i]+"\" onclick=\"SelectEqu(this)\">";
			html +="<p>"+substation.equipments[i]+"</p>";
			html +="</div>";
		};
		html +="</div>";
	});
	
	var oSelect = document.getElementById("architecture");
	oSelect.innerHTML=html;
	/*var postes = oData.getElementsByTagName("poste");
	var html="";
	for (var i=0;i<postes.length;i++){
		var niv1 = postes[i].childNodes;
		for(var j=0;j<niv1.length;j++){
			if (niv1[j].firstChild.nodeType==3){
				var jprime=j+1;
				if (jprime == niv1.length || niv1[jprime].firstChild.nodeType==3){
					html +="<div style=\"font-weight: bold\">";
					html += niv1[j].innerHTML;					
					html +="</div>";
				}else{
					html +="<div class=\"parent\" style=\"font-weight: bold\">";
					html += niv1[j].innerHTML;					
				}
			}else{
				var niv2=niv1[j].childNodes;
				for (var k=0;k<niv2.length;k++){
					if (niv2[k].firstChild.nodeType==3){
						var kprime=k+1;
						if(kprime== niv2.length || niv2[kprime].firstChild.nodeType==3){
							html +="<div style=\"font-weight: normal\" onclick=\"SelectMateriel(this.innerHTML)\">";
							html += niv2[k].innerHTML;					
							html +="</div>";
						}else{
							html +="<div class=\"parent\" style=\"font-weight: normal\" onclick=\"SelectMateriel(this.innerHTML)\">";
							html += niv2[k].innerHTML;							
						}
					}else{
						var niv3=niv2[k].childNodes;
						for (var l=0;l<niv3.length;l++){
							if (niv3[l].firstChild.nodeType==3){
								var lprime=l+1;
								if(lprime== niv3.length || niv3[lprime].firstChild.nodeType==3){
									html +="<div style=\"font-weight: normal\" onclick=\"SelectMateriel(this.innerHTML)\">";
									html += niv3[l].innerHTML;					
									html +="</div>";
								}else{
									html +="<div class=\"parent\" style=\"font-weight: normal\" onclick=\"SelectMateriel(this.innerHTML)\">";
									html += niv3[l].innerHTML;										
								}
							}else{								
								html +="</div>";
							}
						}
						html +="</div>";
					}
				}
				html +="</div>";
			}
		}
	}
;*/
}

function SelectEqu(obj)
{
	var equId = obj.id;
	url = "getequipment/"+equId;
	ajaxGet(url, displayEquipment);
	return false;
}

function displayEquipment (html) {
	var div = document.getElementById("description");
	div.innerHTML = html;
	div.style = "display: inline-block";
}
