<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>

<section>
    <!--EDITABLE USER BLOCK-->
    <div class="container panel">
        <div class="b-user row clearfix">
            <div class="col-sm-2">
                <div class="b-user-view thumbnail">
                    <div class="b-user-avatar">
                        <img class="b-user-avatar__image" src="http://placekitten.com/80/80" alt="...">
                    </div>
                    <div class="b-user-caption">
                        <div class="b-user-caption__item">Дата регистрации:</div>
                        <div class="b-user-caption__item"><?=DB::fromUnixDate($data["regdate"])?></div>
                    </div>
                    <? if(!empty($data["birthdate"])): ?>
                    <div class="b-user-caption">
                        <div class="b-user-caption__item">День рождения</div>
                        <div class="b-user-caption__item"><?=DB::fromUnixDate($data["birthdate"])?></div>
                    </div>
                    <? endif; ?>
                    <div class="b-user-caption">
                        <div class="b-user-caption__item">Луков / Лайков</div>
                        <div class="b-user-caption__item">?? / ??</div>
                    </div>
                </div>
            </div>
            <div class="b-user-data col-sm-4">
                <div class="b-user-data-social">
                    <a href="" class="b-user-data-social__link icon-pin"></a>
                    <a href="" class="b-user-data-social__link icon-fb"></a>
                    <a href="" class="b-user-data-social__link icon-twit"></a>
                    <a href="" class="b-user-data-social__link icon-insta"></a>
                    <a href="" class="b-user-data-social__link icon-vk"></a>
                </div>
                <form name="user_data" id="user_data" class="b-form b-form_vertical" method="post">
                    <div class="b-form-item">
                        <input type="text" name="name" class="b-input b-input_ad" value="<?=$data["name"]?>" placeholder="Имя и фамилия" />
                    </div>
                    <div class="b-form-item">
                        <input type="text" class="b-input b-input_ad" disabled value="<?=$data["login"]?>" />
                        <button class="b-form-item-button">
                            <span class="b-form-item-button__icon icon-external-link"></span>
                        </button>
                    </div>
                    <div class="b-form-item">
                        <input type="text" name="city" class="b-input b-input_ad" value="<?=$data["city"]?>" placeholder="Город" >
                    </div>
                    <div class="b-form-item">
                        <input type="text" class="b-input b-input_ad">
                        <button class="b-form-item-button">
                            <span class="b-form-item-button__icon icon-external-link"></span>
                        </button>
                    </div>
                    <div class="b-form-item">

                        <button class="b-form-item-button dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="b-form-item-button__icon icon-arrow-down"></span>
                        </button>
                        <?=$select_roles->getHTML()?>
                    </div>
                    <input type="hidden" name="id" value="<?=$data["id"]?>">
                </form>
            </div>
            <div class="b-user-addons col-sm-6">
                <div class="b-user__header">Обо мне</div>
                <div class="b-user-addons-text">
                    <textarea name="about_me" id="aboutme_field" cols="30" rows="10" class="b-user-addons__textarea" disabled><?=$data["about"]?></textarea>
                </div>
            </div>

        </div>

        <!--ADMIN COMMENTS-->
        <div class="b-block">
            <div class="b-admin-comment">
                <form name="admin_data" id="admin_data" method="post" class="b-admin-comment-form">
                    <label for="" class="b-admin-comment-form__label">Комментарии администратора</label>
                    <textarea name="comment" cols="30" rows="10" class="b-admin-comment__textarea"><?=$data["comment"]?></textarea>
                    <div class="b-buttons-set">
                        <button id="save_user" class="b-button b-button_ad">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>

        <!--TABLE WITH FILTERS-->
<!--        <div class="b-block">-->
<!--            <ul class="b-tabs">-->
<!--                <li class="b-tabs-item b-tabs-item_active" role="presentation"><a class="b-tabs-item__link" href="#">Луки</a></li>-->
<!--                <li class="b-tabs-item" role="presentation"><a class="b-tabs-item__link" href="#">Коллекции</a></li>-->
<!--                <li class="b-tabs-item" role="presentation"><a class="b-tabs-item__link" href="#">Шаблоны</a></li>-->
<!--                <li class="b-tabs-item" role="presentation"><a class="b-tabs-item__link" href="#">Задачи</a></li>-->
<!--                <li class="b-tabs-item" role="presentation"><a class="b-tabs-item__link" href="#">Новости</a></li>-->
<!--                <li class="b-tabs-item" role="presentation"><a class="b-tabs-item__link" href="#">Покупки</a></li>-->
<!--            </ul>-->
<!--            <div class="filters">-->
<!--                <form role="form">-->
<!--                    <input type="checkbox" title="checkbox">-->
<!--                    <div class="form-group">-->
<!--                        <input class="filters__date" type="date" name="calendar" title="date" value="2016-12-01" max="2016-12-31" min="2016-01-01">-->
<!--                        <span>—</span>-->
<!--                        <input class="filters__date" type="date" name="calendar" title="date" value="2016-12-01" max="2016-12-31" min="2016-01-01">-->
<!--                    </div>-->
<!--                    <input class="filters__btn btn btn-success" type="submit" value="Применить">-->
<!--                </form>-->
<!--            </div>-->
<!--            <table class="table" id="myTable">-->
<!--                <thead>-->
<!--                <tr class="active">-->
<!--                    <th>Категория</th>-->
<!--                    <th>Лайки</th>-->
<!--                    <th>Количество луков</th>-->
<!--                    <th>Корзина по штукам</th>-->
<!--                    <th>Корзина по вещам</th>-->
<!--                    <th>Корзина по сумме, грн.</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                <tr>-->
<!--                    <td>Передача</td>-->
<!--                    <td>2233</td>-->
<!--                    <td>30</td>-->
<!--                    <td>30</td>-->
<!--                    <td>30</td>-->
<!--                    <td>20 235 UAH</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>Передача</td>-->
<!--                    <td>2233</td>-->
<!--                    <td>30</td>-->
<!--                    <td>30</td>-->
<!--                    <td>30</td>-->
<!--                    <td>20 235 UAH</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>Передача</td>-->
<!--                    <td>2233</td>-->
<!--                    <td>30</td>-->
<!--                    <td>30</td>-->
<!--                    <td>30</td>-->
<!--                    <td>20 235 UAH</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>Передача</td>-->
<!--                    <td>2233</td>-->
<!--                    <td>30</td>-->
<!--                    <td>30</td>-->
<!--                    <td>30</td>-->
<!--                    <td>20 235 UAH</td>-->
<!--                </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
    </div>
</section>
<script type="text/javascript">
    $(function() {
        $("#save_user").on("click", function(e) {
            e.preventDefault();
            form_data = $("#user_data, #admin_data").serialize();
            $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'users_func', data: form_data}, function(r) {
                try {
                    result = jQuery.parseJSON(r);
                } catch(err){
                    alert(err);
                }
                if (result.status == "success") {
                    alert(result.mes);
                } else {
                    alert(result.mes);
                }
            });
        });
    });
</script>