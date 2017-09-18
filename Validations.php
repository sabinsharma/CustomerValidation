<?php
/**
 * Created by PhpStorm.
 * User: sharm
 * Date: 1/09/2017
 * Time: 12:47 PM
 */

class Validations
{
    public static function validateNull($val){
        if(!empty(trim($val))){
            return true;
        }
        else
        {
            //echo "Validation failed for NULL<br/>";
            return false;

        }
    }

    public static function validateType($val, $type){
            $valType=gettype($val);
            $type=($type=="number")?'integer':$type;
            //echo "<span style='color:red'>value is $val, supplied type is $type and value type is $valType<br/></span>";
            if ($valType==$type){
                    return true;
            }
            else
            {
                //echo "Validation failed for Type<br/>";
                return false;
            }
    }



    public static function validateMinLength($val,$min){
        $len=strlen($val);
        //echo "<br> length of $val is $len and min is $min";
        if($len>=$min){
            return true;
        }
        else{
            //echo "Validation failed for MIN<br/>";
            return false;

        }
    }

    public static function validateBooleanValue($val){
        if(gettype($val)=='boolean'){
            return true;
        }
        else
        {
            //echo "Validation failed for Boolean Type<br/>";
            return false;
        }
    }
}