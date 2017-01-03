<?php

///Twig autoload - rightclick on project - composer x 2
require_once 'vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));

///Puts out entire list///
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$url = 'http://localhost:25134/EmployeeService.svc/GetEmployeeList/';
curl_setopt($curl, CURLOPT_URL, $url);
$response = curl_exec($curl);

///To check response///
//echo $response;

curl_close($curl);
$jsonObj = json_decode($response);

///print_r puts out object better looking///
//echo print_r($jsonObj);


$id = "";
/// if idValue in form is input, set $id to idValue///
if (isset($_POST['idValue']))
{
    $id = $_POST['idValue'];
}

///Puts out item with the matching $id///
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$url = 'http://localhost:25134/EmployeeService.svc/GetEmployeeById/'.$id;
curl_setopt($curl, CURLOPT_URL, $url);
$result = curl_exec($curl);

curl_close($curl);
$jsonObjId = json_decode($result);

$name = "";
/// if searchData in form is input, set $name to searchData///
if (isset($_POST['searchData']))
{
    $name = $_POST['searchData'];
}

///Puts out item with the matching fragtment of lastname///
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$url = 'http://localhost:25134/EmployeeService.svc/GetEmployeeByLastName/'.$name;
curl_setopt($curl, CURLOPT_URL, $url);
$nameResult = curl_exec($curl);



curl_close($curl);
$jsonObjName = json_decode($nameResult);

//echo print_r($jsonObjName);

///Twig template to put the wanted data to the html///
$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array('title' => 'Employee PHPApp', 'json' => $jsonObj, 'jsonId' => $jsonObjId, 'jsonName' => $jsonObjName));
