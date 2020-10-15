var editableElt = document.getElementsByClassName("contentEditable");
for (var i = 0; i < editableElt.length; i++) {
    editableElt[i].addEventListener("focus", function (e) {
        var originalValueTarget = e.target.textContent;
        e.target.addEventListener("blur", function (e) {
            var classTarget = e.target.className;
            var valueTarget = e.target.textContent;
            if (valueTarget != originalValueTarget) {
                var eventId = classTarget.substring(classTarget.indexOf('column')-1, classTarget.indexOf('row')+3)
                var rowId = classTarget.substring(classTarget.length, classTarget.indexOf('column')+6)
                console.log('colonne '+rowId+' ligne '+eventId+' valeur '+valueTarget);
                var totalEvent = document.getElementById(eventId).innerHTML;
                var events = document.getElementsByClassName("row"+eventId);
                var totalDay = document.getElementById(rowId).innerHTML;
                var days = document.getElementsByClassName("column"+rowId);
                
                var sumDay = 0;
                for (var j = 0; j < days.length; j++) {
                    sumDay = sumDay+parseFloat(days[j].textContent);
                }
                console.log("Ancienne valeur : "+totalDay+" nouvelle valeur : "+sumDay);
        
                var sumEvent = 0;
                for (var k = 0; k < events.length; k++) {
                    sumEvent = sumEvent+parseFloat(events[k].textContent);
                }
                console.log("Ancienne valeur : "+totalEvent+" nouvelle valeur : "+sumEvent);
                document.getElementById(eventId).innerHTML = sumEvent;
                document.getElementById(rowId).innerHTML = sumDay;
            }
        });
    });
}

function saveEns() {
	var ensElts = document.getElementsByClassName('ensEventDay');
    var tableRespone=[];
    var Loss = {
		init: function (id, value) {
			this.id = id;
			this.value = value;
		}
    };

    for (var i = 0; i < ensElts.length; i++) {
        var id = ensElts[i].id;
        var idEns = id.substring(id.length, 3);
        var valueEns = ensElts[i].textContent;
        var loss = Object.create(Loss);
        loss.init(idEns, valueEns);
		tableRespone.push(loss);
    }
    console.log(tableRespone);
	url='http://localhost/myMegaPV/web/app_dev.php/register/manageens/save';
	ajaxPost(url, tableRespone, afficher, true);
}

function afficher() {
	var tester = document.getElementById("message");
	tester.innerHTML = "<div class=\"alert alert-info\">Les données ont bien été enregistrées !</p>";
}