<!DOCTYPE html> 
<html>
<head>
    <meta charset="utf-8" /> 
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="content">
    <div class="data-users">
        <form class="add-user">
            <div class="form-field">
                <input type="text"  class="form-input" placeholder="ФИО" name="user_fio" value="">
            </div>
            <div class="form-field">
                <input type="text" class="form-input" placeholder="Должность" name="user_post" value="">
            </div>
            <div class="form-field">
                <input type="text" class="form-input" placeholder="Город" name="user_city" value="">
            </div>
            <div class="form-field">
                <input type="email" class="form-input" placeholder="Email"  name="user_mail" value="">
            </div>
            <input type="button" class="add" value="Добавить">
            <div class="errors"></div>
        </form>
        <div class="data-users__table">
            <?php require_once('template.php');
                echo Template::show_list_users();
            ?>
        </div>
    </div>
</div>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/common.js"></script>
</body>
</html>