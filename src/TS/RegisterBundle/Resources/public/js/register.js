ObjSelec = null;
ComSelect = null;
CollapseSelect = null;
function SelectLigne(obj)
{
	var idComent="coment"+obj.id;
	lineComent = document.getElementById(idComent);
	

	colId="collapse"+obj.id;
	Collapse = document.getElementById(colId);
	coment=Collapse.innerHTML;
	if (ObjSelec!=null)
	{
		if (coment != "\n\t\t\t\t\t\t\n\t\t\t\t\t")
		{
			if (ObjSelec != obj){
				ObjSelec.className = "default";
				ComSelect.style="display: none";
				obj.className="selection";
				lineComent.style="display: yes";
				Collapse.className = "collapse";
				ObjSelec = obj;
				ComSelect = lineComent;
				CollapseSelect = Collapse;
			}
			else
			{
				ObjSelec.className = "default";
				ComSelect.style="display: none";
				ObjSelec = null;
				ComSelect = null;
				CollapseSelect = null;
			}
		}
		else
		{
			ObjSelec.className = "default";
			ComSelect.style="display: none";
			obj.className="selection";
			Collapse.className = "collapse";
			ObjSelec = obj;
			ComSelect = lineComent;
			CollapseSelect = Collapse;
		}
	}
	else
	{
		if (coment != "\n\t\t\t\t\t\t\n\t\t\t\t\t")
		{
			obj.className="selection";
			lineComent.style="display: yes";
			Collapse.className = "collapse";
			ObjSelec = obj;
			ComSelect = lineComent;
			CollapseSelect = Collapse;
		}
		else
		{
			obj.className="selection";
			ObjSelec = obj;
			ComSelect = lineComent;
		}
	}
}

function EditChoix()
{
 var objId, ligneElt, coloneElt, contenu, idev;
 if (ObjSelec != null)
 {
    objId = ObjSelec.id;
 
      ligneElt = document.getElementById(objId);

      contenu = ligneElt.childNodes[1].innerHTML;
      coloneElt = document.getElementById("event_edit_startDate");
	  coloneElt.value = contenu;
	  
	  contenu = ligneElt.childNodes[3].innerHTML;
	  coloneElt = document.getElementById("event_edit_endDate");
	  coloneElt.value = contenu;
	  
	  contenu = ligneElt.childNodes[5].innerHTML;
      coloneElt = document.getElementById("event_edit_id");
	  coloneElt.value = contenu;
	  
	  /*contenu = ligneElt.childNodes[7].innerHTML;
      coloneElt = document.getElementById("");
	  coloneElt.value = contenu;*/
	  
	  contenu = ligneElt.childNodes[9].innerHTML;
      coloneElt = document.getElementById("event_edit_siteName");
	  coloneElt.value = contenu;
	  
	  contenu = ligneElt.childNodes[11].innerHTML;
      coloneElt = document.getElementById("event_edit_origin");
	  coloneElt.value = contenu;
	  
	  contenu = ligneElt.childNodes[13].innerHTML;
      coloneElt = document.getElementById("event_edit_consequence");
	  coloneElt.value = contenu;
	  
	  contenu = ligneElt.childNodes[15].innerHTML;
      coloneElt = document.getElementById("event_edit_substation");
	  coloneElt.value = contenu;
	  
	  contenu = ligneElt.childNodes[17].innerHTML;
      coloneElt = document.getElementById("event_edit_equipement");
	  coloneElt.value = contenu;
	  
	  contenu = ligneElt.childNodes[19].innerHTML;
      coloneElt = document.getElementById("event_edit_ensOperator");
	  coloneElt.value = contenu;
	  
	  contenu = ligneElt.childNodes[21].innerHTML;
      coloneElt = document.getElementById("event_edit_ensOther");
	  coloneElt.value = contenu;
	  
	  ligneElt = document.getElementById("collapse"+objId);

	  contenu = ligneElt.childNodes[1].innerHTML;
      coloneElt = document.getElementById("event_edit_coment");
	  coloneElt.value = contenu;
	      
 }
 else
 {
    alert("Vous n'avez rien sélectionné !!");
 }
}

function request() {
	var numid = document.getElementById("idevvv").value;
	var xhr   = new XMLHttpRequest();
		
	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
			readData(xhr.responseXML);
		} else if (xhr.readyState < 4) {
		}
	};
	
	xhr.open("POST", "Reg_Post3.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("IdEv="+numid);
}



function readData(oData) {
	var nodes = oData.getElementsByTagName("com");
	var com = nodes.item(0).firstChild.data;
	var oSelect = document.getElementById("comdetail");
	oSelect.innerHTML=com;
	}

