ObjSelec = null;

function SelectLigne(obj)
{
	if (ObjSelec!=null)
	{
		if (ObjSelec != obj){
			ObjSelec.className = "default";
			obj.className="selection";
			ObjSelec = obj;
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
	}
}

function saveImport() {
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
	url='http://localhost/myMegaPV/web/app_dev.php/datamanager/save';
	ajaxPost(url, importData, afficher, true);
}

function afficher(data) {
	var tester = document.getElementById("tableau");
	tester.innerHTML = data;
}

