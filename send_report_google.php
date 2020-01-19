<?php
     
require_once 'db.php';
require_once __DIR__ . '/vendor/autoload.php';
 

$db = new DB();
$current_day = strtotime(date("d.m.Y"));
$next_day = $current_day+86400;
$users = $db->fetchAll('users'," created >= ".$current_day . " AND created < ".$next_day);

//посчитаем кол-во удаленных и добавленных пользователей за текущую дату
if (!empty($users))
{
    $delete_count = 0;
    foreach ($users as $user) 
    {
        if (!empty($user["del"]))
        {
            $delete_count++;
        }
    }
    // Путь к файлу ключа сервисного аккаунта
    $googleAccountKeyFilePath = __DIR__ . '/assets/project_google.json';
    putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );

    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();

    // Области, к которым будет доступ
    // https://developers.google.com/identity/protocols/googlescopes
    $client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );

    $service = new Google_Service_Sheets( $client );
    
    // ID таблицы
    $spreadsheetId = '';

    //определим кол-во существующих строк и соответственно номер новой строки
    $result = $service->spreadsheets_values->get($spreadsheetId, 'A1:A');
    $numRows = $result->getValues() != null ? count($result->getValues()) : 0;

    $values = [
        [date("d.m.Y"),count($users),$delete_count],
    ];
    $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values ] );
    
    // valueInputOption - определяет способ интерпретации входных данных
    // RAW | USER_ENTERED
    $options = array( 'valueInputOption' => 'RAW' );
    
    
    $service->spreadsheets_values->update( $spreadsheetId, 'Лист1!A'.($numRows+1), $body, $options );
   
}







