<?php
$key = '1';
$value = 'TAK';
$z = explode("_", $key);
                
                    if ($z[0] != 'uwagi'){
                        echo $z[0].'<br />';
                        echo $key.'<br />';
                        echo $value.'<br />';
                    }
                    else {
                        echo $value.'<br />';
                    }



?>