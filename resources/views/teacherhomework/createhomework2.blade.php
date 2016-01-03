<?php

error_reporting(E_ERROR);

/**
 *      Bootstrap Listr
 *
 *       Author:    Jan T. Sott
 *         Info:    http://github.com/idleberg/Bootstrap-Listr
 *      License:    The MIT License (MIT)
 *
 *      Credits:    Greg Johnson - PHPDL lite (http://greg-j.com/phpdl/)
 *                  Na Wong - Listr (http://nadesign.net/listr/)
 *                  Joe McCullough - Stupid Table Plugin (http://joequery.github.io/Stupid-Table-Plugin/)
 */

// require_once('listr-config.php');
$file    = app_path().'/includes/listr/config.json';
$options = json_decode(file_get_contents($file), true);

if($options['general']['locale'] != null ) {
    require_once( app_path() . '/includes/listr/listr-l10n.php');
}

require_once(app_path() . '/includes/listr/listr-functions.php');

// Configure optional table columns
$table_options = $options['columns'];

// Set sorting properties.
$sort = array(
    array('key'=>'lname', 'sort'=>'asc'), // ... this sets the initial sort "column" and order ...
    array('key'=>'size',  'sort'=>'asc') // ... for items with the same initial sort value, sort this way.
    );

// Files you want to hide from the listing
$ignore_list = $options['ignored_files'];

// Get this folder and files name.
$this_script    = basename(__FILE__);

$this_folder    = (isset($_GET['path'])) ? $_GET['path'] : "";
$this_folder    = str_replace('..', '', $this_folder);
$this_folder    = str_replace($this_script, '', $this_folder);
$this_folder    = str_replace('index.php', '', $this_folder);
$this_folder    = str_replace('//', '/', $this_folder);

if($this_folder!="" || $this_folder!=null)
{
    $navigation_dir = $options['general']['root_dir'] . "/" . $this_folder;
} else{
    $navigation_dir = $options['general']['root_dir'];
}
$root_dir       = dirname($_SERVER['PHP_SELF']);

$absolute_path  = str_replace(str_replace("%2F", "/", rawurlencode($this_folder)), '', $_SERVER['REQUEST_URI']);
$dir_name       = explode("/", $this_folder);

// Declare vars used beyond this point.
$file_list = array();
$folder_list = array();
$total_size = 0;

