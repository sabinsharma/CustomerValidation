<?php
/**
 * Created by PhpStorm.
 * User: sharm
 * Date: 8/09/2017
 * Time: 3:56 PM
 */

include_once 'Validations.php';
class CustomerValidation
{
    private $validationFields=array();
    private $validationRules=array();
    private $invalidFields=array();
    private $invalidInfo=array();
    private $id='';


    function __construct($obj)
    {
        $this->getValidationField($obj);
        $this->validatieCustomers($obj);
        //$this->createPagination($obj);
    }

    //function that loops through all validation fields and store the field name in array
    private function getValidationField($obj){
        foreach ($obj['validations'] as $fieldsForValidation){
            $this->validationFields[]=key($fieldsForValidation); //get the field name like name,email,age,newsletter
        }
    }

    //function for pagination
    private function createPagination($obj){
        $total_rec=$obj['pagination']['total'];
        $rec_per_page=$obj['pagination']['per_page'];
        $pages=ceil($total_rec/$rec_per_page);

        $pagination="<div id='pagination_container'>";
        for($i=1;$i<=$pages; $i++){
            $pagination.="<a href='#' class='page_num'>".$i."</a>";
        }
        echo $pagination."</div>";
    }


    private function validatieCustomers($obj){
        /*static $counter=0;
        $chkType=false; //flag to ckeck if the 'type' validation should be performed
        $chkmin=false;//flag to check if the min length validation should be performed
        $flag=false;//if this flag is set to false, insert field name in array invalid fields*/
        $invalidFieldName='';
        static $cnt=0;
        //1. get the property and value of the customers
        foreach ($obj['customers'] as $customer){
            $this->id=$customer['id'];
            //2. Check if the customer property needs to be validated by comparing customers properties with field name in array validationFields
            foreach ($customer as $prop=>$propValue){
                //3. if the match is found then get the validation rule for that field.
               if(in_array($prop,$this->validationFields)){
                    foreach ($obj['validations'] as $validations){
                       if(array_key_exists($prop,$validations)){
                            //3.1 store validation rule for each field in array validationsRules
                            foreach ($validations[$prop] as $attr=>$attrValue){
                                //3.1.1 if attrValue is array get the array key and value to store in array validationsRules
                                if(is_array($attrValue)){
                                    foreach ($attrValue as $key=>$value){
                                        $this->validationRules[$key]=$value;
                                    }
                                }
                                else{
                                    $this->validationRules[$attr]=$attrValue;
                                }
                            }
                            //4. Check which keys are present in validation rules array for that particular field and perform the required validation
                            if(array_key_exists('required',$this->validationRules) && array_key_exists('type',$this->validationRules) && array_key_exists('min',$this->validationRules) ){
                                if($this->validationRules['required']==true && $this->validationRules['type']=='boolean'){
                                    $flag=Validations::validateNull($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                    else{
                                        $flag=Validations::validateBooleanValue($propValue);
                                        if(!$flag){
                                            $invalidFieldName=$prop;
                                            //break;
                                        }
                                    }
                                }
                                elseif ($this->validationRules['required']==true && $this->validationRules['type']!='boolean'){
                                    $flag=Validations::validateNull($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                    else{
                                        $flag=Validations::validateType($propValue,$this->validationRules['type']);
                                        if(!$flag){
                                            $invalidFieldName=$prop;
                                            //break;
                                        }
                                        else{
                                            $flag=Validations::validateMinLength($propValue,$this->validationRules['min']);
                                            if(!$flag){
                                                $invalidFieldName=$prop;
                                                //break;
                                            }
                                        }
                                    }
                                }
                                elseif ($this->validationRules['required']==false && $this->validationRules['type']=='boolean'){
                                    $flag=Validations::validateBooleanValue($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }

                                }
                                else{
                                    $flag=Validations::validateType($propValue,$this->validationRules['type']);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                    else{
                                        $flag=Validations::validateMinLength($propValue,$this->validationRules['min']);
                                        if(!$flag){
                                            $invalidFieldName=$prop;
                                            //break;
                                        }
                                    }
                                }
                            }
                            elseif(array_key_exists('required',$this->validationRules) && array_key_exists('type',$this->validationRules) && !array_key_exists('min',$this->validationRules) ){
                                if($this->validationRules['required']==true && $this->validationRules['type']=='boolean'){
                                    if(gettype($propValue)!='boolean'){ //handle newsletter
                                        $flag=Validations::validateNull($propValue);
                                        if(!$flag){
                                            $invalidFieldName=$prop;
                                            //break;
                                        }
                                        else{
                                            $flag=Validations::validateBooleanValue($propValue);
                                            if(!$flag){
                                                $invalidFieldName=$prop;
                                                //break;
                                            }
                                        }
                                    }

                                }
                                elseif ($this->validationRules['required']==true && $this->validationRules['type']!='boolean'){
                                    $flag=Validations::validateNull($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                    else{
                                        $flag=Validations::validateType($propValue,$this->validationRules['type']);
                                        if(!$flag){
                                            $invalidFieldName=$prop;
                                            //break;
                                        }
                                    }
                                }
                                elseif ($this->validationRules['required']==false && $this->validationRules['type']=='boolean'){
                                    $flag=Validations::validateBooleanValue($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }

                                }
                                else{

                                    $flag=Validations::validateType($propValue==NULL?0:$propValue,$this->validationRules['type']);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                }
                            }
                            elseif(array_key_exists('required',$this->validationRules) && !array_key_exists('type',$this->validationRules) && array_key_exists('min',$this->validationRules) ){
                                if($this->validationRules['required']==true){
                                    $flag=Validations::validateNull($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                    else{
                                        $flag=Validations::validateMinLength($propValue,$this->validationRules['min']);
                                        if(!$flag){
                                            $invalidFieldName=$prop;
                                            //break;
                                        }
                                    }
                                }
                                else{
                                    $flag=Validations::validateMinLength($propValue,$this->validationRules['min']);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                }
                            }
                            elseif(!array_key_exists('required',$this->validationRules) && array_key_exists('type',$this->validationRules) && array_key_exists('min',$this->validationRules) ){
                                if($this->validationRules['type']=='boolean'){
                                    $flag=Validations::validateBooleanValue($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                }
                                elseif ($this->validationRules['type']!='boolean'){
                                    $flag=Validations::validateType($propValue,$this->validationRules['type']);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                    else{
                                        $flag=Validations::validateMinLength($propValue,$this->validationRules['min']);
                                        if(!$flag){
                                            $invalidFieldName=$prop;
                                            //break;
                                        }
                                    }
                                }
                            }
                            elseif(array_key_exists('required',$this->validationRules) && !array_key_exists('type',$this->validationRules) && !array_key_exists('min',$this->validationRules) ){
                                if($this->validationRules['required']==true){
                                    $flag=Validations::validateNull($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                }
                            }
                            elseif(!array_key_exists('required',$this->validationRules) && array_key_exists('type',$this->validationRules) && !array_key_exists('min',$this->validationRules) ){
                                if($this->validationRules['type']=='boolean'){
                                    $flag=Validations::validateBooleanValue($propValue);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                }
                                else{
                                    $flag=Validations::validateType($propValue,$this->validationRules['type']);
                                    if(!$flag){
                                        $invalidFieldName=$prop;
                                        //break;
                                    }
                                }
                            }
                            else{
                                $flag=Validations::validateMinLength($propValue,$this->validationRules['min']);
                                if(!$flag){
                                    $invalidFieldName=$prop;
                                    //break;
                                }
                            }

                            $this->validationRules=array();
                            if(!empty($invalidFieldName)){
                                $this->invalidFields[]=$invalidFieldName;
                                $invalidFieldName='';

                            }

                       }
                    }
                }
            }//End of customer property and value loop.

            if(!empty($this->invalidFields)){
                $this->invalidInfo[]=array("id"=>$this->id,"invalid_fields"=>$this->invalidFields);
                $this->invalidFields=array();
            }
        }//End of customer information loop
        if(!empty($this->invalidInfo)){

            $search=array('},',':','{',',',']','{  "id"');
            $replace=array(
                '},<br/>',
                ':  ',
                '{  ',
                ',  ',
                ']  ',
                '       {   "id"'

            );

            $pattern=array('/[{]/','/[[]/');
            $replacement=array('{<br/>  ','[<br/>');


            $jsonData=json_encode(array("invalid_customers"=>$this->invalidInfo));
            $jsonData=preg_replace('/[{]/','<span style=\'white-space:pre\'>{',$jsonData,1);

            $jsonData=str_replace($search,$replace,$jsonData);
            $jsonData=preg_replace($pattern,$replacement,$jsonData,1);
            $jsonData=str_replace(']  }]  }',']  }<br/>    ]<br/>}',$jsonData);
            $jsonData=str_replace(']<br/>}',']<br/>}</span>',$jsonData);
            echo $jsonData;
        }
    }
}