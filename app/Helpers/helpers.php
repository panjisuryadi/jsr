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



if (!function_exists('statusProduk')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function statusProduk($required)
    {
        // status barang baru masuk
        $return_text = '';
        if ($required == 0) {

             $return_text = '<span class="rounded-lg bg-blue-400 p-1 uppercase items-center text-center text-white">Purchase</span>';

        }

        //status Barang Aktif
        elseif ($required == 1){

             $return_text = '<span class="rounded-lg bg-blue-400 p-1 uppercase items-center text-center text-white small">Aktif</span>';



        }
        //status belum di approve
        elseif ($required == 2){

             $return_text = '<span class="rounded-lg bg-yellow-400 p-1 uppercase items-center text-center text-white text-xs small">Need Approve</span>';



        }
        //status barang di Approve
        elseif ($required == 3){

             $return_text = '<span class="rounded-lg bg-green-400 p-1 uppercase items-center text-center text-white small">Approve</span>';

        }

        //status barang Rejected
        elseif ($required == 4){

             $return_text = '<span class="rounded-lg bg-red-500 p-1 uppercase items-center text-center text-white small">Rejected</span>';

        }
        return $return_text;
    }
}




if (!function_exists('pstatus')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function pStatus($required)
    {
        // status barang baru masuk
        $return_text = '';
        if ($required == 0) {
             $return_text = 'Purchase';
         }
        //status Barang Aktif
        elseif ($required == 1){
             $return_text = 'Aktif';
        }
        //status belum di approve
        elseif ($required == 2){
             $return_text = 'Need Approve';
        }
        //status barang di Approve
        elseif ($required == 3){
             $return_text = 'Approve';
        }

        //status barang Rejected
        elseif ($required == 4){
             $return_text = 'Rejected';
        }
        return $return_text;
    }
}


















 if (!function_exists('tgljam')) {
        function tgljam($value)
        {

        $date = '';
        $date = \Carbon\Carbon::parse($value);
        $tgl = $date->format('d/m/Y');
        $jam = $date->format('H:i');

         return $date = '<div class="text-center"><span class="text-dark">'. $tgl.'</span><span class="ml-1 text-warning">'. $jam.'</span></div>';

         }
      }


      if (!function_exists('tgl')) {
        function tgl($value)
        {

        $date = '';
        $date = \Carbon\Carbon::parse($value);
        $tgl = $date->isoFormat('dddd, LL');
        $jam = $date->format('H:i');

         return $date = ''. $tgl.' | '. $jam.'';

         }
      }





if (!function_exists('keBulan')) {
    function keBulan($number)
    {
        $search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        $replace_array = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
}

if (!function_exists('tanggal')) {
    date_default_timezone_set("Asia/Jakarta");
function tanggal($tgl, $tampil_hari=true){
   $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
   $nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

   $tahun = substr($tgl,0,4);
   $bulan = $nama_bulan[(int)substr($tgl,5,2)];
   $tanggal = substr($tgl,8,2);

   $text = "";

   if($tampil_hari){
      $urutan_hari = date('w', mktime(0,0,0, substr($tgl,5,2), $tanggal, $tahun));
      $hari = $nama_hari[$urutan_hari];
      $text .= $hari.", ";
   }

   $text .= $tanggal ." ". $bulan ." ". $tahun;

   return $text;
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
