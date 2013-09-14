<?php
/*
    @app_name: SnippetVamp
    @author: bronco@warriordudimanche.net
    @web : http://warriordudimanche.net (FR)
    @License: open source, free to download & fork ^^
    @languages: French/Spanish and English 
    @apoligizes: please forget about my english (learned from american & british series ;-) 
    @status: alpha

    @Special thanks to Jerrywham for his great debug/enhance contribution and also to Bajazet, Yosko, Knah-Tsaeb... Thanks folks !
*/
if (!function_exists('json_encode')) {exit('SnippetVamp requires php 5.2 to do its magic... sorry');} 

$start=temps();
session_start();
// Remove that form the final version
function aff($a,$stop=true){echo 'Arret a la ligne '.__LINE__.' du fichier '.__FILE__.'<pre>';var_dump($a);echo '</pre>';if ($stop){exit();}}
######################################################################
# Initialisations
######################################################################
# langue 
######################################################################
$msg=array();
$msg['en']=array(
    'home_msg_textarea'=>'Homepage message',
    'app_name'=>'app name',
    'app_description'=>'app description',
    'sort_tags_by_nb'=>'sort tags by number',
    'nb_snippets_homepage'=>'nb snippets on each page',
    'nb_snippets_rss'=>'nb snippets in RSS feed',
    'url'=>'url of this page',
    'lang'=>'language',
    'default_status_private'=>'default snippet status private',
    'data_file'=>'snippet filename',
    'session_expiration_delay'=>'session expiration delay',
    'highlight_theme'=>'highlight.js theme',
    'highlight_embed_theme'=>'embedded snippet highlight.js theme',
    'log_filename'=>'Log\'s filename',
    );
$msg['es']=array(
    'Copy/paste the snippet here (snippetvamp was unable to find a snippet: no code or pre tag)'=>'Pegua el snippet aquí (SnippetVamp no encontró pre o code)',
    'restore SnippetVamp previous version'=>'Volver a la versión anterior de',
    'see log file'=>'Ver el contenido del log',
    'clear log file'=>'Borrar el contenido del log',
    'Log file content'=>'Contenido del log',
    'There\'s no previous version'=>'No existe versión anterior',
    'previous installed version restored, new one deleted'=>'Hemos vuelto a la versión anterior de SnippetVamp',
    'Create a pack with this snippet'=>'Incluir este snippet en un conjunto',
    'Pack selected snippets'=>'Packear los snippets seleccionados',
    'Drag this link to your shortcut bar'=>'Arrastra este botón hasta la barra de tu navegador',
    'Add to SnippetVamp'=>'Añadir en SnippetVamp',
    'The public access is locked'=>'El acceso público está desactivado',
    'There\'s a new version : '=>'Existe una nueva versión : ',
    'allow_public_access'=>'Autorizar el acceso público',
    'new_version_alert'=>'Mensaje para informar de las nuevas versiones',
    'multiple_tag_selection'=>'Selección multiple de tags (por defecto)',
    'Error loading file'=>'Error cargando los snippets',
    'import successfull'=>'Salió bien la importación',
    'Snippets successfully replaced'=>'Restauración terminada: todos los snippets anteriores han estado reemplazados',
    'wrong filetype'=>'Formato incorrecto ',
    'Error in the file format'=>'Error en el formato',
    'Configuration'=>'Configuración',
    'snippetvamp files'=>'Fichero de SnippetVamp',
    'import'=>'Importar snippets',
    'backup'=>'Descargar el fichero de snippets',
    'replace'=>'Reemplazar snippets',
    'import a data file from your computer'=>'Importar snippets desde un fichero SnippetVamp de tu ordenador',
    'replace all your snippets with a data file from your computer (erase ALL YOUR CURRENT SNIPPETS)'=>'Reemplazar todos los snippets por los de un fichero en tu ordenador: todos los snippets actuales estarán borrados',
    'backup your data file to your computer'=>'Descargar el fichero de SnippetVamp',
    'save this configuration'=>'Salvar la configuración',
    'embed code'=>'Código de integración',
    'no embed code (private snippet)'=>'Código de integración ausente (snippet privado)',
    'generated in'=>'Página generada en ',
    'true'=>'Sí',
    'false'=>'No',
    'app_name'=>'Nombre de la utilidad',
    'choose your id & pass'=>'Escoge tu apodo de conección y tu contraseña',
    'app_description'=>'Subtítulo / descripción',
    'sort_tags_by_nb'=>'Clasificar los tags por número',
    'nb_snippets_homepage'=>'Número max de snippets en la portada',
    'nb_snippets_rss'=>'Número max de snippets en el RSS',
    'url'=>'Dirección de esta página',
    'lang'=>'Idioma',
    'default_status_private'=>'Estado privado por defecto para los nuevos snippets',
    'data_file'=>'Fichero de datos',
    'session_expiration_delay'=>'Tiempo de expiracion de la sesión',
    'highlight_theme'=>'Tema de highlight.js',
    'highlight_embed_theme'=>'Tema de highlight.js para los snippets embed',
    'Only admin can access'=>'Solo el admin tiene acceso',
    'Acces allowed to rss and visitors'=>'Acceso autorizado a los visitantes y a RSS',
    'error'=>'Error', 
    'disconnect'=>'Deconección', 
    'password'=>'Contraseña',
    'confirm'=>'confirma la contraseña', 
    'login'=>'Apodo de conección',
    'Edit a snippet'=>'Editar un snippet',
    "This page's Feed"=>'RSS de esta página',
    'change the public/private status ?'=>'¿ Cambiar el estatuto privado/público ?', 
    '(click to change)'=>'(pincha para cambiar)', 
    'access: '=>'acceso :', 
    ' prive '=>' privado ', 
    'delete this snippet ? '=>'Destruir este Snippet ?', 
    'by'=>'por', 
    'search'=>'Búsqueda', 
    'no Snippet'=>'Snippet privado o inexistente', 
    'Save'=>'Salvar', 
    'separated with spaces'=>'separado por espacios', 
    'Website'=>'Sitio web', 
    'Content'=>'Contenido', 
    'Title'=>'Título', 
    'Add a snippet'=>'Añadir un Snippet', 
    'post date'=>' creado el ', 
    'text only'=>'texto solo', 
    'Edit'=>'Editar',
    'Text only'=>'Texto solo',
    'Del'=>'Supprimir',
    'saved'=>'Snippet salvado',
    'last'=>'últimos snippets',
    'embeded with SnippetVamp'=>'Creado en SnippetVamp',
    'multiselect tag'=>'Selección multiple',
    'filter by tags'=>'Clasificar por tags',
    'click to enable multi tag selection'=>'Pincha para activar la selección multiple de tags',
    'fork SnippetVamp on github'=>'Forkear SnippetVamp en GitHub',
    'snippetvamp_theme'=>'Aspecto de SnippetVamp',
    'home_msg_textarea'=>'Mensaje de bienvenida',
    'You must be logged for that'=>'Tienes que conectarte primero',
    'Error: problem whith the file '=>'Error con el fichero ',
    'Error : remote file is unavailable'=>'Error: el fichero no está en el servidor',
    'Application is already updated'=>'Ya dispones de la última versión',
    'SnippetVamp Update'=>'Actualización de SnippetVamp',
    'SnippetVamp updated successfully'=>'SnippetVamp logró actualizarse (¡ qué bien !)',
    'log_filename'=>'Nombre del fichiero log',
    'Password (leave blank if you don\'t want to change)'=>'Contraseña (dejar vacío para no cambiar)',
);
$msg['fr']=array(
    'Copy/paste the snippet here (snippetvamp was unable to find a snippet: no code or pre tag)'=>'Collez le snippet ici (SnippetVamp n\'a pas trouvé de balise pre ou code)',
    'Create a pack with this snippet'=>'Inclure ce snippet dans un pack',
    'restore SnippetVamp previous version'=>'Restaurer la version précédente de',
    'previous installed version restored, new one deleted'=>'La version précédente de SnippetVamp a été restaurée et la nouvelle effacée',
    'see log file'=>'Voir le contenu du fichier log',
    'There\'s no previous version'=>'Il n\'y a aucune ancienne version à restaurer',
    'clear log file'=>'Effacer le contenu du fichier log',
    'Log file content'=>'Contenu du fichier log',
    'Pack selected snippets'=>'Packer les snippets cochés',
    'Drag this link to your shortcut bar'=>'Glissez ce lien vers votre barre de favoris',
    'Add to SnippetVamp'=>'Ajouter à SnippetVamp',
    'The public access is locked'=>'L\'accès public est désactivé',
    'There\'s a new version : '=>'Une mise à jour est disponible : ',
    'allow_public_access'=>'Autoriser l\'accès public à l\'application',
    'new_version_alert'=>'Alerter si une nouvelle version existe',
    'multiple_tag_selection'=>'Sélection multiple de tags par défaut',
    'Error loading file'=>'Erreur en chargeant le fichier',
    'import successfull'=>'Importation réussie',
    'Snippets successfully replaced'=>'Tous les snippets ont été remplacés',
    'wrong filetype'=>'Type de fichier incorrect ',
    'Error in the file format'=>'Erreur dans le format de données',
    'snippetvamp files'=>'Fichiers de SnippetVamp',
    'import'=>'Importer snippets',
    'backup'=>'Télécharger fichier',
    'replace'=>'Remplacer snippets',
    'import a data file from your computer'=>'Importer des snippets depuis un fichier SnippetVamp de votre ordinateur',
    'replace all your snippets with a data file from your computer (erase ALL YOUR CURRENT SNIPPETS)'=>'Remplacer tous vos snippets par ceux d\'un fichier dat de votre ordinateur (restauration) Tous vos snippets courants seront détruits !',
    'backup your data file to your computer'=>'Sauvegarder sur votre ordinateur le fichier dat de SnippetVamp',
    'save this configuration'=>'Sauver la configuration',
    'embed code'=>'Code d\'intégration',
    'no embed code (private snippet)'=>'Pas de code d\'intégration (snippet privé)',
    'generated in'=>'Page générée en',
    'true'=>'Oui',
    'false'=>'Non',
    'app_name'=>'Nom de l\'application',
    'choose your id & pass'=>'Choisissez votre identifiant et votre mot de passe',
    'app_description'=>'Sous-titre',
    'sort_tags_by_nb'=>'Trier les tags par nombre',
    'nb_snippets_homepage'=>'Nb max de snippets en accueil',
    'nb_snippets_rss'=>'Nb max de snippets dans le flux',
    'url'=>'Adresse de cette page',
    'lang'=>'Langue',
    'default_status_private'=>'Statut privé par défaut',
    'data_file'=>'Fichier data',
    'session_expiration_delay'=>'Delai d\'expiration de la connexion',
    'highlight_theme'=>'Thème de highlight.js',
    'highlight_embed_theme'=>'Thème de highlight.js pour les snippets embed',
    'Only admin can access'=>'Seul l\'admin y a accès',
    'Acces allowed to rss and visitors'=>'Accès autorisé aux visiteurs et à RSS',
    'error'=>'Erreur', 
    'disconnect'=>'Deconnexion', 
    'password'=>'mot de passe',
    'confirm'=>'confirmez le mot de passe', 
    'login'=>'Pseudo',
    'Edit a snippet'=>'Editer un snippet',
    "This page's Feed"=>'Flux RSS de cette page',
    'change the public/private status ?'=>'changer le statut public/privé ?', 
    '(click to change)'=>'(cliquer pour changer)', 
    'access: '=>'accès :', 
    ' prive '=>' privé ', 
    'delete this snippet ? '=>'Supprimer ce Snippet ?', 
    'by'=>'par', 
    'search'=>'Recherche', 
    'no Snippet'=>'Snippet non public ou inexistant', 
    'Save'=>'Sauvegarder', 
    'separated with spaces'=>'séparés pas espaces', 
    'Website'=>'Site web', 
    'Content'=>'Contenu', 
    'Title'=>'Titre', 
    'Add a snippet'=>'Ajouter un Snippet', 
    'post date'=>' posté le ', 
    'text only'=>'texte seul', 
    'Edit'=>'Editer',
    'Text only'=>'Texte seul',
    'Del'=>'Supprimer',
    'saved'=>'Snippet sauvegardé',
    'last'=>'Derniers snippets',
    'embeded with SnippetVamp'=>'Fourni par SnippetVamp',
    'multiselect tag'=>'Sélection multiple',
    'filter by tags'=>'Filtrer par tags',
    'click to enable multi tag selection'=>'Cliquer pour activer la multi sélection de tags',
    'fork SnippetVamp on github'=>'Forker SnippetVamp sur GitHub',
    'snippetvamp_theme'=>'Thème de SnippetVamp',
    'home_msg_textarea'=>'Message d\'accueil',
    'You must be logged for that'=>'Il faut être connecté pour ça',
    'Error: problem whith the file '=>'Erreur: problème avec le fichier ',
    'Error : remote file is unavailable'=>'Erreur: fichier distant introuvable',
    'Application is already updated'=>'L\'application est déjà à jour',
    'SnippetVamp Update'=>'Mise à jour de SnippetVamp',
    'SnippetVamp updated successfully'=>'Mise à jour réussie',
    'log_filename'=>'Nom du fichier log',
    'Password (leave blank if you don\'t want to change)'=>'Mot de passe (laisser vide pour ne pas changer)',
    );


