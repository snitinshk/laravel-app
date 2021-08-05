<?php

namespace App\Helper;

use App\Models\UserAccess;
use App\Models\Clients;
use App\Models\Plans;

class FormBuilder{

    public static function create_form($action, $form_content){
        $str_builder = "<div class='col-xs-6 ccf_form_container'>";
        $str_builder .= self::form_builder($action, $form_content);
        $str_builder .= "</div>";
        return $str_builder;
    }

    public static function form_builder($action, $form_content){
        $str_builder = "<form action='" . url('/') . "/" . $action . "' method='POST'>";
        $str_builder .= "<input type='hidden' name='_token' value='" . csrf_token() . "'>";

        foreach($form_content as $form_item){
            switch($form_item[0]){
                case "text":
                    $str_builder .= self::input_text($form_item[1],$form_item[2],$form_item[3],$form_item[4]);
                    break;
                case "select":
                    $str_builder .= self::input_select($form_item[1],$form_item[2],$form_item[3],$form_item[4],$form_item[5]);
                    break;
                case "hidden":
                    $str_builder .= "<input type='hidden' name='" . $form_item[2] . "' value='" . $form_item[4] . "'>";
                    break;
                case "text_disabled":
                    $str_builder .= self::disabled_input_text($form_item[1],$form_item[2],$form_item[3],$form_item[4]);
                    break;
                case "text_required":
                    $str_builder .= self::required_input_text($form_item[1],$form_item[2],$form_item[3],$form_item[4]);
                    break;
                case "submit":
                    $str_builder .= "<input type='submit' class='ccf_form_save_button' value='" . $form_item[1] . "'>";
                    break;
            }
        }
        $str_builder .= "</form>";
        return $str_builder;
    }

    public static function input_text($label, $name, $placeholder, $value){
        return "<p class='ccf_form_input_label'>" . $label . "</p>
                <input type='text' class='ccf_form_input_text' name='" . $name . "' placeholder='" . $placeholder . "' autocomplete='false' value=\"" . $value . "\"'>";
    }

    public static function disabled_input_text($label, $name, $placeholder, $value){
        return "<p class='ccf_form_input_label'>" . $label . "</p>
                <input type='text' class='ccf_form_input_text' disabled name='" . $name . "' placeholder='" . $placeholder . "' autocomplete='false' value=\"" . $value . "\"'>";
    }

    public static function required_input_text($label, $name, $placeholder, $value){
        return "<p class='ccf_form_input_label'>" . $label . "</p>
                <input type='text' class='ccf_form_input_text' required name='" . $name . "' placeholder='" . $placeholder . "' autocomplete='false' value=\"" . $value . "\"'>";
    }

    public static function input_select($label, $name, $db_table_name, $auto_select, $value){
        $str_builder = "<p class='ccf_form_input_label'>" . $label . "</p>
                <select class='ccf_form_input_text' name='" . $name . "'>";

        if($auto_select==true){
            $str_builder .= "<option value=''>Select an option</option>";
        }
        $str_builder .= self::getTableContent($db_table_name, $value);
        $str_builder .= "</select>";
        return $str_builder;
    }


    public static function getTableContent($table_name, $value){
        // Add more cases in here for other tables
        switch($table_name){
            case "user_accesses":
                $TableContent = UserAccess::all();
                break;
            case "clients":
                $TableContent = Clients::all();
                break;
            case "plans":
                $TableContent = Plans::all();
                break;



        }

        $str_builder = "";
        foreach($TableContent as $TableRow){
            if($TableRow->id == $value){
                $str_builder .= "<option selected value='" . $TableRow->id . "'>" . $TableRow->name . "</option>";
            }else{
                $str_builder .= "<option value='" . $TableRow->id . "'>" . $TableRow->name . "</option>";
            }
        }
        return $str_builder;
    }


}
