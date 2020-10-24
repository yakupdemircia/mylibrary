<?php

if (!function_exists('env_is_local')) {
    function env_is_local()
    {
        return getenv('APP_ENV', 'local') == "local";
    }
}

if (!function_exists('route_locale')) {
    function route_locale($name, $parameters = [], $absolute = true)
    {
        return app('url')->route(app()->getLocale().'.'.$name, $parameters, $absolute);
    }
}

if (!function_exists('current_url')) {

    function current_url($url, $withLocale = true)
    {
        if (Route::currentRouteName() == ($withLocale ? app()->getLocale().'.' : '').$url) {
            return 'active';
        } else {
            return '';
        }
    }
}

if (!function_exists('current_url_array')) {

    function current_url_array($urlArr = [], $withLocale = true)
    {
        $return = '';

        for ($i = 0; $i < count($urlArr); $i++) {

            if (Route::currentRouteName() == ($withLocale ? app()->getLocale().'.' : '').$urlArr[$i]) {
                $return = 'active';
            }
        }

        return $return;
    }
}

if (!function_exists('assets')) {
    function assets($file)
    {
        static $manifest = null;
        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('mix-manifest.json')), true);
        }

        if (isset($manifest[$file])) {
            return asset($manifest[$file]);
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}

if (!function_exists('date_locale')) {

    function date_locale($date = null)
    {
        if (is_null($date)) {
            return null;
        }

        return \Carbon\Carbon::parse($date)->format(trans('globals.date_format'));
    }
}

if (!function_exists('date_locale2')) {

    function date_locale2($date, $default = '', $defaultFormat = null, $locale = true)
    {
        if ($date) {
            $format = app()->getLocale() == 'tr' ? 'd/m/Y' : 'm/d/Y';
            if ($defaultFormat == 1) {
                $format = app()->getLocale() == 'tr' ? 'd F, H:i' : 'F d, h:i A';
            } elseif ($defaultFormat == 2) {
                $format = app()->getLocale() == 'tr' ? 'd M H:i' : 'M d h:i A';
            } elseif ($defaultFormat == 3) {
                $format = app()->getLocale() == 'tr' ? 'd F Y' : 'F d Y';
            } elseif ($defaultFormat == 4) {
                $format = app()->getLocale() == 'tr' ? 'd.m.Y' : 'm.d.Y';
            } elseif ($defaultFormat == 5) {
                $format = app()->getLocale() == 'tr' ? 'H:i' : 'h:i A';
            } elseif ($defaultFormat == 6) {
                $format = app()->getLocale() == 'tr' ? 'd F Y - H:i' : 'm d Y - H:i';
            } elseif ($defaultFormat == 7) {
                $format = 'd F Y l - H:i';
            } elseif ($defaultFormat == 8) {
                $format = 'Y-m-d- H:i:s';
            } else {
                if ($defaultFormat) {
                    $format = $defaultFormat;
                }
            }
            if (app()->getLocale() == 'en' && $locale) {
                $date = Date::parse($date)->format('Y-m-d H:i:s');
                $date = Date::createFromFormat('Y-m-d H:i:s', $date, config('app.timezone'));
                $date->setTimezone('US/Pacific');
                return $date->format($format);
            } else {
                return Date::parse($date)->format($format);
            }
        }

        return $default;
    }
}

if (!function_exists('get_model_by_name')) {
    function get_model_by_name($name)
    {
        $model = "\App\Models\\".ucfirst($name);

        return $model ?? null;
    }
}

if (!function_exists('pre')) {
    function pre($data = null)
    {
        return '<pre>'.print_r($data).'</pre>';
    }
}

if (!function_exists('debug_mode_is_on')) {
    function debug_mode_is_on()
    {
        return session()->has('debug_mode_on') || env('APP_DEBUG') == true;
    }
}

if (!function_exists('URL_exists')) {

    function URL_exists($url)
    {
        $headers = get_headers($url);
        return stripos($headers[0], "200 OK") ? true : false;
    }
}

if (!function_exists('get_uploaded_file_url')) {
    function get_uploaded_file_url($file_name = null)
    {
        if (is_null($file_name) || empty($file_name) || !is_string($file_name)) {
            return "";
        }

        $file_name = decast_url($file_name);

        $file = \Illuminate\Support\Facades\Storage::disk('local')->url($file_name);

        return $file;
    }
}

if (!function_exists('decast_url')) {
    function decast_url($file_name)
    {
        $file = str_replace(env('DO_SPACES_ENDPOINT_WITH_BUCKET'), '', $file_name);

        return $file;
    }
}

if (!function_exists('filter_path_url')) {
    function filter_path_url($url = "")
    {
        if (!empty($url) && is_string($url)) {

            $arr = parse_url($url);

            if (isset($arr['path'])) {
                $url = ltrim($arr['path'], '/');
            }
        }

        return $url;
    }
}

if (!function_exists('convert_search_word_by_word')) {
    function convert_search_word_by_word($text = "")
    {
        $pattern = '/[-+%\]\[{}\?_ ,.;\'!]/ui';
        $q = preg_replace($pattern, "", $text);
        $pattern = '@([a-zA-Z0-9\-_şıüöğçİŞĞÜÖÇ])@ui';
        $q = preg_replace($pattern, "$1.?", $q);

        $pattern = '@([iİıI])@ui';
        $q = preg_replace($pattern, "[iİıI]", $q);

        $pattern = '@([üÜ])@ui';
        $q = preg_replace($pattern, "[üÜ]", $q);

        $pattern = '@([öÖ])@ui';
        $q = preg_replace($pattern, "[öÖ]", $q);

        $pattern = '@([çÇ])@ui';
        $q = preg_replace($pattern, "[çÇ]", $q);

        $pattern = '@([ğĞ])@ui';
        $q = preg_replace($pattern, "[ğĞ]", $q);

        $pattern = '@([şŞ])@ui';
        $q = preg_replace($pattern, "[şŞ]", $q);

        return $q;
    }
}

if (!function_exists('calc_issue_status')) {
    function calc_issue_status(\App\Models\Issue $issue)
    {
        $status = 'waiting';

        if (!$issue->return_date) {
            if (strtotime(date('Y-m-d')) > strtotime($issue->end_date)) {
                $status = 'delayed';
            }
        } else {
            $status = 'returned';

            if (strtotime($issue->return_date) > strtotime($issue->end_date)) {
                $status = 'returned / delay';
            }

        }

        return $status;
    }
}