######################################################################
# Création des fichiers si nécessaire (1ère utilisation)
######################################################################
# configuration de base par défaut
######################################################################
if (!file_exists('config.dat')){
    $config=array(
        'app_name'=>'SnippetVamp',
        'app_description'=>'Because spending time searching snippets sucks.',
        'home_msg_textarea'=>'Welcome to my SnippetVamp space ! ',
        'sort_tags_by_nb'=>false,
        'multiple_tag_selection'=>false,
        'nb_snippets_homepage'=>30,
        'nb_snippets_rss'=>30,
        'url'=>'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'],
        'lang'=>'en', 
        'default_status_private'=>true, // by default, every snippet private status is 'on'
        'data_file'=>'snippetvamp.dat', // data filename: change it to secure
        'encryption_key'=>'warriordudimanche.net',// The key to encrypt password
        'session_expiration_delay'=>30,//minutes
        'highlight_theme'=>'default',
        'highlight_embed_theme'=>'shCoreRDark',
        'snippetvamp_theme'=>'default',
        'login'=>'',
        'new_version_alert'=>true,
        'allow_public_access'=>true,
    );
    store('config.dat',$config);
}else{
    $config=unstore('config.dat');
}

$config['version']='1.84';
$config['update_url']='http://snippetvamp.warriordudimanche.net/update/';

//I'LL REMOVE THOSE LINES LATER: here we keep compatibility with previous versions (adding the key) 
if(!isset($config['new_version_alert'])){$config['new_version_alert']=true;store('config.dat',$config);} 
if(!isset($config['log_filename'])){$config['log_filename']='log.txt';store('config.dat',$config);} 
if(!isset($config['allow_public_access'])){$config['allow_public_access']=true;store('config.dat',$config);} 
if(!isset($config['snippetvamp_theme'])){$config['snippetvamp_theme']='default';store('config.dat',$config);} 
if(!isset($config['home_msg_textarea'])){$config['home_msg_textarea']='Welcome to my SnippetVamp space !';store('config.dat',$config);} 
# use auto_css if present
######################################################################
if (file_exists('theme/'.$config['snippetvamp_theme'].'/auto_css.php')){include('theme/'.$config['snippetvamp_theme'].'/auto_css.php'); } //  

# data file 
######################################################################
if (!file_exists($config['data_file'])){$snippets=array();store($config['data_file'],$snippets);cache_clear();}
$snippets=load();$page='';
# pass file
######################################################################
if(!file_exists('pass.php')){
    if(isset($_POST['pass'])){ // handle pass creation
        if ($_POST['pass']==$_POST['pass2']&&$_POST["login"]){
            $salt = md5(uniqid('', true));
            file_put_contents('pass.php', '<?php $config["login"] = "'.$_POST["login"].'"; $config["salt"] = '.var_export($salt,true).'; $config["pass"] = '.var_export(hash('sha512', $salt.$_POST['pass']),true).'; ?>');
            header('location: index.php');
        }else{ exit(msg('error'));}
    }
    else{ //pass creation form
        exit ('<form style="border-radius:4px; margin:10px; padding:10px;display:block;margin:auto;width:200px;background-color:#DDD;border:1px solid black; box-shadow:0 1px 2px black; text-shadow:0 1px -1px white;" action="#" method="POST">'.$config['app_name'].'<hr/>'.msg('choose your id & pass').'<input type="text" name="login" placeholder="'.msg('login').'"/><input type="password" name="pass" placeholder="'.msg('password').'"/><input type="password" name="pass2" placeholder="'.msg('confirm').'"/><input type="submit" value="Ok"/></form>');
    }
}else{include('pass.php');}