if ($options['bootstrap']['icons'] == "glyphicons") {
    $icons['tag'] = 'span';
    $icons['home'] = "<span class=\"glyphicon glyphicon-home\"></span>";
    if ($options['general']['enable_search'] == true) {
        $icons['search'] = "          <span class=\"glyphicon glyphicon-search form-control-feedback\"></span>" . PHP_EOL;
    }
} else if (($options['bootstrap']['icons'] == "fontawesome") || ($options['bootstrap']['icons'] == 'fa-files')) {
    $icons['tag']   = 'i';
    $icons['home']  = "<i class=\"fa fa-home fa-lg fa-fw\"></i> ";
    if ($options['general']['share_icons'] == true) {
        $icons_dropbox  = "<i class=\"fa fa-dropbox fa-fw\"></i> ";
        $icons_email    = "<i class=\"fa fa-envelope fa-fw\"></i> ";
        $icons_facebook = "<i class=\"fa fa-facebook fa-fw\"></i> ";
        $icons_gplus    = "<i class=\"fa fa-google-plus fa-fw\"></i> ";
        $icons_twitter  = "<i class=\"fa fa-twitter fa-fw\"></i> ";
    }
    if ($options['general']['enable_search'] == true) {
        $icons['search'] = "          <i class=\"fa fa-search form-control-feedback\"></i>" . PHP_EOL;
    }

    if ($options['bootstrap']['icons'] == "fontawesome") {
        $filetype = array(
            'archive'   => array('7z','ace','adf','air','apk','arj','bz2','bzip','cab','d64','dmg','git','hdf','ipf','iso','fdi','gz','jar','lha','lzh','lz','lzma','pak','phar','pkg','pimp','rar','safariextz','sfx','sit','sitx','sqx','sublime-package','swm','tar','tgz','wim','wsz','xar','zip'),
            'apple'     => array('app','ipa','ipsw','saver'),
            'audio'     => array('aac','ac3','aif','aiff','au','caf','flac','it','m4a','m4p','med','mid','mo3','mod','mp1','mp2','mp3','mpc','ned','ra','ram','oga','ogg','oma','opus','s3m','sid','umx','wav','webma','wv','xm'),
            'calendar'  => array('icbu','ics'),
            'config'    => array('cfg','conf','ini','htaccess','htpasswd','plist','sublime-settings','xpy'),
            'contact'   => array('abbu','contact','oab','pab','vcard','vcf'),
            'database'  => array('bde','crp','db','db2','db3','dbb','dbf','dbk','dbs','dbx','edb','fdb','frm','fw','fw2','fw3','gdb','itdb','mdb','ndb','nsf','rdb','sas7mdb','sql','sqlite','tdb','wdb'),
            'doc'       => array('abw','doc','docm','docs','docx','dot','key','numbers','odb','odf','odg','odp','odt','ods','otg','otp','ots','ott','pages','pdf','pot','ppt','pptx','sdb','sdc','sdd','sdw','sxi','wp','wp4','wp5','wp6','wp7','wpd','xls','xlsx','xps'),
            'downloads' => array('!bt','!qb','!ut','crdownload','download','opdownload','part'),
            'ebook'     => array('aeh','azw','ceb','chm','epub','fb2','ibooks','kf8','lit','lrf','lrx','mobi','pdb','pdg','prc','xeb'),
            'email'     => array('eml','emlx','mbox','msg','pst'),
            'feed'      => array('atom','rss'),
            'flash'     => array('fla','flv','swf'),
            'font'      => array('eot','fon','otf','pfm','ttf','woff'),
            'image'     => array('ai','bmp','cdr','emf','eps','gif','icns','ico','jp2','jpe','jpeg','jpg','jpx','pcx','pict','png','psd','psp','svg','tga','tif','tiff','webp','wmf'),
            'link'      => array('lnk','url','webloc'),
            'linux'     => array('bin','deb','rpm'),
            'palette'   => array('ase','clm','clr','gpl'),
            'raw'       => array('3fr','ari','arw','bay','cap','cr2','crw','dcs','dcr','dnf','dng','eip','erf','fff','iiq','k25','kdc','mdc','mef','mof','mrw','nef','nrw','obm','orf','pef','ptx','pxn','r3d','raf','raw','rwl','rw2','rwz','sr2','srf','srw','x3f'),
            'script'    => array('ahk','as','asp','aspx','bat','c','cfm','clj','cmd','cpp','css','el','erb','g','hml','java','js','json','jsp','less','nsh','nsi','php','php3','pl','py','rb','rhtml','sass','scala','scm','scpt','scptd','scss','sh','shtml','wsh','xml','yml'),
            'text'      => array('ans','asc','ascii','csv','diz','latex','log','markdown','md','nfo','rst','rtf','tex','text','txt'),
            'video'     => array('3g2','3gp','3gp2','3gpp','asf','avi','bik','bup','divx','ifo','m4v','mkv','mkv','mov','mp4','mpeg','mpg','rm','rv','ogv','qt','smk','vob','webm','wmv','xvid'),
            'website'   => array('htm','html','mhtml','mht','xht','xhtml'),
            'windows'   => array('dll','exe','msi','pif','ps1','scr','sys')
            );
if ($options['general']['virtual_files'] == true) {
    $filetype['flickr']     = array('flickr');
    $filetype['soundcloud'] = array('soundcloud');
    $filetype['vimeo']      = array('vimeo');
    $filetype['youtube']    = array('youtube');
}
} else if ($options['bootstrap']['icons'] == 'fa-files') {
    $filetype = array(
        'archive'    => array('7z','ace','adf','air','apk','arj','bz2','bzip','cab','d64','dmg','git','hdf','ipf','iso','fdi','gz','jar','lha','lzh','lz','lzma','pak','phar','pkg','pimp','rar','safariextz','sfx','sit','sitx','sqx','sublime-package','swm','tar','tgz','wim','wsz','xar','zip'),
        'audio'      => array('aac','ac3','aif','aiff','au','caf','flac','it','m4a','m4p','med','mid','mo3','mod','mp1','mp2','mp3','mpc','ned','ra','ram','oga','ogg','oma','s3m','sid','umx','wav','webma','wv','xm'),
        'excel'      => array('xls','xlsx','numbers'),
        'image'      => array('ai','bmp','cdr','emf','eps','gif','icns','ico','jp2','jpe','jpeg','jpg','jpx','pcx','pict','png','psd','psp','svg','tga','tif','tiff','webp','wmf'),
        'pdf'        => array('pdf'),
        'powerpoint' => array('pot','ppt','pptx','key'),
        'script'     => array('ahk','as','asp','aspx','bat','c','cfm','clj','cmd','cpp','css','el','erb','g','hml','java','js','json','jsp','less','nsh','nsi','php','php3','pl','py','rb','rhtml','sass','scala','scm','scpt','scptd','scss','sh','shtml','wsh','xml','yml'),
        'text'       => array('ans','asc','ascii','csv','diz','latex','log','markdown','md','nfo','rst','rtf','tex','text','txt'),
        'video'      => array('3g2','3gp','3gp2','3gpp','asf','avi','bik','bup','divx','flv','ifo','m4v','mkv','mkv','mov','mp4','mpeg','mpg','rm','rv','ogv','qt','smk','swf','vob','webm','wmv','xvid'),
        'word'       => array('doc','docm','docs','docx','dot','pages'),
        );
}
} else {
    $icons['tag']  = 'span';
    $icons['home'] = $this_domain;
    $icons['search'] = null;
}

