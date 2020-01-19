<?php

require_once 'db.php';

require_once 'template.php';

$result = array("errors"=>"","result"=>"");


//Добавление/Удаление пользователя
if ($_POST["action"] == "add")
{
    $result["errors"] = check_fields();

    if (!empty($result["errors"]))
    {
        echo json_encode($result);
        return;
    }
    if (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
    {
        $result["errors"] = " Email указан неверно ";
        echo json_encode($result);
        return;
    }

    $db = new DB();
    $user = $db->find($_POST["email"]);
    if (!empty($user))
    {
        $result["errors"] = ' Пользователь с таким Email уже существует';
        echo json_encode($result);
        return;
    }
    $query= "INSERT INTO `users` (`fio`,`email`,`post`,`city`,`created`) VALUES (:fio,:email,:post,:city,:created)";
    $params = array(
        ":fio"=>$_POST["fio"],
        ":email"=>$_POST["email"],
        ":post"=>$_POST["post"],
        ":city"=>$_POST["city"],
        ":created"=>time()
    );
   

    $user_id = $db->query("insert",$query,$params);
    if (!empty($user_id))
    {
        $result["errors"] = 'Пользователь добавлен успешно!';
    }
}
if ($_POST["action"] == 'delete')
{
    if (!empty($_POST["id"]))
    {
        $query= "UPDATE `users` SET `del` = '1' WHERE id = :id";
        $params = array(
            "id"=>(int)$_POST["id"],
        );
        $db = new DB();
        $db->query("update",$query,$params);
    }
}

//Из класса шаблона извлекаем список пользователей
$result["result"] = Template::show_list_users();

echo json_encode($result); 

function check_fields()
{
    if (empty($_POST["fio"]))
    {
        return " Укажите ФИО ";
    }
    if (empty($_POST["email"]))
    {
        return  " Укажите Email";
    }
}