# .htaccess file
######################################################################
if(!file_exists('.htaccess')){
    file_put_contents('.htaccess', "<Files ".$config['log_filename'].">\n\tOrder deny,allow\n\tDeny from all\n</Files>");
}

# misc vars
######################################################################
$contenu='';


######################################################################
# OTHER POST DATA 
######################################################################
# admin login/deco
######################################################################
if (isset($_POST['login'])&&isset($_POST['pass'])){cache_clear();log_user($_POST['login'],$_POST['pass']);}
else if (isset($_POST['pass'])){log_user($config['login'],$_POST['pass']);} // logme with the bookmarklet form

$admin=is_ok();
if (isset($_POST['exit'])){inlog('User disconnected');log_user("","");}
# config change
######################################################################
if ($admin&&isset($_POST['app_name'])){
    inlog('Configuration changed');
    if ($config['data_file']!=$_POST['data_file']&&!is_file($_POST['data_file'])){backup_datafile();rename ($config['data_file'],$_POST['data_file']);} // rename if .dat filename has changed
    if ($config['log_filename']!=$_POST['log_filename']&&!is_file($_POST['log_filename'])){rename ($config['log_filename'],$_POST['log_filename']); file_put_contents('.htaccess', "<Files ".$_POST['log_filename'].">\n\tOrder deny,allow\n\tDeny from all\n</Files>");} // renaming log file
    foreach($_POST as $key=>$value){ // change 'true' by true & secure
        if($key == 'login' || $key == 'password') continue;
        if ($value=='true'){$config[$key]=true;}
        else if ($value=='false'){$config[$key]=false;}
        else if ($key=='home_msg_textarea'){$config[$key]=map_entities($_POST[$key]);}
        else {$config[$key]=htmlentities($_POST[$key]);}
    }
    store('config.dat',$config);
    if($_POST['login'] != $config['login']) {$config['login']=htmlentities($_POST['login']); $update_pass=true;}
    if(!empty($_POST['password'])) {$config['pass']=var_export(hash('sha512', $config['salt'].$_POST['password']),true); $update_pass=true;}
    if(!empty($update_pass)) {
        file_put_contents('pass.php', '<?php $config["login"] = "'.$config["login"].'"; $config["salt"] = '.var_export($config['salt'],true).'; $config["pass"] = '.$config['pass'].'; ?>');
    }
    cache_clear();
    header('location: index.php');
}

