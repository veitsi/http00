<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>
<? //FRONT tpl  ?>
<title><?= Editor::getVal($F_PAGE_GEN['title']) ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?= Editor::getVal($F_PAGE_GEN['description']) ?>" />
<meta name="keywords" content="<?= Editor::getVal($F_PAGE_GEN['keywords']) ?>" />
<meta name="robots" content="<?= Editor::getVal($F_PAGE_GEN['robots'], "all") ?>" />
<meta name="f_t" id="f_token" content="<?= Editor::getVal($_SESSION["token"])?>" />
<link rel="icon" href="/css/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="/css/build/css/styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>