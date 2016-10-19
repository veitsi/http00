<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>


<section class="list">
    <div class="container panel">
        <div id="tree_search_box"><label>Поиск: </label><input id="tree_search" name="tree_search" type="text"  value="" /><a href="/cabinet/look_cat.html?do=new">Добавить</a></div>
        <div id="tree_box">
            <div id="list_tree"></div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="/js/jstree/jquery.jstree.css" type="text/css" />
<script src="/js/jstree/jquery.jstree.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
        $.jstree.defaults.search.show_only_matches = true;
        $("#list_tree").jstree({
            "plugins" : ["wholerow", "search", "state"],
            "core" : {
                "check_callback" : true,
                "data" : function(request, response){
                    $.ajax({
                        url: "/_ajax.php",
                        type: "POST",
                        dataType: "json",
                        data: { file: "looks_categories", token: $('#f_token').attr("content") },
                        success: function(data) {
                            response(data);
                        }
                    });
                }
            }
        }).on("activate_node.jstree", function (e, data) {
            category_edit(data.node.id);
        }).jstree();

        var to = false;
        $("#tree_search").keyup(function () {
            if(to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = $("#tree_search").val();
                $("#list_tree").jstree(true).search(v);
            }, 250);
        });

    });
    function category_edit(id) {
        window.location.href = "/cabinet/look_cat/" + id + ".html";
    }
</script>