# add/edit snippets
######################################################################
if ($admin&&isset($_POST['#num'])){
    foreach($_POST as $cle=>$valeur){
        if (substr($cle,0,5)!='check'){ $snippets[$_POST['#num']][$cle]=$valeur;}else {if (!stripos(' '.$snippets[$_POST['#num']]['#tags'],$valeur)){$snippets[$_POST['#num']]['#tags'].=' '.$valeur;}}
    }
    $snippets[$_POST['#num']]['#tags']=htmlentities(tag_normalise(trim($snippets[$_POST['#num']]['#tags'])));
    $snippets[$_POST['#num']]['#rss_date']=@date('r');// RSS compatible date format (important)
    $snippets[$_POST['#num']]['#date']=@date('d/m/Y');// human friendly date format ^^
    save();
    if ($_POST['from_bookmarklet']=='no'){
        inlog('Create/edit snippet N°<a href="?snippet='.$_POST['#num'].'">'.$_POST['#num'].'</a>');
        $page.= success('saved');
    }else{
        inlog('New snippet from bookmarklet (N°<a href="?txt='.$_POST['#num'].'">'.$_POST['#num'].'</a>)');
        echo '<script>window.close("_blank");</script>';
    }
    header('location: index.php');

}
# import snippets
######################################################################
if ($admin&&isset($_FILES['import_file'])){
    inlog('Importing snippets from file');
    if($_FILES['import_file']['type']=='application/octet-stream'){
        $new_snippets=unstore($_FILES['import_file']['tmp_name']);
        if (isset($new_snippets['tag_list'])){
            //merge tag array before (avoid tags loss)
            if (!isset($snippets['tag_list'])){$snippets['tag_list']=array();}
            $tags=$snippets['tag_list'];$new_tags=$new_snippets['tag_list'];
            foreach ($tags as $tag=>$nb){
                if (isset($new_tags[$tag])){
                    $new_tags[$tag]+=$nb;
                }else{ $new_tags[$tag]=$nb;}
            }
            $new_snippets['tag_list']=$new_tags;
            $snippets=array_merge($snippets,$new_snippets);
            save();
            $page= success('import successfull');
        }else{$page.=alert(msg('Error in the file format'));inlog('<em class="warning">snippet file format incorrect</em>');}
    }else{$page.=alert(msg('wrong filetype'));inlog('<em class="warning">snippet file format incorrect</em>');}
    
}
# replace snippets
######################################################################
if ($admin&&isset($_FILES['replace_file'])){
    inlog('Replacing snippet file');
    if($_FILES['replace_file']['type']=='application/octet-stream'){
        $new_snippets=unstore($_FILES['replace_file']['tmp_name']);
        if (isset($new_snippets['tag_list'])){
            if(rename($_FILES['replace_file']['tmp_name'], $config['data_file'])){
                $page.= success(msg('Snippets successfully replaced'));
                $snippets=load();
            }else{$page.=alert(msg('Error loading file'));inlog('<em class="warning">Error uploading snippet file</em>');}
        }else{$page.=alert(msg('Error in the file format'));inlog('<em class="warning">snippet file format incorrect</em>');}
    }else{$page.=alert(msg('wrong filetype'));inlog('<em class="warning">snippet file format incorrect</em>');}
}
######################################################################
# core functions
######################################################################
# 2 functions from IdleMan http://blog.idleman.fr/?p=1722 (Thx bro' )
function store($file,$datas){$store = $datas; unset($store['login'], $store['password'], $store['salt']); file_put_contents($file,gzdeflate(json_encode($store))); unset($store);}
function unstore($file){return json_decode(gzinflate(file_get_contents($file)),true);}
# Security
function GenerationCle($Texte,$CleDEncryptage){ $CleDEncryptage = md5($CleDEncryptage); $Compteur=0; $VariableTemp = ""; for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) {if ($Compteur==strlen($CleDEncryptage)){ $Compteur=0; }$VariableTemp.= substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1); $Compteur++; } return $VariableTemp; }
function Crypte($Texte,$Cle) { srand((double)microtime()*1000000); $CleDEncryptage = md5(rand(0,32000) ); $Compteur=0; $VariableTemp = ""; for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) { if ($Compteur==strlen($CleDEncryptage)) $Compteur=0; $VariableTemp.= substr($CleDEncryptage,$Compteur,1).(substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1) ); $Compteur++;} return base64_encode(GenerationCle($VariableTemp,$Cle) );}
function Decrypte($Texte,$Cle){$Texte = GenerationCle(base64_decode($Texte),$Cle);$VariableTemp = "";for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++){$md5 = substr($Texte,$Ctr,1);$Ctr++;$VariableTemp.= (substr($Texte,$Ctr,1) ^ $md5);} return $VariableTemp;}      
function id_user(){$id=array();$id['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];$id['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];$id['session_id']=session_id();$id=serialize($id);return $id;}
function is_ok(){global $config;$expired=false;if (!isset($_SESSION['id_user'])){return false;}if ($_SESSION['expire']<time()){$expired=true;}$sid=Decrypte($_SESSION['id_user'],$config['encryption_key']);$id=id_user();if ($sid!=$id || $expired==true){return false;}else{$_SESSION['expire']=time()+(60*$config['session_expiration_delay']);return true;} }
function log_user($login_donne,$pass_donne){global $config;if ($config['login']==$login_donne && $config['pass']==hash('sha512', $config["salt"].$pass_donne)){ inlog('<em class="ok">User '.$login_donne .' logged successfully</em>');$_SESSION['id_user']=Crypte(id_user(),$config['encryption_key']);$_SESSION['login']=$config['login'];   $_SESSION['expire']=time()+(60*$config['session_expiration_delay']);return true;}else{if($login_donne!=''&&$pass_donne!=''){inlog('<em class="warning">User tried to log</em>');}exit_redirect();return false;}}
function exit_redirect(){@session_unset();@session_destroy();reload_page(false);}
function is_public($id_nb,$returnbool=true){global $snippets;if ($snippets[$id_nb]['#public']=='true'||$snippets[$id_nb]['#public']===true||$snippets[$id_nb]['#public']===1||$snippets[$id_nb]['#public']=='1'){if ($returnbool==true){return true;}else{return ' public ';}}else{if ($returnbool==true){return false;}else{return ' prive ';}} }
function loggedstring($tpl=''){if (is_ok()){return $tpl;}else{return '';}}
function conn_deconn(){global $template; if (!is_ok()){echo $template['connect_form'];}else{echo $template['deconnect_button'];}}
function map_entities($chaine){return htmlentities($chaine, ENT_QUOTES, 'UTF-8');}
function tag_normalise($chaine){$chaine=remove_accents($chaine);$chaine=preg_replace('/[^\w#+. ]/','',$chaine);return str_ireplace(array('+','#','.'),array('p','sharp','dot'),$chaine);}
function remove_accents($str, $charset='utf-8'){ $str = htmlentities($str, ENT_NOQUOTES, $charset); $str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str); $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); $str = preg_replace('#&[^;]+;#', '', $str); return $str;} // via weirdog.com 
# Content
function save(){inlog('Saving snippet file');cache_clear();global $config,$snippets;$snippets['tag_list']=list_tags();$snippets['tag_private_list']=list_tags(false);if (!store($config['data_file'],$snippets)){return alert('Error');}else{return success('saved');}}
function load(){global $config;return unstore($config['data_file']);}
function file_curl_contents($url){$ch = curl_init();curl_setopt($ch, CURLOPT_HEADER, 0);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);curl_setopt($ch, CURLOPT_URL, $url);(ini_get('open_basedir') ? curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true) : '');curl_setopt($ch, CURLOPT_MAXREDIRS, 10);$data = curl_exec($ch);curl_close($ch);if (!$data){return false;}else{return $data;}}
function backup_datafile(){global $config; $c=file_get_contents($config['data_file']);file_put_contents('BACKUP_'.@date('d-m-Y').'_'.$config['data_file'],$c);}
function toggle_public($nb){global $snippets;if (!isset($snippets[$nb])){return false;} if ($snippets[$nb]['#public']=='true'||$snippets[$nb]['#public']===true){$snippets[$nb]['#public']=false;}else{$snippets[$nb]['#public']=true;}}
function templatise_snippet($snippet,$tpl='snippet',$hidden='hidden'){global $template,$config;if (!isset($snippet['#tags'])||!isset($snippet['#num'])||!isset($snippet['#adresse'])){return false;}$snippet['#public']=is_public($snippet['#num'],false);if($snippet['#public']==' public '){$snippet['#direct_link']=str_replace(array('#num','#height'),array($snippet['#num'], embed_height($snippet['#contenu'])),$template['embed_code']);}else{$snippet['#direct_link']=msg('no embed code (private snippet)');}$snippet=secure($snippet);$snippet['#nolink']=$snippet['#tags'];$snippet['#hidden']=$hidden;if ($snippet['#adresse']!=''){$snippet['#adresse']='<a class="adr" href="'.$snippet['#adresse'].'" >'.$snippet['#adresse'].'</a>';}$snippet['#tags']=preg_replace('#([^ ]+)#',$template['tag_btn'],$snippet['#tags']);$snippet['#origine']=$_SERVER['QUERY_STRING'];$snippet['#contenu'] = str_replace(array(' ',"\t"), array('&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;'), $snippet['#contenu']);return str_replace(array_keys($snippet),array_values($snippet),$template[$tpl])."\n";}
function list_tags($all=true){
    global $snippets;
    $tags=array();
    foreach($snippets as $snippet){
        if (isset($snippet['#tags'])){
            $t=explode(' ',trim($snippet['#tags']));
            if (isset($snippet['#num'])){$ispublic=is_public($snippet['#num']);}else{$ispublic=true;}
            
            foreach ($t as $tag){
                if (!$all&&$ispublic||$all){
                    $tag=trim($tag);
                    if(!isset($tags[$tag])){
                        $tags[$tag]=1;
                    }else{
                        $tags[$tag]++;
                    }
                }
                
            }

        }
    } 
    ksort($tags);
    unset($tags['']);
    return $tags;
}
function tag_cloud($templ='tag_cloud_link',$sortbynb=false,$tags_checked=false){global $snippets,$template,$admin;if (!isset($snippets['tag_list'])){return false;}if (!$admin&&isset($snippets['tag_private_list'])){$tags=$snippets['tag_private_list'];}else{$tags=$snippets['tag_list'];}$tag_cloud=''; if ($sortbynb){arsort($snippets['tag_list']);} foreach($tags as $tag=>$nb){  $t=str_replace('#TAG',$tag,$template[$templ]);  $t=str_replace('#NB',$nb,$t);   if ($tags_checked && stripos($tags_checked,$tag)!==false || !$tags_checked && stripos($_SERVER['QUERY_STRING'],$tag) ){     $t=str_replace('#checked','checked',$t); }else{ $t=str_replace('#checked','',$t);}$tag_cloud.= $t;}return $tag_cloud;}
function make_rss($array,$titre){global $template,$config;if(isset($_POST['config'])){return false;}$array=array_reverse($array);    echo str_replace('#titre',$config['app_name'].' '.$config['login'].': '.$titre,$template['rss_header']); foreach($array as $a){if (isset($a['#num']) && is_public($a['#num'])){ $a=array_map('map_entities',$a);echo str_replace(array_keys($a),array_values($a),$template['rss_item']);}} echo $template['rss_footer'];}
function form($num=false,$placeholder='Snippet'){if (!is_ok()){return '';} global $config,$template,$snippets;$repl=array();$repl['#labeltags']=msg('Tags');$repl['#placeholder']=$placeholder;$repl['#labeltitre']=msg('Title');$repl['#passwordform']='';$repl['#labeladr']=msg('Website');$repl['#labelcontent']=msg('Content');if (!$num){$repl['#uniqid']=uniqid();    $repl['#formtitre']=msg('Add a snippet');$repl['#tagcloud']=tag_cloud('tag_cloud_checkbox',$config['sort_tags_by_nb']);$repl['value="#titre"']='value=""';$repl['value="#adresse"']='value=""';$repl['#contenu</textarea>']='</textarea>';$repl['#hidden']='hidden';return str_replace(array_keys($repl),array_values($repl),$template['snippet_frm']);}else{if (isset($snippets[$num])){$repl['#uniqid']=$num;$repl['#formtitre']=msg('Edit a snippet');   $repl['#tagcloud']=tag_cloud('tag_cloud_checkbox',$config['sort_tags_by_nb'],$snippets[$num]['#tags']);$repl['value="#titre"']='value="'.$snippets[$num]['#titre'].'"';$repl['value="#adresse"']='value="'.$snippets[$num]['#adresse'].'"';$repl['#contenu</textarea>']=$snippets[$num]['#contenu'].'</textarea>';$repl['#hidden']='';return str_replace(array_keys($repl),array_values($repl),$template['snippet_frm']);}else{return false;}}}
function form_bookmarklet($title='', $url='',$content='',$placeholder='Snippet',$passwordform=''){global $config,$template;$repl=array();$repl['#labeltags']=msg('Tags');$repl['#labeltitre']=msg('Title');$repl['#labeladr']=msg('Website');$repl['#labelcontent']=msg('Content');$repl['#placeholder']=$placeholder;$repl['#passwordform']=$passwordform;$repl['#uniqid']=uniqid();   $repl['#formtitre']=msg('Add a snippet');$repl['#tagcloud']=tag_cloud('tag_cloud_checkbox',$config['sort_tags_by_nb']);$repl['value="#titre"']='value="'.$title.'"';$repl['value="#adresse"']='value="'.$url.'"';$repl['#contenu</textarea>']=$content.'</textarea>';$repl['#hidden']='';$repl[' name="from_bookmarklet" value="no"']=' name="from_bookmarklet" value="yes"';return str_replace(array_keys($repl),array_values($repl),$template['snippet_frm']);}
function form_config(){global $msg,$config;$selecttrue=$selectfalse='';$form=  '<form name="config" action="" method="post" id="config">';foreach ($config as $cle=>$val){  if ($cle!='login'&&$cle!='update_url'&&$cle!='pass'&&$cle!='salt'&&$cle!='encryption_key'&&$cle!='version'){$form.= '<label for="'.$cle.'">'.msg($cle).'</label>';if (is_bool($val)||$val=='true'||$val=='false'){  if ($val==true||$val=='true'){$val='true';$selecttrue=' selected="selected" ';$selectfalse='';}else{$val='false';$selectfalse=' selected="selected" ';$selecttrue='';}$form.='<select id="'.$cle.'" name="'.$cle.'"><option value="true" '.$selecttrue.'>'.msg('true').'</option><option value="false"'.$selectfalse.'>'.msg('false').'</option></select>';}elseif(stripos($cle,'_textarea')){$form.= '<textarea name="'.$cle.'" id="'.$cle.'" >'.$val.'</textarea>';}elseif($cle=='highlight_theme'||$cle=='highlight_embed_theme'){$form.='<select  id="'.$cle.'" name="'.$cle.'">';$form.= array2options(glob('styles/*.css'),true,$val);$form.='</select>';}elseif($cle=='snippetvamp_theme'){$form.='<select  id="'.$cle.'" name="snippetvamp_theme">';$form.= array2options(glob('theme/*'),true,$val); $form.='</select>';}elseif($cle=='lang'){$form.='<select  id="'.$cle.'" name="lang">';$form.= array2options($msg,false,$val);$form.='</select>';}else{$form.= '<input type="text" name="'.$cle.'" value="'.$val.'"/>';}}}$form.='<label for="login">Login</label><input type="text" name="login" value="'.$config['login'].'"/><label for="password">'.msg('Password (leave blank if you don\'t want to change)').'</label><input type="password" name="password"/>';$form.='<input type="submit" value="'.msg('Save').'" title="'.msg('save this configuration').'"/></form>';return $form;}
function form_import_file(){global $config;$form=  '<form name="import" action="" method="post" id="import"  enctype="multipart/form-data"><input type="file" id="import_file" name="import_file" class="hidden"/><label for="import_file" title="'.msg('import a data file from your computer').'">'.msg('import').' </label><input type="submit" class="ghost submit_import"/></form>';return $form;}
function form_replace_file(){global $config;$form=  '<form name="replace" action="" method="post" id="replace" enctype="multipart/form-data"><input type="file" name="replace_file" id="replace_file" class="hidden"/><label for="replace_file" title="'.msg('replace all your snippets with a data file from your computer (erase ALL YOUR CURRENT SNIPPETS)').'">'.msg('replace').' </label><input type="submit" class="ghost submit_replace"/></form>';return $form;}
function restore_sv_link(){return'<a class="button restore" href="?restore">'.msg('restore SnippetVamp previous version').'</a>';}
function backup_link(){return '<input type="button" class="backup" value="'.msg('backup').'" title="'.msg('backup your data file to your computer').'"/>';}
function feed_link($url_only=false){if (stripos($_SERVER['QUERY_STRING'],'config=')===false&&stripos($_SERVER['QUERY_STRING'],'txt=')===false){global $config;$link=$config['url'].'?rss=on&'.$_SERVER['QUERY_STRING']; if ($url_only){echo $link;}else{echo '<p class="rss"><a href="'.$link.'">'.msg("This page's Feed").'</a></p>';}}}
function log_link(){return '<a class="button log" href="?log">'.msg('see log file').'</a>';}
function config_link(){if (stripos($_SERVER['QUERY_STRING'],'config=')===false&&is_ok()){echo'<a class="config" href="?config=true">'.msg('Configuration').'</a> - ';}}
function are_values_in_string($array,$string,$all=true){$found=0;foreach($array as $val){if (stripos(' '.$string.' ', ' '.$val.' ')!==false){$found++;}}if ($all && $found==count($array) || !$all && $found>0){return true;}else{return false;}}
function search($chaine,$cle=false, $from=0){global $snippets,$template,$config;if ($cle==false){$query='search='.$chaine;}else{$query='tag='.$chaine;} $chaine=str_replace(' ','+',$chaine);$chaine=explode('+',$chaine);$nb_words=count($chaine);$list='';$admin=is_ok(); $results=array(); foreach($snippets as $snippet){if ($admin && isset($snippet['#num']) || isset($snippet['#num']) && is_public($snippet['#num'])){ if (!$cle && are_values_in_string($chaine,implode(' ',$snippet))!==false || $cle && isset($snippet[$cle]) && are_values_in_string($chaine,$snippet[$cle])!==false){$results[$snippet['#num']]=$snippet;}}}$nb_results=count($results);$results=array_slice($results,$from,$config['nb_snippets_homepage'],true);$results=array_reverse($results);foreach($results as $snippet){$list.= templatise_snippet($snippet);}$list.='<p class="pagination">'.paginate($from,$nb_results,$query).'</p>';if ($list!=''){return $list;}else{return false;}}
function return_if($return_value,$truefalse){if ($truefalse){return $return_value;}else{return '';}}
function msg($m){global $msg,$config;if(isset($msg[$config['lang']][$m])){return $msg[$config['lang']][$m];}else{return $m;}}
function alert($txt){return '<p class="alert">'.msg($txt).'</p>';}
function info($txt){return '<p class="info">'.msg($txt).'</p>';}
function success($txt){return '<p class="success">'.msg($txt).'</p>';}
function e($conf_index){global $config; if (isset($config[$conf_index])){echo $config[$conf_index];}else{return false;}}
function BodyClasses($add=''){$regex='#(msie)[/ ]([0-9])+|(firefox)/([0-9])+|(chrome)/([0-9])+|(opera)/([0-9]+)|(safari)/([0-9]+)|(android)|(iphone)|(ipad)|(blackberry)|(Windows Phone)|(symbian)|(mobile)|(bada])#i';@preg_match($regex,$_SERVER['HTTP_USER_AGENT'],$resultat);return ' class="'.$add.' '.@preg_replace('#([a-zA-Z ]+)[ /]([0-9]+)#','$1 $1$2',$resultat[0]).' '.basename($_SERVER['PHP_SELF'],'.php').'" ';}
function add_protocol($url,$protocol='http://'){preg_match('#^([ftphs]+://)([^ ]+)#',$url,$results);if (count($results)>0){return $url;}else{return $protocol.$url;}}
function parse_for_snippet($url){$page=@file_get_contents(trim($url));if ($page===false){return false;}if (preg_match('#<title>([^<]+)</title>#', $page , $title)){$title=trim($title[1]);}else{$title='';}if (preg_match_all('#<code[^>]*>([^<]+)</code>#', $page , $code_blocs)){$code_blocs[1]['title']=trim($title);return $code_blocs[1];}if (preg_match_all('#<pre[^>]*>([^<]+)</pre>#', $page , $code_blocs)){$code_blocs[1]['title']=trim($title);return $code_blocs[1];}if (preg_match_all('#(http[s]*://[^ ]*index.php\?embed=[0-9a-z]+)#', $page , $code_blocs)){$code['title']=$title;foreach($code_blocs[0] as $link){$code[]=file_get_contents(str_replace('?embed=','?txt=',$link));}return $code;}return false;}
function array2options($array,$listvalues=true,$active=''){ if (is_array($array)){$active=trim($active);$list='';foreach ($array as $key=>$val){if (!is_array($val)&&!stripos($val,'index.html')||is_array($val)){if ($listvalues===true){ $v=trim(str_replace(array('theme/','styles/','.css'),'',$val));}else{$v=$key;}if ($active==$val||$active==$v){$selected=' selected="selected" ';}else{$selected='';} $list.='<option value="'.$v.'" '.$selected.'>'.$v.'</option>';}}return $list;}else{ return false;}}
function paginate($current, $nb_snippets,$query){global $config;$links=''; if ($nb_snippets<=$config['nb_snippets_homepage']||$nb_snippets==0){return '';}$nb_pages=intval($nb_snippets/$config['nb_snippets_homepage']);if ($nb_snippets%$config['nb_snippets_homepage']>0){$nb_pages++;}for ($page=0;$page<$nb_pages;$page++){if ($page*$config['nb_snippets_homepage']==$current){$links.= '<em class="pagination_current">'.($page+1).'</em>';}else{$links.='<a href="'.$config['url'].'?'.$query.'&from='.($page*$config['nb_snippets_homepage']).'" class="pagination_link">'.($page+1).'</a>';}}return $links;}
# Cache
function cache_temp_folder(){if (!is_dir('temp/')){mkdir ('temp');}}
function cache_read($fichier){cache_temp_folder();if (file_exists('temp/'.$fichier)&&!cache_is_obsolete($fichier)){$donnees=file_get_contents('temp/'.$fichier);if ($donnees2=@unserialize($donnees)){$donnees=$donnees2;}   return $donnees; }else{return false;}}
function cache_write($fichier,$donnees,$duree){cache_temp_folder();file_put_contents('temp/'.$fichier,$donnees);if ($duree!=0){$duree=@date('U')+(60*$duree);}touch('temp/'.$fichier,$duree);}
function cache_clear(){cache_temp_folder();$fs=glob('temp/*'); if(!empty($fs)){foreach ($fs as $file){unlink ($file);}}}
function cache_is_obsolete($fichier){$dat=@filemtime('temp/'.$fichier);if (!file_exists('temp/'.$fichier)){return true;}if ($dat==0){return false;}if ($dat<@date('U')){cache_delete($fichier);return true;}return false;}
function cache_delete($fichier){if (file_exists('temp/'.$fichier)){unlink ('temp/'.$fichier);}}
function cache_start(){ob_start();}
function cache_end($fichier,$duree){$donnees=ob_get_clean();cache_write($fichier,$donnees,$duree);return $donnees;}
# Misc
function inlog($text){global $config;file_put_contents($config['log_filename'],@date('d/m/Y h:i').': '.$text."\n",FILE_APPEND);}
function secure($array){return array_map('map_entities',$array);}
function return_matching($chaine,$cle=false){global $snippets;$chaine=str_replace(' ','+',$chaine);$chaine=explode('+',$chaine);$nb_words=count($chaine);$resultats=array();foreach($snippets as $snippet){if (isset($snippet['#num']) && !$cle && are_values_in_string($chaine,implode(' ',$snippet))!==false || $cle!==false && isset($snippet[$cle]) && are_values_in_string($chaine,$snippet[$cle])!==false){ $resultats[$snippet['#num']]= $snippet;}} return $resultats;}
function reload_page($query=''){ if ($query===false){$query=$_SERVER['QUERY_STRING'];}header('Location: index.php?'.$query);}
function temps(){$t=microtime();$tt=explode(' ',$t);return $tt[0]+$tt[1];}
function embed_height($string){return (substr_count($string, "\n")*18)+200; }
function alert_last_version_if_necessary() {global $config,$admin;if(!$config['new_version_alert']||!$admin){return false;}$seconds_before_update_file=@date('U')-@date('U',filemtime('last_version.txt'));if(!is_file('last_version.txt') || $seconds_before_update_file>18000){if(!$c=file_curl_contents($config['update_url'].'last_version.txt')){return false;}file_put_contents('last_version.txt',$c);}$v=file_get_contents('last_version.txt');if($v!=$config['version']){return '<a href="?domaj">'.msg('There\'s a new version : ').$v.'</a>';}}
function maj_auto(){
    inlog('Starting update process');
    global $config,$admin;
    $filesToUpdate='files_to_update.txt';
    if (!$admin){inlog('<em class="warning">!! User not logged as admin</em>');return alert(msg('You must be logged for that'));}
    if (!$list=file_curl_contents($config['update_url'].$filesToUpdate)){inlog('<em class="warning">!! remote file is unavailable</em>');return alert(msg('Error : remote file is unavailable'));}else{$list=explode("\n",$list);}
    $destination = str_replace('index.php','', realpath('index.php')); 
    if(is_array($list)) {
        if($list[0] == $config['version']){inlog('!! SnippetVamp already up to date');return info(msg('Application is already updated'));}
        foreach ($list as $key => $file) {
            if ($key>0) {
                $file=trim($file);
                if (strpos($file, '/')) {
                    $files =explode('/',$file);
                    $c =count($files);
                    foreach ($files as $key => $dir){
                        $dir=trim($dir);
                        if ($key!= $c-1 && $key != 0) {if(!is_dir($destination.$files[$key-1].'/'.$dir)){inlog('>> creating folder '.$dir); mkdir($destination.$files[$key-1].'/'.$dir);}}
                        if ($key== $c-1){
                            if($dir!=$filesToUpdate){
                                if (!$content=download_and_check_integrity($file,$destination)){return alert(msg('Error: problem whith the file ').$dir);}
                            }
                        }
                    }
                } else {
                    if ($file=='index.php'){inlog('>> backup index.php '.$dir);file_put_contents('old_index.php',file_get_contents(realpath('index.php')));}
                    if ($file != $filesToUpdate){if (!$content=download_and_check_integrity($file,$destination)){return alert(msg('Error: problem whith the file ').$file);}}
                }
            }
        }
        inlog('>> Update successfull');
        @unlink('last_version.txt');
        return success(msg('SnippetVamp was successfully updated to ').$list[0]);

        
    } else  {return alert(msg('Error : download abord'));}
}
function download_and_check_integrity($file,$destination,$counter=5){
    global $config;
    if (!$content=file_curl_contents($config['update_url'].'maj.php?f='.$file)){inlog('<em class="warning">!! file unreachable </em>'.$file);return false;}
    file_put_contents($destination.$file,$content);
    while(!md5_file($file)==$config['update_url'].'maj.php?f='.$file.'&md5'&& $counter<=0){
        inlog('<em class="warning">!!Integrity failure, retry </em>'.$dir.' (n°'.$counter.')');
        $counter--;
        $content=file_curl_contents($config['update_url'].'maj.php?f='.$file);
        file_put_contents($destination.$file,$content);
    }
    if (!md5_file($file)==$config['update_url'].'maj.php?f='.$file.'&md5'){inlog('<em class="warning">!!Integrity failure </em>');return false;}else{return $content;}
}

