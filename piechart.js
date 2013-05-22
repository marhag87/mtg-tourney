var myColor = ["#994499","#5574a6","#e67300","#109618","#990099","#0099c6","#dd4477","#66aa00","#b82e2e","#316395"];
//var myColor = ["#984EA3","#377EB8","#4DAF4A","#E41A1C","#FF7F00","#FFFF33","#A65628","#F781BF","#999999"];

function getTotal(myData){
	var myTotal = 0;
	for (var j = 0; j < myData.length; j++) {
		myTotal += (typeof myData[j] == 'number') ? myData[j] : 0;
	}
	return myTotal;
}

function plotData(myData) {
	var radius = 75;
	var canvas;
	var ctx;
	var lastend = 0;
	var myTotal = getTotal(myData);

	canvas = document.getElementById("canvas");
	ctx = canvas.getContext("2d");
	ctx.clearRect(0, 0, canvas.width, canvas.height);

	for (var i = 0; i < myData.length; i++) {
		ctx.fillStyle = myColor[i%myColor.length];
		ctx.beginPath();
		ctx.moveTo(radius,radius);
		ctx.arc(radius,radius,radius,lastend,lastend+
			(Math.PI*2*(myData[i]/myTotal)),false);
		ctx.lineTo(radius,radius);
		ctx.fill();
		lastend += Math.PI*2*(myData[i]/myTotal);
	}
}
