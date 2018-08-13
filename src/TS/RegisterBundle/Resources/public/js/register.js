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

	var removeform = document.getElementById("removeform");
	removeform.action = "removeevent/"+obj.id;
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
				editChoice();
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
			editChoice();
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
			editChoice();
		}
		else
		{
			//obj.className="selection";
			ObjSelec = obj;
			ComSelect = lineComent;
			editChoice();
		}
	}
}

function editChoice() {
	if (ObjSelec != null)
	{
		objId = ObjSelec.id;
		url = "editevent/"+objId;
		ajaxGet(url, inputForm);
	}
	else
	{
		alert("Vous n'avez rien sélectionné !!");
	}
}

function inputForm(data) {
	var oSelect = document.getElementById("editForm");
	oSelect.innerHTML=data;
}

document.getElementById("ts_registerbundle_event_site").addEventListener("change", function (e) {
	url = "listsubstations/"+e.target.value;
	ajaxGet(url, listSubstations);
});

function listSubstations(data) {
	var select = document.getElementById("ts_registerbundle_event_substation");
	var json=JSON.parse(data);
	var html = "<option></option>";
	
	json.substations.forEach(function (substation) {
		html +="<option value=\""+substation.id+"\">";
		html += substation.name;
		html +="</option>";
	});

	select.innerHTML = html;
}
document.getElementById("ts_registerbundle_event_substation").addEventListener("change", function (e) {
	url = "listequipments/"+e.target.value;
	ajaxGet(url, listequipments);
});

function listequipments(data) {
	var select = document.getElementById("ts_registerbundle_event_equipment");
	var json=JSON.parse(data);
	var html = "<option></option>";
	
	json.equipment.forEach(function (equipment) {
		html +="<option value=\""+equipment.id+"\">";
		html += equipment.name;
		html +="</option>";
	});

	select.innerHTML = html;
}