######################################################################
# Templates
######################################################################
$hidden=return_if('hidden',!$config['multiple_tag_selection']); 
$multiselect_button_state=return_if('hidden',$config['multiple_tag_selection']);
$r="\n";
$template=array();
$template['bookmarklet']='<strong>Bookmarklet</strong><br/>'.msg('Drag this link to your shortcut bar')."<a href=\"javascript:javascript:(function(){var url = location.href;window.open('".$config['url']."?bookmarklet=' + encodeURIComponent(url),'_blank','menubar=yes,height=600,width=1000,toolbar=yes,scrollbars=yes,status=yes');})();\" >".msg('Add to SnippetVamp')."</a>";
$template['deconnect_button']='<form action="" method="POST" class="deconnect"><input name="exit" type="hidden" value=""/><input type="submit" value="'.$config['login'].':'.msg('disconnect').'" class="exit"/></form>';
$template['connect_form']='<form action="" method="POST" class="login"><input name="login" type="text" placeholder="'.msg('login').'"/><input name="pass" type="password" title="'.msg('password').'"/><input type="submit" value="ok"/></form>';
$template['embed_code']='<iframe width="100%" height="#height" src="'.$config['url'].'?embed=#num" type="text/html"></iframe>';
$template['embeded_snippet']='<h3>#titre</h3><pre><code class="#nolink">#contenu</code></pre><p class="snippetcopyright">#adresse '.msg('embeded with SnippetVamp').'</p>';
$template['buttons']='<div class="buttons nomobile "><button class="suppr" data="#num&vars=#origine" title="'.msg('Del').'"> </button><button class="#public toggle" data="#num&vars=#origine" title="'.msg('access: ').'#public '.msg('(click to change)').'"> </button><button class="edit" data="#num" title="'.msg('Edit').'"> </button><button class="txt" data="#num" title="'.msg('Text only').'"> </button><input type="checkbox" id="pack#num" class="pack" value="#num" title="'.msg('Create a pack with this snippet').'"/></div>';
$template['snippet']=loggedstring($template['buttons']).'<h1 class="snippet_title toggle_next #nolink #public" title="#nolink"> #titre </h1><div class="snippet_content #hidden"><pre><code class="#nolink">#contenu</code></pre><hr/><p class="tags">#tags</p><p class="infos">#adresse</p><p class="embed" title="'.msg('embed code').'">#direct_link</p><p class="infos right"><a href="'.$config['url'].'?txt=#num">'.msg('Text only').'</a> - <a href="'.$config['url'].'?snippet=#num">Permalink</a> - Snippet #public '.msg('post date').' #date</p></div>';
$template['tag_btn']='<a class="button_$1" href="index.php?tag=$1">$1</a> ';
$template['tag_cloud_link']='<a href="index.php?tag=#TAG" class="button_#TAG"><input type="checkbox" name="#TAG" class="'.$hidden.' tagcheck" #checked/>#TAG <em>#NB</em></a> ';
$template['tag_cloud_checkbox']='<input type="checkbox" id="ID_#TAG" name="check#TAG" value="#TAG" #checked/><label class="button_#TAG" for="ID_#TAG">#TAG</label>  ';
//set the private/public button status
if (isset($_GET['edit'])){
    if($snippets[$_GET['edit']]['#public']=='true'||$snippets[$_GET['edit']]['#public']==true){$checkpublic='checked';$checkprivate='';}
    if($snippets[$_GET['edit']]['#public']=='false'||$snippets[$_GET['edit']]['#public']==false){$checkpublic='';$checkprivate='checked';}
}else{ 
    if($config['default_status_private']=='false'||$config['default_status_private']==false){$checkpublic='checked';$checkprivate='';}
    if($config['default_status_private']=='true'||$config['default_status_private']==true){$checkpublic='';$checkprivate='checked';}
}
$template['snippet_frm']='<br/>
<h1 class="toggle_next add">#formtitre</h1>
<div class="add_snippet #hidden">
    <form id="add_snippet_form" method="post" action="index.php"  accept-charset="UTF-8">
        <input type="hidden" name="#num" value="#uniqid"/>
        <input type="hidden" name="from_bookmarklet" value="no"/>
        #passwordform
        <li><label for="titre">#labeltitre</label> <input type="text" name="#titre" id="titre" required value="#titre"/></li>
        <li><label for="adresse">#labeladr</label> <input type="text" name="#adresse" id="adresse"  value="#adresse"/></li>
        <li><label for="contenu">#labelcontent</label><textarea name="#contenu" id="contenu" required placeholder="#placeholder">#contenu</textarea></li>
        <li><label for="tags">#labeltags</label><input type="text" name="#tags" id="#tags" title ="'.msg('separated with spaces').'"/></li>
        <li class="tags">#tagcloud</li>
        <li><p class="tags">
                <input type="radio" id="public" name="#public" value="true" '.$checkpublic.'/><label class="button_public" for="public" title="'.msg('Acces allowed to rss and visitors').'">'.msg('Public').'</label>
                <input type="radio" id="prive" name="#public" value="false" '.$checkprivate.' /><label class="button_prive" for="prive" title="'.msg('Only admin can access').'">'.msg('Private').'</label>
            </p>
            <input type="submit" value="'.msg('Save').'"/></li>
    </form>
