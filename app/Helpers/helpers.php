<?php

use Illuminate\Support\Str;


/*
 *
 * label_case
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('label_case')) {

    /**
     * Prepare the Column Name for Lables.
     */
    function label_case($text)
    {
        $order = ['_', '-'];
        $replace = ' ';

        $new_text = trim(\Illuminate\Support\Str::title(str_replace('"', '', $text)));
        $new_text = trim(\Illuminate\Support\Str::title(str_replace($order, $replace, $text)));
        $new_text = preg_replace('!\s+!', ' ', $new_text);

        return $new_text;
    }
}

if (!function_exists('imageUrl')) {
    function imageUrl()
    {
        $return_text = '';
        if (config('app.env') == 'production') {
            $return_text = 'storage/uploads/';
        }else{
            $return_text = 'storage/uploads/';
        }
        return $return_text;
    }
}




if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}


if (!function_exists('logo')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function logo()
    {
        $return_text = '';
        if (settings()->site_logo) {
            $return_text = asset("storage/logo/" .settings()->site_logo);
        }else{
            $return_text = asset('images/logo-white.png');
        }
        return $return_text;
    }
}
if (!function_exists('slogo')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function slogo()
    {
        $return_text = '';
        if (settings()->site_logo) {
            $return_text = asset("storage/logo/" .settings()->site_logo);
        }else{
            $return_text = asset('images/logo2.png');
        }
        return $return_text;
    }
}



if (!function_exists('date_today')) {

    function date_today()
    {
        $str = \Carbon\Carbon::now()->isoFormat('dddd, LL');

        return $str;
    }
}



if (!function_exists('uname')) {

    function uname($string) {
        return preg_replace('/(\S+) (\S{2}).*/', '$1$2', strtolower($string)) . random_int(0, 100);

    }
}


if (!function_exists('randomEmail')) {
    function randomEmail($string)
    {
      //$name = Str::random(8);
        $name = uname($string);
        $domain = ['gmail.com', 'yahoo.com', 'hotmail.com'];

        $randomDomain = $domain[array_rand($domain)];

        return $name . '@' . $randomDomain;
    }

}








if (!function_exists('uploadFile')) {

 function uploadFile($file, $path, $existingPath = '', $filename = '')
    {
        try {
            if ($existingPath != '' && file_exists($existingPath)) {
                unlink($existingPath);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($filename == '') {
            // generate filename with date original and extention
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
        }
        $file->move($path, $filename);
        $data = (object) [
            'path' => $path,
            'filename' => $filename,
            'extension' => $file->getClientOriginalExtension(),
            'url' => $path . '/' . $filename,
        ];
        return $data;
    }


}



if (!function_exists('settings')) {
    function settings() {
        $settings = cache()->remember('settings', 24*60, function () {
            return \Modules\Setting\Entities\Setting::firstOrFail();
        });

        return $settings;
    }
}




if (!function_exists('format_currency')) {
    function format_currency($value, $format = true) {
        if (!$format) {
            return $value;
        }

        $settings = settings();
        $position = $settings->default_currency_position;
        $symbol = $settings->currency->symbol;
        $decimal_separator = $settings->currency->decimal_separator;
        $thousand_separator = $settings->currency->thousand_separator;

        if ($position == 'prefix') {
            $formatted_value = $symbol . number_format((float) $value, 2, $decimal_separator, $thousand_separator);
        } else {
            $formatted_value = number_format((float) $value, 2, $decimal_separator, $thousand_separator) . $symbol;
        }

        return $formatted_value;
    }
}

if (!function_exists('make_reference_id')) {
    function make_reference_id($prefix, $number) {
        $padded_text = $prefix . '-' . str_pad($number, 5, 0, STR_PAD_LEFT);

        return $padded_text;
    }
}

if (!function_exists('array_merge_numeric_values')) {
    function array_merge_numeric_values() {
        $arrays = func_get_args();
        $merged = array();
        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (!is_numeric($value)) {
                    continue;
                }
                if (!isset($merged[$key])) {
                    $merged[$key] = $value;
                } else {
                    $merged[$key] += $value;
                }
            }
        }

        return $merged;
    }
}
