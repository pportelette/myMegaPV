document.getElementById("parameters").addEventListener("change", function (e) {
    var check1 = document.getElementById("myonoffswitch1");
    var check2 = document.getElementById("myonoffswitch2");
    var check3 = document.getElementById("myonoffswitch3");
    var curveInfo = [check1.checked, check2.checked, check3.checked];
    console.log(curveInfo);
    if (check1.checked){
        var e = 1;
    } else {
        var e = 0;
    }
    if (check2.checked){
        var i = 1;
    } else {
        var i = 0;
    }
    if (check3.checked){
        var p = 1;
    } else {
        var p = 0;
    }
    url='http://localhost/myMegaPV/web/app_dev.php/datamanager/curves/trend/'+e+'/'+i+'/'+p;
    console.log(url);
	ajaxGet(url, displayCurve, false);

});

function displayCurve(data) {
    var oSelect = document.getElementById("curveDiv");
    console.log(data);
    oSelect.innerHTML="";
    oSelect.innerHTML=data;
}