</div>';
$template['rss_header']='<?xml version="1.0" encoding="utf-8" ?>'.$r.'<rss version="2.0"   xmlns:content="http://purl.org/rss/1.0/modules/content/">'.$r.'<channel>'.$r.'<title><![CDATA[#titre]]></title><link>'.$config['url'].'</link>'.$r.'<description><![CDATA[Snippets]]></description>'.$r;
$template['rss_item']='<item>'.$r.'<title><![CDATA[#titre]]></title>'.$r.'<guid isPermaLink="false"><![CDATA['.$config['url'].'?snippet=#num]]></guid>'.$r.'<link><![CDATA['.$config['url'].'?snippet=#num]]></link>'.$r.'<description><![CDATA[<pre><code>#contenu</code></pre>]]></description>'.$r.'<pubDate>#rss_date</pubDate>'.$r.'</item>';
$template['rss_footer']='</channel>'.$r.'</rss>';
$template['bookmarklet_header']='<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" charset="UTF-8"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta charset="UTF-8"><link rel="shortcut icon" href="theme/'.$config['snippetvamp_theme'].'/favicon.png" /><link rel="stylesheet" type="text/css" href="theme/'.$config['snippetvamp_theme'].'/computed_snippetvamp.css?lastupdate=1365701915"  media="screen" /></head><body '.BodyClasses('bookmarklet').' >';
######################################################################


