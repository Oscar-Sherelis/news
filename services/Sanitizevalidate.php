<?php

class Sanitizevalidate
{
    public function cleanInput($input, $inputType)
    {
        $res = trim($input);

        if ($res === '') {
            return false;
        }

        $res = filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $res = htmlentities($res, ENT_QUOTES, 'UTF-8');

        if ($inputType === 'int' && is_int((int)$res)) {
            return (int)$res;
        }

        if ($inputType === 'string') {
            return $res;
        }

        return false;
    }
}
