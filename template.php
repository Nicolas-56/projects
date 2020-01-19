<?php

require_once 'db.php';


class Template 
{
    public static function show_list_users()
    {
        $db= new DB();
        //Извлекаем не удаленных пользователей
        $users = $db->fetchAll('users',"del='0'");
        $html = "";
        if (!empty($users))
        {
            $html .= '<table class="users-table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Должность</th>
                    <th>Город</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach ($users as $user) 
            {   
                $html .= '<tr>
                     <td>'.$user["fio"].'</td>
                     <td>'.$user["post"].'</td>
                     <td>'.$user["city"].'</td>
                     <td>'.$user["email"].'</td>
                     <td data-id="'.$user["id"].'" class="delete">Удалить</td>
                </tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
        }
        return $html;
    }

}


