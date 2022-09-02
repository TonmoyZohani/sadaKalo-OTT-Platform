<?php
class FormSanitizer {

    public static function sanitizeFormString($inputText) {
        $inputText = strip_tags($inputText); // Built in PHP method that remove html tag
        $inputText = str_replace(" ", "", $inputText); // remove the space
        //$inputText = trim($inputText);
        $inputText = strtolower($inputText); // convert the text to lower
        $inputText = ucfirst($inputText); // capitalize the first character
        return $inputText;
    }

    public static function sanitizeFormUsername($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

}
?>