if ($options['general']['enable_viewer']) {
    $audio_files     = explode(',', $options['viewer']['audio']);
    $image_files     = explode(',', $options['viewer']['image']);
    $pdf_files       = explode(',', $options['viewer']['pdf']);
    $quicktime_files = explode(',', $options['viewer']['quicktime']);
    $source_files    = explode(',', $options['viewer']['source']);
    $text_files      = explode(',', $options['viewer']['text']);
    $video_files     = explode(',', $options['viewer']['video']);
    $website_files   = explode(',', $options['viewer']['website']);
    if ($options['general']['virtual_files'] == true) {
        $virtual_files     = explode(',', $options['viewer']['virtual']);
    }
}

if ($options['general']['text_direction'] == 'rtl') {
    $direction     = " dir=\"rtl\"";
    $right         = "left";
    $left          = "right";
    $search_offset = null;
} else {
    $direction     = " dir=\"ltr\"";
    $right         = "right";
    $left          = "left";
    $search_offset = " col-xs-offset-6 col-sm-offset-9";
}

$bootstrap_cdn = set_bootstrap_theme();

// Set Bootstrap defaults
if (isset($options['bootstrap']['modal_size'])) {
    $modal_size = $options['bootstrap']['modal_size'];
} else {
    $modal_size = 'modal-lg';
}

if (isset($options['bootstrap']['button_default'])) {
    $btn_default = $options['bootstrap']['button_default'];
} else {
    $btn_default = 'btn-default';
}

if (isset($options['bootstrap']['button_primary'])) {
    $btn_primary = $options['bootstrap']['button_primary'];
} else {
    $btn_primary = 'btn-primary';
}

if (isset($options['bootstrap']['button_highlight'])) {
    $btn_highlight = $options['bootstrap']['button_highlight'];
} else {
    $btn_highlight = 'btn-link';
}

if (isset($options['bootstrap']['column_name'])) {
    $column_name = $options['bootstrap']['column_name'];
} else {
    $column_name = 'col-lg-8';
}

if (isset($options['bootstrap']['column_size'])) {
    $column_size = $options['bootstrap']['column_size'];
} else {
    $column_size = 'col-lg-2';
}

if (isset($options['bootstrap']['column_age'])) {
    $column_age = $options['bootstrap']['column_age'];
} else {
    $column_age = 'col-lg-2';
}

if ($options['bootstrap']['breadcrumb_style'] != "") {
    $breadcrumb_style = " ".$options['bootstrap']['breadcrumb_style'];
} else {
    $breadcrumb_style = null;
}

if ($options['bootstrap']['fluid_grid'] == true) {
    $container = "container-fluid";
} else {
    $container = "container";
}

// Set responsiveness
if ($options['bootstrap']['responsive_table']) {
    $responsive_open = "    <div class=\"table-responsive\">" . PHP_EOL;
    $responsive_close = "    </div>" . PHP_EOL;
}

// Count optional columns
$table_count = 0;
foreach($table_options as $value)
{
  if($value === true)
    $table_count++;
}

//Nong query homework_assignment to get homework template
$folder_path = explode( "/", $navigation_dir);

//find folder structure
$folder_list_query = DB::table('homework_folder')->where('course_id', $course_id)->get();
$course_folder_obj = json_decode(json_encode($folder_list_query), FALSE);
foreach($course_folder_obj as $obj){
    $a_folder['name']           = $obj->name;
    $a_folder['lname']          = strtolower($a_folder['name'] );
    $a_folder['bname']          = $obj->name;
    $a_folder['lbname']         = strtolower($a_folder['bname'] );
    $a_folder['ext']            = $obj->type;
    $a_folder['lext']           = strtolower($a_folder['ext']);
    $folder_icon                = 'glyphicon glyphicon-folder-close';
    $a_folder['class']          = "glyphicon glyphicon-file";
    $a_folder['bytes']          = 0;
    $a_folder['size']['num']    = 0;
    $a_folder['size']['str']    = "KB";
    $a_folder['mtime']          = 0;
    $a_folder['iso_mtime']      = "";

    if($obj->path===$navigation_dir){
        array_push($folder_list, $a_folder);
    }
}

