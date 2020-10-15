ObjSelec = null;

function SelectLigne(obj)
{
	if (ObjSelec!=null)
	{
		if (ObjSelec != obj){
			ObjSelec.className = "default";
			obj.className="selection";
			ObjSelec = obj;
			editChoice();
		}
		else
		{
			ObjSelec.className = "default";
			ObjSelec = null;
		}
	}
	else
	{
			obj.className="selection";
			ObjSelec = obj;
			editChoice();
	}
}

function saveImport() {
	var siteId = document.getElementById('upload_file_site').value;
	var importData = [];
	var Line = {
		init: function (date, energy, irradiation) {
			this.date = date;
			this.energy = energy;
			this.irradiation = irradiation;
		}
	};
	var importTab = document.getElementsByClassName('line');
	for (var i = 0; i < importTab.length; i++) {
		var importLine = Object.create(Line);
		var date = importTab[i].childNodes[1].innerHTML;
		var energy = importTab[i].childNodes[3].innerHTML;
		var irradiation = importTab[i].childNodes[5].innerHTML;
		importLine.init(date, energy, irradiation);
		importData.push(importLine);

	}
	console.log(importData);
	url='http://localhost/myMegaPV/web/app_dev.php/datamanager/save/'+siteId;
	ajaxPost(url, importData, afficher, true);
}

function afficher() {
	var tester = document.getElementById("message");
	tester.innerHTML = "<div class=\"alert alert-info\">Les données ont bien été enregistrées !</p>";
}

function editChoice() {
	objId = ObjSelec.id;
	url = "editrow/"+objId;
	ajaxGet(url, inputForm);
}

function inputForm(data) {
	var oSelect = document.getElementById("editForm");
	oSelect.innerHTML=data;
}