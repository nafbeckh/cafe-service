<?php

function tambah_nol_didepan($value, $threshold = null)
{
    return sprintf("%0" . $threshold . "s", $value);
}

function format_uang ($angka) {
    return number_format($angka, 0, ',', '.');
}

function timeAgo($time_ago)
{
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "baru saja";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "1 menit lalu";
        }
        else{
            return "$minutes menit lalu";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "1 jam lalu";
        }else{
            return "$hours jam lalu";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "kemarin";
        }else{
            return "$days hari lalu";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "minggu lalu";
        }else{
            return "$weeks minggu lalu";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "bulan lalu";
        }else{
            return "$months bulan lalu";
        }
    }
    //Years
    else{
        if($years==1){
            return "tahun lalu";
        }else{
            return "$years tahun lalu";
        }
    }
}