//$result = DB::table('homework')->where('course_id', $course_id)->get();
$result = DB::select("SELECT * FROM homework WHERE course_id = ?",[$course_id]);
$object1 = json_decode(json_encode($result), FALSE);
foreach($object1 as $obj){
    $item['name']           = $obj->name;
    $item['lname']          = strtolower($item['name'] );
    $item['bname']          = $obj->name . " (" .  $obj->type_id . ")";
    $item['lbname']         = strtolower($item['bname'] );
    $item['ext']            = $obj->type_id;
    $item['lext']           = strtolower($item['ext']);
    $item['class']          = "glyphicon glyphicon-file";
    $item['bytes']          = 0;
    $item['size']['num']    = 0;
    $item['size']['str']    = "KB";
    $item['mtime']          = 0;
    $item['iso_mtime']      = "";

    // add file to file list
    if($obj->path===$navigation_dir){
        array_push($file_list, $item);
    }
}

// Sort folder list.
if($folder_list)
    $folder_list = php_multisort($folder_list, $sort);
// Sort file list.
if($file_list)
    $file_list = php_multisort($file_list, $sort);
// Calculate the total folder size (fix: total size cannot display while there is no folder inside the directory)
if($file_list && $folder_list || $file_list)
    $total_size = bytes_to_string($total_size, 2);

$total_folders = count($folder_list);
$total_files = count($file_list);

// Localized summary, hopefully not overly complicated
if ( ($total_folders == 1) && ($total_files == 0) ) {
    $summary = sprintf(_('%1$s folder'), $total_folders);
} else if ( ($total_folders > 1) && ($total_files == 0) ) {
    $summary = sprintf(_('%1$s folders'), $total_folders);
} else if ( ($total_folders == 0) && ($total_files == 1) ) {
    $summary = sprintf(_('%1$s file, %2$s %3$s in total'), $total_files, $total_size['num'], $total_size['str']);
} else if ( ($total_folders == 0) && ($total_files > 1) ) {
    $summary = sprintf(_('%1$s files, %2$s %3$s in total'), $total_files, $total_size['num'], $total_size['str']);
} else if ( ($total_folders == 1) && ($total_files == 1) ) {
    $summary = sprintf(_('%1$s folder and %2$s file, %3$s %4$s in total'), $total_folders, $total_files, $total_size['num'], $total_size['str']);
} else if ( ($total_folders == 1) && ($total_files >1) ) {
    $summary = sprintf(_('%1$s folder and %2$s files, %3$s %4$s in total'), $total_folders, $total_files, $total_size['num'], $total_size['str']);
} else if ( ($total_folders > 1) && ($total_files == 1) ) {
    $summary = sprintf(_('%1$s folders and %2$s file, %3$s %4$s in total'), $total_folders, $total_files, $total_size['num'], $total_size['str']);
} else if ( ($total_folders > 1) && ($total_files > 1) ) {
    $summary = sprintf(_('%1$s folders and %2$s files, %3$s %4$s in total'), $total_folders, $total_files, $total_size['num'], $total_size['str']);
}

// Merge local settings with global settings
if(isset($loptions)) {
    $options = array_merge($options, $loptions);
}

$header = set_header($bootstrap_cdn);
$footer = set_footer();

// Set breadcrumbs
$breadcrumbs  = "    <ol class=\"breadcrumb$breadcrumb_style\"".$direction.">" . PHP_EOL;
$breadcrumbs .= "      <li><a href=\"".htmlentities($root_dir, ENT_QUOTES, 'utf-8')."/homework/create/" . $course_id . "\">".$icons['home']."</a></li>" . PHP_EOL;
foreach($dir_name as $dir => $name) :
    if(($name != ' ') && ($name != '') && ($name != '.') && ($name != '/')):
        $parent = '';
    for ($i = 0; $i <= $dir; $i++):
        $parent .= rawurlencode($dir_name[$i]) . '/';
    endfor;
    $mypath = $absolute_path.$parent;
    $breadcrumbs .= "      <li><a href=\"".htmlentities(substr($absolute_path.$parent,0,strlen($mypath)-1) , ENT_QUOTES, 'utf-8')."\">".$name."</a></li>" . PHP_EOL;
    endif;
    endforeach;
    $breadcrumbs = $breadcrumbs."    </ol>" . PHP_EOL;

