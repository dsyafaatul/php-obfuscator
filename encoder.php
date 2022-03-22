<?php
ini_set('display_errors', 1);
function encode($in = './input/', $out= './output/', $word_list = [], $exclude = [], $prefix = "dsyafaatul"){
    $input = realpath($in).DIRECTORY_SEPARATOR;
    $output = realpath($out).DIRECTORY_SEPARATOR;

    $algos = hash_algos();
    if($path = realpath($in).DIRECTORY_SEPARATOR){
        foreach(scandir($path) as $key => $filename){
            if(in_array($filename, array_merge([".", ".."], $exclude))) continue;
            if(is_dir($path.$filename)) encode($path.$filename, $out, $word_list, $exclude);
            if(file_exists($path.$filename) && pathinfo($path.$filename, PATHINFO_EXTENSION) == 'php'){
                $file = file($path.$filename);
                $file_implode = implode('', $file);

                $continue = TRUE;
                while($continue){
                    $varname = $prefix.substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);
                    $funname = $prefix.substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);
                    $funname2 = $prefix.substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);
                    $angka1 = rand(10, 999);
                    $angka2 = rand(10, 999);
                    $angka3 = rand(10, 999);
                    $rand1 = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, rand(0, 7));

                    $word = count($word_list) < 1 ? '' : $word_list[rand(0, count($word_list) -1)];
                    $algo = $algos[rand(0, count($algos)-1)];
                    $key = count($word_list) < 1 ? '<?php ' : "<?php /* $word */ ";

                    $a = '$'.$varname.'=file(preg_replace("@\(.*\(.*$@","",__FILE__));
                    if(preg_replace("@\(.*\(.*$@","",__FILE__)==__FILE__ or
                    preg_replace("@\(.*\(.*$@","",__LINE__) != 3)die("ERROR");';
                    $a_ = "eval(base64_decode('".base64_encode($a)."'));";

                    $c = base64_encode('if(!function_exists("'.$funname2.'")){function '.$funname2.'($a,$b,$c){$d=implode($c);$d=preg_replace("/__halt_compiler.*/","",$d);if($b==hash("'.$algo.'","$d")){return(gzinflate(base64_decode($a)));}else{die();}}}');
                    $c_ = 'eval(base64_decode('.$funname.'($'.$varname.'[0],'.$angka2.')));';

                    $d_ = 'eval('.$funname2.'('.$funname.'($'.$varname.'[0],'.$angka3.'),'.$funname.'($'.$varname.'[0],'.$angka1.'),$'.$varname.'));__halt_compiler();';

                    $b = 'if(!function_exists("'.$funname.'")){function '.$funname.'($a,$b){$c=array('.(strlen($key)+strlen($a_)+strlen($c_)+strlen($d_)+strlen($rand1)).','.strlen($c).',32,266);if($b=='.$angka1.'){$d=substr($a,$c[0]+$c[1],$c[2]);}elseif($b=='.$angka2.'){$d=substr($a,$c[0],$c[1]);}elseif($b=='.$angka3.'){$d=trim(substr($a,$c[0]+$c[1]+$c[2]));}return$d;}}';
                    $b_ = "eval(base64_decode('".base64_encode($b)."'));";

                    $b = 'if(!function_exists("'.$funname.'")){function '.$funname.'($a,$b){$c=array('.(strlen($key)+strlen($a_)+strlen($b_)+strlen($c_)+strlen($d_)+strlen($rand1)).','.strlen($c).',32,266);if($b=='.$angka1.'){$d=substr($a,$c[0]+$c[1],$c[2]);}elseif($b=='.$angka2.'){$d=substr($a,$c[0],$c[1]);}elseif($b=='.$angka3.'){$d=trim(substr($a,$c[0]+$c[1]+$c[2]));}return$d;}}';
                    $b_ = "eval(base64_decode('".base64_encode($b)."'));";
                    
                    $hash = $hash1 = hash($algo, $key.$a_.$b_.$c_.preg_replace('/__halt_compiler.*/', '', $d_));

                    $b = 'if(!function_exists("'.$funname.'")){function '.$funname.'($a,$b){$c=array('.(strlen($key)+strlen($a_)+strlen($b_)+strlen($c_)+strlen($d_)+strlen($rand1)).','.strlen($c).','.strlen($hash).',266);if($b=='.$angka1.'){$d=substr($a,$c[0]+$c[1],$c[2]);}elseif($b=='.$angka2.'){$d=substr($a,$c[0],$c[1]);}elseif($b=='.$angka3.'){$d=trim(substr($a,$c[0]+$c[1]+$c[2]));}return$d;}}';
                    $b_ = "eval(base64_decode('".base64_encode($b)."'));";

                    $hash = $hash2 = hash($algo, $key.$a_.$b_.$c_.preg_replace('/__halt_compiler.*/', '', $d_));
                    $continue = $hash1 != $hash2;
                }

                $len_key = strlen($key);
                $len_a = strlen($a_);
                $len_b = strlen($b_);
                $len_c = strlen($c_);
                $len_d = strlen($d_);
                $len_rand1 = strlen($rand1);
                $len_hash = strlen($hash);
                
                $encoded = $key.$a_.$b_.$c_.$d_.$rand1.$c.$hash;

                if(!realpath($new = str_replace($input, $output, dirname($path.$filename).DIRECTORY_SEPARATOR))){
                    mkdir($new, 777, true);
                }

                if (preg_match('/__halt_compiler/', $file_implode)) continue;
                
                $encoded .= base64_encode(gzdeflate('?>'.$file_implode));
                $encoded_file = fopen($new.DIRECTORY_SEPARATOR.$filename, 'w');

                fwrite($encoded_file, $encoded);
                fclose($encoded_file);
                echo "<li style=\"color: green;\">$filename Successfully with $algo</li>";
            }
        }
    }
}
encode('./input/', './output/', ["Assalamualaikum", "Halo", "Punteun", "Bonjour", "Hola", "Euy", "Sampurasun"]);
