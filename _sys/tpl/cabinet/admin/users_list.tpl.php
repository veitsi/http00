<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>

<section class="filters">
    <div class="container">
        <h3 class="filters__headline">Пользователи</h3>
        <form role="form">
            <form class="b-form" role="form">
                <div class="b-form-item">
                    <!-- Этот селект будет построен динамически -->
                    <button class="b-form-item-button dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="b-form-item-button__icon icon-arrow-down"></span>
                    </button>
                    <select class="b-select" id="user_role" name="user_role">
                        <option value="0">Все</option>
                        <option value="1">Администратор</option>
                        <option value="2">Менеджер</option>
                        <option value="3">Пользователь</option>
                        <option value="4">Стилист</option>
                    </select>
                </div>
<!--            <input type="checkbox" title="checkbox">-->
<!--            <div class="form-group">-->
<!--                <input class="filters__date" type="date" name="calendar" title="date" value="2016-12-01"-->
<!--                       max="2016-12-31" min="2016-01-01">-->
<!--                <span>&mdash;</span>-->
<!--                <input class="filters__date" type="date" name="calendar" title="date" value="2016-12-01"-->
<!--                       max="2016-12-31" min="2016-01-01">-->
<!--            </div>-->
<!--            <div class="dropdown-user dropdown">-->
<!--                <button class="filters__dropdown btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">-->
<!--                    Пользователь-->
<!--                    <span class="filters__caret caret"></span>-->
<!--                </button>-->
<!--                <ul class="dropdown-menu" id="testSelect" role="menu" aria-labelledby="dropdownMenu1">-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Пользователь 1</a></li>-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Пользователь 2</a></li>-->
<!--                    <li role="presentation" class="divider"></li>-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Пользователь 3</a></li>-->
<!--                </ul>-->
<!--            </div>-->
<!--            <div class="dropdown-status dropdown">-->
<!--                <button class="filters__dropdown btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">-->
<!--                    Не подтверждены-->
<!--                    <span class="filters__caret caret"></span>-->
<!--                </button>-->
<!--                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Не подтверждены 1</a></li>-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Не подтверждены 2</a></li>-->
<!--                    <li role="presentation" class="divider"></li>-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Не подтверждены 3</a></li>-->
<!--                </ul>-->
<!--            </div>-->
            <div class="b-form-item">
                <input class="filters__name" type="text" title="name" id="search" name="search" />
            </div>
<!--            <input class="filters__btn btn btn-success" type="submit" value="Применить">-->
        </form>
    </div>
</section>

<section class="list">
    <div class="container panel">
        <table class="table" id="data_list" class="display cell-border">
            <thead>
                <tr class="active">
                    <th>№</th>
                    <th>ФИО</th>
                    <th>Роль</th>
                    <th>Email</th>
                    <th>Регистрация</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</section>


<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(function() {
        dt_build();
        $(document).on('change', '#user_role', function() {
            listtable.fnDraw();
        });

        $('#search').on( 'keyup', function () {
            listtable.api().search(this.value).draw();
        } );
    });
    function dt_build() {
        listtable = $("#data_list").dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/_ajax.php",
                type: "POST",
                data: function (d) {
                    d.file = "users_list",
                    d.token = $('#f_token').attr("content"),
                    d.type = parseInt($("#user_role option:selected").val())
                }
            },
            dom: 'rtp',
            language: {"url": "/js/datatable/datatable.ru.json"},
            iDisplayLength: 20,
            lengthChange: false,
            pagingType: "numbers",
            info:     false,
            bStateSave: true,
            order: [[ 1, "desc" ]],
            aoColumnDefs: [
                {"aTargets": ["dt_nosort"], "bSortable": false},
                {"aTargets": ["dt_nosearch"], "bSearchable": false}
            ],
            fnRowCallback: function (nRow, aData) {
                $(nRow).attr("onclick", "window.location.href = '/cabinet/users/" + aData[0] + ".html'");
            }
        });
    }
</script>