// Show search
    if ($options['general']['enable_search'] == true) {

        $autofocus = null;
        if ($options['general']['autofocus_search'] == true) {
            $autofocus = " autofocus";
        }

        if ($options['bootstrap']['input_size'] != "") {
            $input_size = " ".$options['bootstrap']['input_size'];
        } else {
            $input_size = null;
        }

        $search  = "    <div class=\"row\">" . PHP_EOL;
        $search .= "      <div class=\"col-xs-6 col-sm-3$search_offset\">" . PHP_EOL;
        $search .= "        <div class=\"form-group has-feedback\">" . PHP_EOL;
        $search .= "          <label class=\"control-label sr-only\" for=\"search\">". _('Search')."</label>" . PHP_EOL;
        $search .= "          <input type=\"text\" class=\"form-control$input_size\" id=\"search\" placeholder=\"". _('Search')."\"$autofocus>" . PHP_EOL;
        $search .= $icons['search'];
        $search .= "       </div>" . PHP_EOL;
        $search .= "      </div>" . PHP_EOL;
        $search .= "    </div>" . PHP_EOL;
    }

// Show add
    if ($options['general']['enable_add'] == true) {

        $add_tag  = "    <div class=\"row\" style=\"margin-bottom: 15px;\">" . PHP_EOL;
        $add_tag .= "      <div class=\"col-xs-6 col-sm-3  col-xs-offset-6 col-sm-offset-9\">" . PHP_EOL;
        $add_tag .= "        <button type=\"button\" class=\"btn btn-default\" id=\"file_add_btn\">";
        //$add_tag .= "           <span class=\"glyphicon glyphicon glyphicon-file\"></span>";
        $add_tag .= "           <span class=\"extraicon-file-add\"></span>";
        $add_tag .= "        </button>";
        $add_tag .= "        <button type=\"button\" class=\"btn btn-default\" id=\"folder_add_btn\">";
        //$add_tag .= "           <span class=\"glyphicon glyphicon glyphicon-folder-open\"></span>";
        $add_tag .= "           <span class=\"extraicon-folder-add\"></span>";
        $add_tag .= "        </button>";
        $add_tag .= "      </div>" . PHP_EOL;
        $add_tag .= "    </div>" . PHP_EOL;
    }

// Set table header
    $table_header = null;
    $table_header .= "            <th class=\"".$column_name." text-".$left."\" data-sort=\"string\">"._('Name')."</th>" . PHP_EOL;

    if ($table_options['size']) {
        $table_header .= "            <th";
        if ($options['general']['enable_sort']) {
            $table_header .= " class=\"".$column_size." text-".$right."\" data-sort=\"int\">";
        } else {
            $table_header .= ">";
        }
        $table_header .= _('Size')."</th>" . PHP_EOL;
    }

    if ($table_options['age']) {
        $table_header .= "            <th";
        if ($options['general']['enable_sort']) {
            $table_header .= " class=\"".$column_age." text-".$right."\" data-sort=\"int\">";
        } else {
            $table_header .= ">";
        }
        $table_header .= _('Modified')."</th>" . PHP_EOL;
    }

