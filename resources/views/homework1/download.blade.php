<?php
$path=$course['path'];
$semester=Session::get('semester');
$year=Session::get('year');
$zip_file_name='';

if($course['type']=='1'){
$ex=explode('.',$path);
$the_folder =array('../public/uploads/'.$semester.'_'.$year.'/'.$course['course'].'/'.$course['sec'].$ex[0]);
$zip_file_name = $course['course'].$course['sec'].$ex[0].'.zip';

}
if($course['type']=='0'){
$the_folder =array('../public/uploads/'.$semester.'_'.$year.'/'.$course['course'].'/'.$course['sec']);
$zip_file_name = $course['course'].$course['sec'].'.zip';

}



class FlxZipArchive extends ZipArchive {


    public function addDir($location, $name) {
        $this->addEmptyDir($name);

        $this->addDirDo($location, $name);
     } // EO addDir;


    private function addDirDo($location, $name) {
        $name .= '/';
        $location .= '/';

        // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
            if ($file == '.' || $file == '..') continue;
            // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } // EO addDirDo();
}




$download_file= true;
//$delete_file_after_download= true; doesnt work!!
$za = new FlxZipArchive;
$res = $za->open($zip_file_name, ZipArchive::CREATE);
if($res === TRUE)
{
    foreach($the_folder as $path) {
    $za->addDir($path, basename($path));
    }
    $za->close();

}
else  { echo 'Could not create a zip archive';}

if ($download_file)
{
    ob_get_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=" . basename($zip_file_name) . ";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($zip_file_name));
    readfile($zip_file_name);
    unlink($zip_file_name);

}
?>