<?php


namespace Wepesi\App;

/**
 * Description of VNumber
 *
 * @author Lenovo
 */
class VDate
{
    private $date_value;
    private $string_item;
    private $source_data;
    private $_errors;
    private $_min;
    private $_max;
//    private $_mois=["Janviers","Fevrier","Mars","Avril","Mai","Juin","Jouillet","Aout","Septenbre","Octobre","Novembre","Decembre"];
    //put your code here
    function __construct(array $source,string $string_item=null) {
        $this->date_value=$source[$string_item];
        $this->string_item=$string_item;
        $this->source_data=$source;
        $this->_max= $this->_min=0;
        $this->checkExist();
    }

    /**
     * @return $this
     */
    function now(){
        $min_date_time=strtotime("now");
        $min_date=date("d/F/Y",$min_date_time);
        $date_value_time= strtotime($this->date_value);
        if ($date_value_time < $min_date_time) {
            $message=[
                "type"=>"date.now",
                "message"=> "`{$this->string_item}` should be greater than now",
                "label"=>$this->string_item,
                "limit"=>$min_date
            ];
            $this->addError($message);
        }
        return $this;
    }

    /**
     * @param string|null $times
     * @return $this
     * while trying to get day validation use this module
     */
    function today(string $times=null){
        $regeg="#+[0-9]h:[0-9]min:[0-9]sec#";
        $min_date_time=strtotime("now {$times}");
        $min_date=date("d/F/Y",$min_date_time);
        $date_value_time= strtotime($this->date_value);
        if ($date_value_time > $min_date_time) {
            $message=[
                "type"=>"date.now",
                "message"=> "`{$this->string_item}` should be greater than today ",
                "label"=>$this->string_item,
                "limit"=>$min_date
            ];
            $this->addError($message);
        }
        return $this;
    }
    /**
     * @param string $rule_values
     * @return $this
     * get the min date control from the given date
     */
    function min(string $rule_values=null){
        /**
         * $regex= "#[a-zA-Z]#";
         * $time= preg_match($regex,$rule_values);
         * $con=!$time?$time:(int)$time;
         * in case the parameters are integers
         */
        $rule_values=isset($rule_values)?$rule_values: "now";
        $min_date_time=strtotime($rule_values);
        $min_date=date("d/F/Y",$min_date_time);
        $date_value_time= strtotime($this->date_value);
        if ($date_value_time > $min_date_time) {
            $message=[
                "type"=>"date.min",
                "message"=> "`{$this->string_item}` should greater than `{$min_date}`",
                "label"=>$this->string_item,
                "limit"=>$min_date
            ];
            $this->addError($message);
        }
        return $this;
    }

    /**
     * @param string|null $rule_values
     * @return $this
     * while try to check maximum date of a defined period use this module
     */
    function max(string $rule_values=null){
        $rule_values=isset($rule_values)?$rule_values: "now";

        $max_date_time=strtotime($rule_values);
        $max_date=date("d/F/Y",$max_date_time);
        $date_value_time= strtotime($this->date_value);
        if ($max_date_time<$date_value_time) {
            $message = [
                "type" => "date.max",
                "message" => "`{$this->string_item}` should be less than `{$max_date}`",
                "label" => $this->string_item,
                "limit" => $max_date
            ];
            $this->addError($message);
        }
        return $this;
    }
    /**
     * @return $this
     * call this module is the input is requied and should not be null or empty
     */
    function required(){
        $required_value= trim($this->date_value);
        if (empty($required_value) || strlen($required_value)==0) {
            $message = [
                "type"=> "any.required",
                "message" => "`{$this->string_item}` {$this->lang->required}",
                "label" => $this->string_item,
            ];
            $this->addError($message);
        }
        return $this;
    }
//    private methode
    private function checkExist(string $itemKey=null){
        $item_to_check=$itemKey?$itemKey:$this->string_item;
        $regex="#[a-zA-Z0-9]#";
        $this->_errors=[];
        if (!isset($this->source_data[$item_to_check])) {
            $message = [
                "type"=> "any.unknow",
                "message" => "`{$item_to_check}` {$this->lang->unknow}",
                "label" => $item_to_check,
            ];
            $this->addError($message);
        }else if(!preg_match($regex,$this->source_data[$item_to_check]) || strlen(trim($this->source_data[$item_to_check]))==0){
            $message=[
                "type" => "date.unknow",
                "message" => "`{$item_to_check}` {$this->lang->string_unknow}",
                "label" => $item_to_check,
            ];
            $this->addError($message);
        }
        return true;
    }
    private function addError(array $value){
        return $this->_errors[]=$value;
    }
    function check(){
        return  $this->_errors;
    }
}