// Set table body
    $table_body = null;
    if(($folder_list) || ($file_list) ) {

        if($folder_list):
            foreach($folder_list as $item) :

                if ($options['bootstrap']['tablerow_folders'] != null) {
                    $tr_folders = ' class="'.$options['bootstrap']['tablerow_folders'].'"';
                } else {
                    $tr_folders = null;
                }

            // var_dump($options['bootstrap']['tablerow_folders']);

                $table_body .= "          <tr$tr_folders>" . PHP_EOL;
                $table_body .= "            <td";
                if ($options['general']['enable_sort']) {
                    $table_body .= " class=\"text-".$left."\" data-sort-value=\"". htmlentities(utf8_encode($item['lbname']), ENT_QUOTES, 'utf-8') . "\"" ;
                }
                $table_body .= ">";
                if ($options['bootstrap']['icons'] == "glyphicons" || $options['bootstrap']['icons'] == "fontawesome" || $options['bootstrap']['icons'] == "fa-files" ) {
                    $table_body .= "<".$icons['tag']." class=\"$folder_icon\"></".$icons['tag'].">&nbsp;";
                }

                if ($options['bootstrap']['tablerow_links'] != null) {
                    $tr_links = ' class="'.$options['bootstrap']['tablerow_links'].'"';
                } else {
                    $tr_links = null;
                }

                if($_GET['path'] == null){
                    $table_body .= "<a href=\"" . $course_id . '/' .htmlentities(rawurlencode($item['bname']), ENT_QUOTES, 'utf-8')  ."\" $tr_links><strong>" . utf8ify($item['bname']) . "</strong></a></td>" . PHP_EOL;
                }else{
                    $table_body .= "<a href=\"" . $_GET['path'] . '/' .htmlentities(rawurlencode($item['bname']), ENT_QUOTES, 'utf-8')  ."\" $tr_links><strong>" . utf8ify($item['bname']) . "</strong></a></td>" . PHP_EOL;
                }
            //$table_body .= "<a href=\"" . 'testfolder' . "/\" $tr_links><strong>" . utf8ify($item['bname']) . "</strong></a></td>" . PHP_EOL;

                if ($table_options['size']) {
                    $table_body .= "            <td";
                    if ($options['general']['enable_sort']) {
                        $table_body .= " class=\"text-".$right."\" data-sort-value=\"0\"";
                    }
                    $table_body .= ">&mdash;</td>" . PHP_EOL;
                }

                if ($table_options['age']) {
                    $table_body .= "            <td";
                    if ($options['general']['enable_sort']) {
                        $table_body .= " class=\"text-".$right."\" data-sort-value=\"" . $item['mtime'] . "\"";
                        $table_body .= " title=\"" . $item['iso_mtime'] . "\"";
                    }
                    $table_body .= ">" . time_ago($item['mtime']) . "</td>" . PHP_EOL;
                }

                $table_body .= "          </tr>" . PHP_EOL;

                endforeach;
                endif;

                if($file_list):
                    foreach($file_list as $item) :

                        $row_classes  = array();
                    $file_classes = array();
                    $file_meta = array();

                    $item_pretty_size = $item['size']['num'] . " " . $item['size']['str'];

            // Style table rows
                    if ($options['bootstrap']['tablerow_files'] != "") {
                        $row_classes[] = $options['bootstrap']['tablerow_files'];
                    }

            // Is file hidden?
                    if (in_array($item['bname'], $options['hidden_files'])) {
                        $row_classes[] = "hidden";
                // muted class on row…
                        $row_classes[] = $options['bootstrap']['hidden_files_row'];
                // …and again for the link
                        $file_classes[] = $options['bootstrap']['hidden_files_link'];
                    }

            // Is virtual file?
                    if ( ($options['general']['virtual_files'] == true) && (in_array($item['lext'], $virtual_files)) ){

                        if ( is_int($options['general']['virtual_maxsize']) == true) {
                            $virtual_maxsize = $options['general']['virtual_maxsize'];
                        } else {
                            $virtual_maxsize = 256;
                        }
                        if  (filesize($navigation_dir.$item['bname']) <= $virtual_maxsize) {

                            $virtual_file =  json_decode(file_get_contents($navigation_dir.$item['bname'], true), true);

                            if ($item['lext'] == 'flickr') {
                                $virtual_attr =  ' data-flickr="'.htmlentities($virtual_file['user']).'/'.htmlentities($virtual_file['id']).'"';
                                if ( $virtual_file['album'] != null) {
                                    $album = '/in/album-'.htmlentities($virtual_file['album']);
                                } else {
                                    $album = null;
                                }
                                $virtual_attr .= ' data-url="https://www.flickr.com/'.htmlentities($virtual_file['user']).'/'.htmlentities($virtual_file['id']).$album.'"';
                                $virtual_attr .= ' data-name="'.htmlentities($virtual_file['name']).'"';
                            } else if ($item['lext'] == 'soundcloud') {
                                $virtual_attr =  ' data-soundcloud="'.htmlentities($virtual_file['type']).'/'.htmlentities($virtual_file['id']).'"';
                                $virtual_attr .= ' data-url="'.htmlentities($virtual_file['url']).'"';
                                $virtual_attr .= ' data-name="'.htmlentities($virtual_file['name']).'"';
                            } else if ($item['lext'] == 'vimeo') {
                                $virtual_attr =  ' data-vimeo="'.htmlentities($virtual_file['id']).'"';
                                $virtual_attr .= ' data-url="https://vimeo.com/'.htmlentities($virtual_file['id']).'"';
                                $virtual_attr .= ' data-name="'.htmlentities($virtual_file['name']).'"';
                            } else if ($item['lext'] == 'youtube') {
                                $virtual_attr =  ' data-youtube="'.htmlentities($virtual_file['id']).'"';
                                $virtual_attr .= ' data-url="https://youtube.com/watch?v='.htmlentities($virtual_file['id']).'"';
                                $virtual_attr .= ' data-name="'.htmlentities($virtual_file['name']).'"';
                            }
                        } else {
                            $virtual_attr = null;
                        }

                // Don't show file-size in .virtual-file
                        $modified_attr = null;
                    } else {
                        $virtual_attr = null;
                        $modified_attr = " data-modified=\"".$item_pretty_size."\"";
                    }

            // Concatenate tr-classes
                    if (!empty($row_classes)) {
                        $row_attr = ' class="'.implode(" ", $row_classes).'"';
                    } else {
                        $row_attr = null;
                    }

                    $table_body .= "          <tr$row_attr>" . PHP_EOL;
                    $table_body .= "            <td";
                    if ($options['general']['enable_sort']) {
                        $table_body .= " class=\"text-".$left."\" data-sort-value=\"". htmlentities(utf8_encode($item['lbname']), ENT_QUOTES, 'utf-8') . "\"" ;
                    }
                    $table_body .= ">";
                    if ($options['bootstrap']['icons'] == "glyphicons" || $options['bootstrap']['icons'] == "fontawesome" || $options['bootstrap']['icons'] == "fa-files") {
                        $table_body .= "<".$icons['tag']." class=\"" . $item['class'] . "\"></".$icons['tag'].">&nbsp;";
                    }
                    if ($options['general']['hide_extension']) {
                        $display_name = $item['name'];
                    } else {
                        $display_name = $item['bname'];
                    }

            // inject modal class if necessary
                    if ($options['general']['enable_viewer']) {
                        if (in_array($item['lext'], $audio_files)) {
                            $file_classes[] = 'audio-modal';
                        } else if ($item['lext'] == 'swf') {
                            $file_classes[] = 'flash-modal';
                        } else if (in_array($item['lext'], $image_files)) {
                            $file_classes[] = 'image-modal';
                        } else if (in_array($item['lext'], $pdf_files)) {
                            $file_classes[] = 'pdf-modal';
                        } else if (in_array($item['lext'], $quicktime_files)) {
                           $file_classes[] = 'quicktime-modal';
                       } else if (in_array($item['lext'], $source_files)) {
                        if ($options['general']['auto_highlight']) {
                            $file_meta[] = 'data-highlight="true"';
                        }
                        if ($options['viewer']['alt_load'] == true) {
                            $file_classes[] = 'source-modal-alt';
                        } else {
                            $file_classes[] = 'source-modal';
                        }
                    } else if (in_array($item['lext'], $text_files)) {
                        if ($options['viewer']['alt_load'] == true) {
                            $file_classes[] = 'text-modal-alt';
                        } else {
                            $file_classes[] = 'text-modal';
                        }
                    } else if (in_array($item['lext'], $video_files)) {
                        $file_classes[] = 'video-modal';
                    } else if (in_array($item['lext'], $website_files)) {
                        $file_classes[] = 'website-modal';
                    } else if (in_array($item['lext'], $virtual_files)) {
                        $file_classes[] = 'virtual-modal';
                    }
                }

                $file_data = ' '.implode(" ", $file_meta);

                if ($file_classes != null) {
                    $file_attr = ' class="'.implode(" ", $file_classes).'"';
                } else {
                    $file_attr = null;
                }

            //$table_body .= "<a href=\"" . htmlentities(rawurlencode($item['bname']), ENT_QUOTES, 'utf-8') . "\"$file_attr$file_data$virtual_attr$modified_attr>" . utf8ify($display_name) . "</a></td>" . PHP_EOL;
                $table_body .= "<a href=\"" . '#' . "\"$file_attr$file_data$virtual_attr$modified_attr>" . utf8ify($display_name) . "</a></td>" . PHP_EOL;

            // Size
                if ($table_options['size']) {
                    $table_body .= "            <td";
                    if ($options['general']['enable_sort']) {
                        $table_body .= " class=\"text-".$right."\" data-sort-value=\"" . $item['bytes'] . "\"";
                        $table_body .= " title=\"" . $item['bytes'] . " " ._('bytes')."\"";
                    }
                    $table_body .= ">" . $item_pretty_size . "</td>" . PHP_EOL;
                }

            // Modified
                if ($table_options['age']) {
                    $table_body .= "            <td";
                    if ($options['general']['enable_sort']) {
                        $table_body .= " class=\"text-".$right."\" data-sort-value=\"".$item['mtime']."\"";
                        $table_body .= " title=\"" . $item['iso_mtime'] . "\"";
                    }
                    $table_body .= ">" . time_ago($item['mtime']) . "</td>" . PHP_EOL;
                }

                $table_body .= "          </tr>" . PHP_EOL;
                endforeach;
                endif;
            } else {
                $colspan = $table_count + 1;
                $table_body .= "          <tr>" . PHP_EOL;
                $table_body .= "            <td colspan=\"$colspan\" style=\"font-style:italic\">";
                if ($options['bootstrap']['icons'] == "glyphicons" || $options['bootstrap']['icons'] == "fontawesome" || $options['bootstrap']['icons'] == "fa-files" ) {
                    $table_body .= "<".$icons['tag']." class=\"" . $item['class'] . "\">&nbsp;</".$icons['tag'].">";
                }
                $table_body .= _("empty folder")."</td>" . PHP_EOL;
                $table_body .= "          </tr>" . PHP_EOL;
            }

            ?>
            @extends('app')

            @section('css')
            <meta name="generator" content="Bootstrap Listr" />

            {{--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />--}}
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="{{ asset('/css/listr.min.css') }}" />
            <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
            <link rel="stylesheet" href="{{ asset('/css/bootstrap-multiselect/bootstrap-multiselect.css') }}" />
            <link rel="stylesheet" href="{{ asset('/css/material-design-iconic-font.min.css') }}" />
            <link rel="stylesheet" href="{{ asset('/css/file-and-folder.css') }}" />

            @endsection

            @section('content')

            <div class="container">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <?php echo $breadcrumbs?>
                <?php echo $search ?>
                <?php echo $add_tag ?>
                <?php echo $responsive_open?>
                <table id="bs-table" class="table <?php echo $options['bootstrap']['table_style']?>">
                    <thead>
                      <tr>
                        <?php echo $table_header?>
                    </tr>
                </thead>
                <tfoot>
                  <tr>
                    <td colspan="<?php echo $table_count+1?>">
                      <small class="pull-<?php echo $left?> text-muted" dir="ltr"><?php echo $summary ?></small>
                  </td>
              </tr>
          </tfoot>
          <tbody>
            <?php echo $table_body?>
        </tbody>
    </table>
    <?php echo $responsive_close?>
    <?php if ($options['general']['enable_viewer']) { ?>
    <div class="modal fade" id="viewer-modal" tabindex="-1" role="dialog" aria-labelledby="file-name" aria-hidden="true">
      <div class="modal-dialog <?php echo $modal_size ?>">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close pull-<?php echo $right?>" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-<?php echo $left?>" id="file-name">&nbsp;</h4>
            <small class="text-muted" id="file-meta"></small>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
            <?php if (($options['general']['enable_highlight'])) { ?>
            <div class="pull-<?php echo $left?>">
              <button type="button" class="btn <?php echo $btn_highlight ?> highlight hidden"><?php echo _('Apply syntax highlighting')?></button>
          </div>
          <?php } ?>
          <div class="pull-<?php echo $right?>">
              <button type="button" class="btn <?php echo $btn_default ?>" data-dismiss="modal"><?php echo _('Close')?></button>

              <a class="btn <?php echo $btn_primary ?> fullview" data-button="<?php echo _('Open')?>" role="button"></a>

          </div>
      </div>
  </div>
</div>
</div>
<?php } ?>