######################################################################
# cache: start
######################################################################
cache_start();
$nom_page_cache='cache'.$_SERVER['QUERY_STRING'];
if ($admin||strpos($nom_page_cache,'domaj')||strpos($nom_page_cache,'toggle=')||strpos($nom_page_cache,'cache_clear')||strpos($nom_page_cache,'edit=')||!$contenu=cache_read($nom_page_cache)){
######################################################################




######################################################################
# GET DATA
######################################################################

if (isset($_GET['from'])){$from=$_GET['from'];}else{$from=0;}
if ($_GET){
    # RSS feeds
    if (isset($_GET['tag'])&&isset($_GET['rss'])){
        $tag=$_GET['tag'];
        echo make_rss(return_matching($tag,'#tags'),'Snippets: '.$tag);
        $contenu=cache_end($nom_page_cache,0);
        exit($contenu);
    }
    if (isset($_GET['search'])&&isset($_GET['rss'])){
        $tag=$_GET['search'];
        echo make_rss(return_matching($tag),'Snippets: '.$tag);
        $contenu=cache_end($nom_page_cache,0);
        exit($contenu);
    }
    if (isset($_GET['rss'])){
        $s=array_slice($snippets, -$config['nb_snippets_rss']);header("Content-Type: application/rss+xml");
        echo make_rss($s,msg('last'));
        $contenu=cache_end($nom_page_cache,0);
        exit($contenu);
    }

    # Users commands (with private filtering)
    if (isset($_GET['from'])){$from=$_GET['from'];}else{$from=0;}
    if (isset($_GET['tag'])){$tag=$_GET['tag'];$page=search($tag,'#tags',$from);}
    if (isset($_GET['search'])){$page=search($_GET['search'],false,$from);$tag=msg('search').':'.$_GET['search'];}
    if (isset($_GET['snippet'])&&is_public($_GET['snippet'])||isset($_GET['snippet'])&&$admin){$page=templatise_snippet($snippets[$_GET['snippet']],'snippet','');$tag=$snippets[$_GET['snippet']]['#titre'];}
    if (isset($_GET['txt'])&&is_public($_GET['txt'])||isset($_GET['txt'])&&$admin){
        if (isset($_GET['pre'])){$pre1='<pre>';$pre2='</pre>';}else{$pre1=$pre2='';}
        if (strstr($_GET['txt'],'_')){$nbspack=explode('_',$_GET['txt'],-1);}else{$nbspack=array($_GET['txt']);}
        $pack='';
        foreach ($nbspack as $nbpack){
            if ($admin&&isset($snippets[$nbpack])||isset($snippets[$nbpack])&&is_public($nbpack)){
                $pack.='#'.$snippets[$nbpack]['#titre']."\n".'#'.$snippets[$nbpack]['#adresse']."\n\n".$snippets[$nbpack]['#contenu']."\n\n";
            }
        }

        exit('<html><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"></head><body>'.$pre1.htmlspecialchars($pack).$pre2.'</body></html>');
    }   
    if (isset($_GET['embed'])){ 
        if (isset($snippets[$_GET['embed']])&&is_public($_GET['embed'])){   
            echo '<link rel="stylesheet" href="styles/'.$config['highlight_embed_theme'].'.css"> 
            <script type="text/javascript" src="highlight.js"></script><script>hljs.initHighlightingOnLoad();</script>';
            echo templatise_snippet($snippets[$_GET['embed']],'embeded_snippet');
            $contenu=cache_end($nom_page_cache,0);
            exit($contenu);
        }else{
            exit(msg('no Snippet'));
        }
    }
    if (isset($_GET['bookmarklet'])){
        // try to parse page & creates the form
        $_GET['bookmarklet']=urldecode($_GET['bookmarklet']);
        $url=add_protocol($_GET['bookmarklet']);
        $code_blocs=parse_for_snippet($url);$snippet='';
        if($admin){$passwordform='';}else{$passwordform='<li><input type="password" title="'.msg('password').'" name="pass" required/>';}
        if (!isset($code_blocs[0])){$placeholder=msg('Copy/paste the snippet here (snippetvamp was unable to find a snippet: no code or pre tag)');}else{$placeholder='Snippet';}
        if ($code_blocs!==false){foreach($code_blocs as $key=>$code){if ($key!=='title'){$snippet.=$code."\n\n";}}}
        $form=form_bookmarklet($code_blocs['title'],$url,$snippet,$placeholder,$passwordform);
        exit($template['bookmarklet_header'].$form.'</body></html>');
    }
    # Admin commands
    if ($admin&&isset($_GET['suppr'])&&isset($snippets[$_GET['suppr']])){inlog('Delete snippet N°'.$_GET['suppr']);unset($snippets[$_GET['suppr']]);save();reload_page($_GET['vars']);}   
    if ($admin&&isset($_GET['edit'])&&isset($snippets[$_GET['edit']])){$form=form($_GET['edit']);}
    if ($admin&&isset($_GET['toggle'])&&isset($snippets[$_GET['toggle']])){inlog('Change status of snippet N° <a href="?snippet='.$_GET['toggle'].'">'.$_GET['toggle'].'</a>');toggle_public($_GET['toggle']);save();reload_page($_GET['vars']);}   
    if ($admin&&isset($_GET['cache_clear'])){cache_clear();reload_page($_GET['vars']);} 
    if ($admin&&isset($_GET['config'])){$tag=msg('Configuration');$page.=form_config().'<br/><h1 class="titre">'.msg('snippetvamp files').'</h1>'.backup_link().form_import_file().form_replace_file().log_link().restore_sv_link();} 
    if ($admin&&isset($_GET['log'])){$tag=msg('Log file content');$page.='<a class="button" href="?clearlog">'.msg('clear log file').'</a><pre class="logfile">'.@file_get_contents($config['log_filename']).'</pre>';} 
    if ($admin&&isset($_GET['clearlog'])){@unlink($config['log_filename']);inlog('log cleared...');reload_page('');} 
    # update 
    if ($admin&&isset($_GET['domaj'])){$tag=msg('SnippetVamp Update');$page.=maj_auto();}
    if ($admin&&isset($_GET['restore'])){$tag=msg('Restoring last version');
        if (is_file('index.php')&&is_file('old_index.php')){
            unlink('index.php');@unlink('last_version.txt');rename('old_index.php','index.php');
            $page.=info(msg('previous installed version restored, new one deleted'));inlog('Restoring previous SnippetVamp version');
        }else{
            $page.=info(msg('There\'s no previous version'));
        }
        
    }
    
}


######################################################################
# if no tags or search query specified: last snippets
######################################################################
if (!isset($tag)){
    if($config['home_msg_textarea']&&!$admin){$page.='<p class="home_msg">'.nl2br($config['home_msg_textarea']).'</p>';}
    $tag=msg('last');$s=array_reverse($snippets);$results=array();
    if (!$admin){foreach ($s as $snippet){if (isset($snippet['#num']) && is_public($snippet['#num'])){$results[$snippet['#num']]=$snippet;}}}else{$results=$s;}
    $results=array_slice($results,$from,$config['nb_snippets_homepage'],true);
    foreach($results as $snippet){if (isset($snippet['#num'])){$page.=templatise_snippet($snippet);}}
    $page.='<p class="pagination">'.paginate($from,count($snippets),'').'</p>';
}

######################################################################
# Adding the admin new snippet form
######################################################################
if (!isset($form)){$form=form();}
if (!isset($_GET['config'])&&!isset($_GET['log'])){$page=$form.$page;}

# End ################################################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" charset="UTF-8">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="UTF-8">

    <title><?php e('app_name').' '.$tag;?></title>
    <link rel="shortcut icon" href="theme/<?php echo $config['snippetvamp_theme'];?>/favicon.png" />
    <link rel="stylesheet" type="text/css" href="theme/<?php echo $config['snippetvamp_theme'];?>/computed_snippetvamp.css?lastupdate=1365701915"  media="screen" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php feed_link(true); ?>" />

    <!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->
</head>

<body <?php echo BodyClasses(); ?> >
    <header> </header>
    <nav>
        <div class="logo"></div>
        
        <h1><a href="index.php" title="<?php echo msg('last'); ?>"><?php e('app_name'); ?> </a></h1>

        <p class="description"><?php e('app_description'); ?></p>
        <hr/>
        <?php conn_deconn();// please, french reader: don't laugth ! ^^?>
        <hr/>
        
        <div class="recherche" >
            <button class="hidden pack"><?php echo msg('Pack selected snippets');?></button>
            <form name="cherche" action="index.php" method="get">
                <input type="text" placeholder="<?php echo msg('search');?>" name="search"/>
            </form>
        </div>
        <div class="tag_cloud">
            <input type="checkbox" id="multiselect" class="<?php echo $multiselect_button_state; ?>"/>
            <label for="multiselect" class="multiselect <?php echo $multiselect_button_state; ?>"  title="<?php echo msg('click to enable multi tag selection'); ?>"><?php echo msg('multiselect tag'); ?></label>
            <button href="" class="<?php echo $hidden; ?> filter"><?php echo msg('filter by tags'); ?></button>
            <?php echo tag_cloud('tag_cloud_link',$config['sort_tags_by_nb']);?> 
            <hr class="hidden"/>
            
        </div>
        <hr/>
        <?php if ($admin){echo '<div class="bookmarklet_link"> '.$template['bookmarklet'].'</div>';} ?>
    </nav>
    <aside>
        <div class="margin">.</div>
        <div class="corps">
            <h1 class="titre"><?php echo map_entities($tag); ?></h1>
            <?php if ($config['allow_public_access']||$admin){echo $page;}else{echo msg('The public access is locked');} ?>
            
        </div>
    </aside>
    
<?php 
#*************************************************************
#Cache: end (we keep the the generation time out)

if (!$admin){$contenu=cache_end($nom_page_cache,0);}
}
if (isset($_GET['embed'])){exit($contenu);}// Don't add the footer to an embedded snippet
else if (isset($_GET['rss'])){header("Content-Type: application/rss+xml");exit($contenu);} // send correct header and don't add footer to rss feed
else{echo $contenu;}
#*************************************************************
?>
<div style="clear:both"> </div>
        <footer>
            <?php feed_link(); ?><hr/><?php echo config_link().'<em><a href="https://github.com/broncowdd/SnippetVamp" title="'.msg('fork SnippetVamp on github').'">'.$config['app_name'].' '.$config['version'].'</a></em> '.msg('by');?> <a href="http://warriordudimanche.net">Bronco</a> - <?php echo msg('generated in');echo ' ',round(temps()-$start,3);?> s
            <br/><?php echo alert_last_version_if_necessary() ; ?>
        </footer>

