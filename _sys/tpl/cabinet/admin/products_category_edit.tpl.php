<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>

<section>
    <!--EDITABLE USER BLOCK-->
    <div class="container panel">

        <a href="/cabinet/prod_cat.html">К списку категорий</a><br /><br />

        <form id="prod_cat" name="prod_cat" method="post">
            Родительская категория: <?=$select_parent_category->getHTML() ?><br />
            Название: <input type="text" name="name" value="<?=Editor::getVal($data["name"])?>" /><br />
            Показать на сайте: <input name="enabled" <? if (Editor::getVal($data["enabled"],"1") == 1): ?>checked<? endif; ?> type="checkbox" value="1" /><br />
            <input type="hidden" name="id" value="<?=Editor::getVal($data["id"],0)?>" />
        </form>
        <a href="#js" id="save_category">Сохранить</a><br />
        <div id="o_result" style="display: none"><?=Editor::getVal($o_result)?></div>

    </div>
</section>
<script type="text/javascript">
    $(function() {
        if ($("#o_result").html() != "") {
            alert($("#o_result").html());
        }
        $("#save_category").on("click", function(e) {
            e.preventDefault();
            form_data = $("#prod_cat").serialize();
            $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'products_categories_func', data: form_data}, function(r) {
                try {
                    result = jQuery.parseJSON(r);
                } catch(err){
                    alert(err);
                }
                if (result.status == "success") {
                    if (typeof result.data.last_id !== 'undefined') {
                        window.location.href = "/cabinet/prod_cat/" + result.data.last_id + ".html";
                    } else {
                        alert(result.mes);
                    }
                } else {
                    alert(result.mes);
                }
            });
        });
    });
</script>