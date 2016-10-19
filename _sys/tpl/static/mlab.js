function getItems(p,n) {
    var strUrl = "https://hook.io/tvstyle/"+p+"?v="+n,
        strReturn = "";
    jQuery.ajax({
        url: strUrl,
        success: function(json) {
            strReturn = JSON.parse(json);
        },
        async:false
    });
    return strReturn;
}
jQuery.fn.rotate = function (degrees) {$(this).css({'transform': 'rotate(' + degrees + 'deg)'});};
$log='console.log("log function");';
$droppedIn=unescape('%20%20%20%20if%20%28this%20%21%3D%3D%20eventTarget%29%20%7B%0A%20%20%20%20%20%20%20%20return%0A%20%20%20%20%7D%0A%20%20%20%20%24%28this%29.empty%28%29.addClass%28%27opacity%27%29%3B%0A%20%20%20%20%24%28%27%3Cimg%20src%3D%22%27%20+%20ui.draggable.attr%28%27src%27%29%20+%20%27%22%3E%27%29.%0A%20%20%20%20%20bind%28%27click%27%2C%20menuShow%29.appendTo%28this%29%3B');
jQuery.fn.registerEvent = function (ki) {window[ki]=Function ("event, ui",window['$'+ki]);};
jQuery.fn.syncEvent = function (ki) {
    $.get("https://hook.io/tvstyle/"+ki.toLowerCase(),function (data) {
        window[ki]=Function ("event, ui",data);
    });
};