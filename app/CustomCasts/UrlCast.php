<?php


namespace App\CustomCasts;

use Vkovic\LaravelCustomCasts\CustomCastBase;

class UrlCast extends CustomCastBase
{
    public function setAttribute($field)
    {
        if(is_array($field)){
            return json_encode($field);
        }

        return $field;
    }

    public function castAttribute($field)
    {

        $array_field = json_decode($field);

        if (is_array($array_field) && !empty($array_field)) {
            $arr = [];
            foreach ($array_field as $k => $value) {
                $arr[] = get_uploaded_file_url($value);
            }
            return $arr;
        }
        return get_uploaded_file_url($field);
    }

}