</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('/js/moment-with-locales.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap/transition.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap/collapse.js') }}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/stupidtable/0.0.1/stupidtable.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-searcher/0.2.0/jquery.searcher.min.js"></script>
<script type="text/javascript" src="{{ asset('/js/listr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery-bootstrap-modal-steps.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>

<!-- Add File Modal -->
@include('partials.file_add_wizard_dialog')
<!-- Add Folder Modal -->
@include('partials.folder_add_dialog')

{{--datetimepicker--}}
<script type="text/javascript">
    $(function () {
        var opt = "";
        $("#addFileOK").click(function(){
            var temp = $('form.addFileForm').serialize();
//            var n = window.location.pathname.indexOf('homework/create/');
var paths = window.location.pathname.split('/');
$.ajax({
  url: paths[paths.length-1],
  type: "POST",
  data: {new_file: temp, _token: $('input[name=_token]').val(),method: opt},
  success: function(data){
    location.reload();
}
});
});
        $("#addFolderOK").click(function(){
            var temp = $('form.addFolderForm').serialize();
            var paths = window.location.pathname.split('/');
            $.ajax({
              url: paths[paths.length-1],
              type: "POST",
              data: {new_folder: temp, _token: $('input[name=_token]').val(),method: opt},
              success: function(data){
                location.reload();
            }
        });
        });
        $("#file_add_btn").on('click',  function(){
            opt = 'add';
            $('#addFileModal').modal('toggle');
        });
        $("#folder_add_btn").on('click', function(){
            opt = 'add';
            $('#addFolderModal').modal('toggle');
        });
    });
</script>
@endsection