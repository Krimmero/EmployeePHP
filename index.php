<?php
require_once 'vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));




//echo $result;






$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$url = 'http://localhost:25134/EmployeeService.svc/GetEmployeeList/';
curl_setopt($curl, CURLOPT_URL, $url);
$response = curl_exec($curl);

//echo $response;


curl_close($curl);
$jsonObj = json_decode($response);

//echo print_r($jsonObj);

$id = "1";

if (isset($_POST['idValue']))
{
    $id = $_POST['idValue'];
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$url = 'http://localhost:25134/EmployeeService.svc/GetEmployeeById/'.$id;
curl_setopt($curl, CURLOPT_URL, $url);
$result = curl_exec($curl);


curl_close($curl);
$jsonObjId = json_decode($result);



$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array('title' => 'Employee PHPApp', 'json' => $jsonObj, 'jsonId' => $jsonObjId));