<script src="jquip.min.js"></script>
<?php if (file_exists('highlight.js')){ ?> <link rel="stylesheet" href="styles/<?php e('highlight_theme'); ?>.css"> <script src="highlight.js"></script><script>hljs.initHighlightingOnLoad();</script>  <?php } ?>
<script>
    $(function() {
        //$('.logo').click(function(){$(this).parent().hide();});
        $(".toggle_next").click(function(){ $(this).next().toggle();return false;}); 
        $("button.edit").click(function(){document.location.href="index.php?edit="+$(this).attr('data');return false;});
        $("button.txt").click(function(){document.location.href="index.php?txt="+$(this).attr('data')+"&pre=ok";return false;});
        $("button.suppr").click(function(){if(confirm('<?php echo msg("delete this snippet ? ");?>')){document.location.href="index.php?suppr="+$(this).attr('data');}else{return false;}});
        $("button.toggle").click(function(){if(confirm('<?php echo msg("change the public/private status ?");?>')){document.location.href="index.php?toggle="+$(this).attr('data');}else{return false;}});
        $(".multiselect").click(function(){$('.tag_cloud .hidden').toggle();});
        $(".filter").click(function(){
            tags='<?php echo $config['url']; ?>?tag=';
            $(".tag_cloud a .tagcheck").each(function(){
                if ($(this).attr('checked')==true){tags=tags+$(this).attr('name')+'+';}
            });
            tags=tags.substring(0,tags.length-1);
            document.location.href=tags;
            return false;
        });
        $("#import_file").change(function(){$('.submit_import').click();});
        $("#replace_file").change(function(){$('.submit_replace').click();});
        $("input[type=button].backup").click(function(){document.location.href="<?php echo $config['data_file'];?>";});
        $("input.pack").click(function(){ // shows/hide pack button
            flag=false;
            $.each($("input.pack"),function(){
                if ($(this).attr("checked")){flag=true;}
            });
            if (flag==true){$("button.pack").show(200);}else{$("button.pack").hide(200);}
        });
        $("button.pack").click(function(){ 
            nbs="";$.each($("input.pack"),function(){if ($(this).attr("checked")){nbs+=$(this).attr("value")+'_';}});
            document.location.href="index.php?txt="+nbs+"&pre";
        });
        
    });

    document.querySelector("textarea").addEventListener('keydown',function(e) {
        if(e.keyCode === 9) { // tab was pressed
            // get caret position/selection
            var start = this.selectionStart;
            var end = this.selectionEnd;

            var target = e.target;
            var value = target.value;

            // set textarea value to: text before caret + tab + text after caret
            target.value = value.substring(0, start)
                        + "\t"
                        + value.substring(end);

            // put caret at right position again (add one for the tab)
            this.selectionStart = this.selectionEnd = start + 1;

            // prevent the focus lose
            e.preventDefault();
        }
    },false);
</script>
</body> 
</html>
