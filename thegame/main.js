$('#cutoff').hide();
$('#cutoff').click(cutoff);
var pic = new Image();  // Создание нового объекта изображения
pic.src = 'https://hsto.org/storage/habrastock/i/nocopypast.png';
pic.src='sea01.jpg';

var canvas=document.getElementById("canvas");
canvas.onclick=addPoint;
var ctx  = canvas.getContext('2d');
ctx.fillStyle = '#ffffff';
var points=[], counter=0;
function cutoff() {
    console.log('you try to cut Yuliana');
    ctx.drawImage(pic, 0, 0);
    for (var i=0;i<409;i++)
    for (var j=0;j<441;j++){
        if (!inPolyline(i,j,points)){
            ctx.fillRect(i, j, 1, 1);
        }
    }
}

function addPoint(e) {
    var x = e.pageX - canvas.offsetLeft;
    var y = e.pageY - canvas.offsetTop;
    //console.log('you clicked me ',x,y);
    ctx.fillRect(x, y, 5, 5);
    points[counter]={};
    points[counter].x=x;
    points[counter].y=y;
    if (counter>1) {$('#cutoff').show()}
    counter++;
    console.log(points);
}
pic.onload = function() {    // Событие onLoad, ждём момента пока загрузится изображение
    ctx.drawImage(pic, 0, 0);  // Рисуем изображение от точки с координатами 0, 0
    ctx.globalAlpha=1;
    ctx.fillRect(0, 0, 1, 1);
};

function myXOR(a, b) {
    return ( a || b ) && !( a && b );
}

function inPolyline(x, y, tempPolyLine) {
    var i1, i2;
    var result = false;
    i2 = 0;
    i1 = tempPolyLine.length - 1;
    while (i1 >= 0) {
        if (!myXOR((tempPolyLine[i1].x < x), (x <= tempPolyLine[i2].x))) {
            if (y - tempPolyLine[i1].y < (x - tempPolyLine[i1].x)
                * (tempPolyLine[i2].y - tempPolyLine[i1].y)
                / (tempPolyLine[i2].x - tempPolyLine[i1].x)) {
                result = !result;
            }
        }
        i2 = i1;
        i1 = i1 - 1;
    }
    return result;
}



