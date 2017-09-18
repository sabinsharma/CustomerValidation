<?php
/**
 * Created by PhpStorm.
 * User: sharm
 * Date: 3/09/2017
 * Time: 1:24 PM
 */

//variables
/*$fieldForValidation=array();
$validationRule=array();
$customerInfo=array();*/

switch($_POST['task']){
    case 'pagination':
        createPagination($_POST['pagenum']);
        break;
    case 'customerValidation':
        customerValidation($_POST['pagenum']);
        break;
}

function createPagination($pageNumber){
    $obj=getInfo($pageNumber);

    $total_rec=$obj['pagination']['total'];
    $rec_per_page=$obj['pagination']['per_page'];
    $pages=ceil($total_rec/$rec_per_page);

    $pagination="<div id='pagination_container'>";
    for($i=1;$i<=$pages; $i++){
        if($pageNumber==$i){
            $pagination.="<a href='#' class='page_num active'>".$i."</a>";
        }
        else{
            $pagination.="<a href='#' class='page_num'>".$i."</a>";
        }

    }
    echo $pagination."</div>";

}

function customerValidation($pageNumber){
    $obj=getInfo($pageNumber);

    include_once 'CustomerValidation.php';

    $customerValidation=new CustomerValidation($obj);

}


//getInfo(2);

function getInfo($pageNumber)
{
    $url="https://backend-challenge-winter-2017.herokuapp.com/customers.json?page=$pageNumber";
    $curl=curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    $curl_response=curl_exec($curl);
    curl_close($curl);

    $obj=json_decode($curl_response,true);

    return $obj;

    /*$url="https://backend-challenge-winter-2017.herokuapp.com/customers.json?page=$page_number";

    $curl=curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $curl_response=curl_exec($curl);

    curl_close($curl);

    $obj=json_decode($curl_response,true);

    //include_once 'ApiCall.php';
    include_once 'CustomerValidation.php';

    $customerValidation=new CustomerValidation($obj);*/
}



/*function getValidationField($obj){
    foreach ($obj['validations'] as $validationFields){
        $fieldForValidation[]=key($validationFields);
    }
}

function getValidationRule($obj,$field){
    foreach ($obj['validations'] as $validationFields=>$validationValue){
        if(key_exists($field,$validationValue))
            print_r($validationValue[$field]);
    }
}

function getCustomerInfo($obj){
    foreach ($obj['customers'] as $attr=>$value){
        $customerInfo=$value;
    }
    //print_r($customerInfo);
}

function validateCustomerInfo($customerInfo){
    foreach($customerInfo as $key=>$value){
        echo $value;
    }
}*/