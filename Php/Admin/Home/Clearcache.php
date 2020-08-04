<?php
//error_reporting(E_ALL);
if (isset($ADMINKEY)) { }else{ exit('404');   }   include('../Php/Admin/cookie.php');


    function delDir($directory,$subdir=true)
    {
        $handle = opendir($directory);
        while (($file = readdir($handle)) !== false)
        {
            if ($file != "." && $file != "..")
            {
                is_dir("$directory/$file")?
                    delDir("$directory/$file"):
                    unlink("$directory/$file");
            }
        }
        if (readdir($handle) == false)
        {
            closedir($handle);
            rmdir($directory);
        }
    }

    delDir('../cache',true);

    mkdir(realpath('../').'/cache');

    echo '<script>alert("清除成功");window.history.back()</script>';

?>