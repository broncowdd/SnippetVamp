<?php
/*
 	@app_name: SnippetVamp
	@author: bronco@warriordudimanche.net
	@web : http://warriordudimanche.net (FR)
	@License: open source, free to download & fork ^^
	@languages: French/Spanish and English 
	@apoligizes: please forget about my english (learned from american & british series ;-) 
	@status: alpha
*/

$start=temps();
session_start();
//aff($_SERVER);
// Remove that form the final version
function aff($a,$stop=true){echo 'Arret a la ligne '.__LINE__.' du fichier '.__FILE__.'<pre>';var_dump($a);if ($stop){exit();}}
if (file_exists('theme/auto_css.php')){include('theme/auto_css.php'); } // use auto_css if present 
######################################################################
# Initialisations
######################################################################
# langue 
######################################################################
$msg=array();
$msg['fr']=array(
	'embed code'=>'Code d\intégration',
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
	'Del'=>'Supprimer',
	'saved'=>'Snippet sauvegardé',
	'Error'=>'Erreur en sauvegardant le fichier dat !',
	'last'=>'Derniers snippets',
	'embeded with SnippetVamp'=>'Fourni par SnippetVamp',
	'multiselect tag'=>'Sélection multiple',
	'filter by tags'=>'Filtrer par tags',
	'click to enable multi tag selection'=>'Cliquer pour activer la multi sélection de tags',
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
		'version'=>'alpha 0.7', 
		'sort_tags_by_nb'=>false,
		'multiple_tag_selection'=>false,
		'nb_snippets_homepage'=>30,
		'nb_snippets_rss'=>30,
		'url'=>'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'],
		'lang'=>'en', 
		'default_status_private'=>true, // by default, every snippet private status is 'on'
		'data_file'=>'snippetvamp.dat', // data filename: change it to secure
		'encryption_key'=>'warriordudimanche.net',// The key to encrypt
		'session_expiration_delay'=>20,//minutes
		'highlight_theme'=>'default',
		'highlight_embed_theme'=>'shCoreRDark',

	);
	store('config.dat',$config);
}else{
	$config=unstore('config.dat');
	if ($config['default_status_private']=='false'){$config['default_status_private']=false;}else{$config['default_status_private']=true;}
}

# data file 
######################################################################
if (!file_exists($config['data_file'])){$snippets=array();store($config['data_file'],$snippets);}
$snippets=load();$page='';
# pass file
######################################################################
if(!file_exists('pass.php')){
	if(isset($_POST['pass'])){ // handle pass creation
		if ($_POST['pass']==$_POST['pass2']&&$_POST["login"]){
			$salt = md5(uniqid('', true));
			file_put_contents('pass.php', '<?php $config["login"] = "'.$_POST["login"].'"; $config["salt"] = '.var_export($salt,true).'; $config["pass"] = '.var_export(hash('sha512', $salt.$_POST['pass']),true).'; ?>');
		}else{ exit(msg('error'));}
	}
	else{ //pass creation form
		exit ('<form style="border-radius:4px; margin:10px; padding:10px;display:block;margin:auto;width:200px;background-color:#DDD;border:1px solid black; box-shadow:0 1px 2px black; text-shadow:0 1px -1px white;" action="#" method="POST">'.$config['app_name'].'<hr/>'.msg('choose your id & pass').'<input type="text" name="login" placeholder="'.msg('login').'"/><input type="password" name="pass" placeholder="'.msg('password').'"/><input type="password" name="pass2" placeholder="'.msg('confirm').'"/><input type="submit" value="Ok"/></form>');
	}
}else{include('pass.php');}

# misc vars
######################################################################
$contenu='';


######################################################################
# OTHER POST DATA 
######################################################################
# admin login/deco
######################################################################
if (isset($_POST['login'])&&isset($_POST['pass'])){log_user($_POST['login'],$_POST['pass']);}
$admin=is_ok();
if (isset($_POST['exit'])){log_user("I'm","out");}
# config change
######################################################################
if ($admin&&isset($_POST['app_name'])){
	if ($config['data_file']!=$_POST['data_file']){rename ($config['data_file'],$_POST['data_file']);} // rename if .dat filename has changed
	foreach($_POST as $key=>$value){ // change 'true' by true & secure
		if ($value=='true'){$config[$key]=true;}
		else if ($value=='false'){$config[$key]=false;}
		else {$config[$key]=htmlentities($_POST[$key]);}
	}
	store('config.dat',$config);
}
# add/edit snippets
######################################################################
if ($admin&&isset($_POST['#num'])){
	foreach($_POST as $cle=>$valeur){
		if (substr($cle,0,5)!='check'){	$snippets[$_POST['#num']][$cle]=$valeur;}else {if (!stripos(' '.$snippets[$_POST['#num']]['#tags'],$valeur)){$snippets[$_POST['#num']]['#tags'].=' '.$valeur;}}
	}
	$snippets[$_POST['#num']]['#tags']=trim($snippets[$_POST['#num']]['#tags']);
	$snippets[$_POST['#num']]['#date']=@date('d/m/Y');
	save();$page= success('saved');
}

######################################################################
# core functions
######################################################################
# 2 functions from IdleMan http://blog.idleman.fr/?p=1722 (Thx bro' )
function store($file,$datas){file_put_contents($file,gzdeflate(json_encode($datas)));}
function unstore($file){return json_decode(gzinflate(file_get_contents($file)),true);}
# Security
function GenerationCle($Texte,$CleDEncryptage){ $CleDEncryptage = md5($CleDEncryptage); $Compteur=0; $VariableTemp = ""; for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) {if ($Compteur==strlen($CleDEncryptage)){ $Compteur=0; }$VariableTemp.= substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1); $Compteur++; } return $VariableTemp; }
function Crypte($Texte,$Cle) { srand((double)microtime()*1000000); $CleDEncryptage = md5(rand(0,32000) ); $Compteur=0; $VariableTemp = ""; for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++) { if ($Compteur==strlen($CleDEncryptage)) $Compteur=0; $VariableTemp.= substr($CleDEncryptage,$Compteur,1).(substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1) ); $Compteur++;} return base64_encode(GenerationCle($VariableTemp,$Cle) );}
function Decrypte($Texte,$Cle){$Texte = GenerationCle(base64_decode($Texte),$Cle);$VariableTemp = "";for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++){$md5 = substr($Texte,$Ctr,1);$Ctr++;$VariableTemp.= (substr($Texte,$Ctr,1) ^ $md5);} return $VariableTemp;}	  
function id_user(){$id=array();$id['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];$id['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];$id['session_id']=session_id();$id=serialize($id);return $id;}
function is_ok(){global $config;$expired=false;if (!isset($_SESSION['id_user'])){return false;}if ($_SESSION['expire']<time()){$expired=true;}$sid=Decrypte($_SESSION['id_user'],$config['encryption_key']);$id=id_user();if ($sid!=$id || $expired==true){return false;}else{$_SESSION['expire']=time()+(60*$config['session_expiration_delay']);return true;}	}
function log_user($login_donne,$pass_donne){global $config;if ($config['login']==$login_donne && $config['pass']==hash('sha512', $config["salt"].$pass_donne)){	$_SESSION['id_user']=Crypte(id_user(),$config['encryption_key']);$_SESSION['login']=$config['login'];	$_SESSION['expire']=time()+(60*$config['session_expiration_delay']);return true;}else{exit_redirect();return false;}}
function exit_redirect(){@session_unset();@session_destroy();reload_page();}
function is_public($id_nb,$returnbool=true){global $snippets;if ($snippets[$id_nb]['#public']=='true'||$snippets[$id_nb]['#public']===true){if ($returnbool==true){return true;}else{return ' public ';}}else{if ($returnbool==true){return false;}else{return ' prive ';}} }
function loggedstring($tpl=''){if (is_ok()){return $tpl;}else{return '';}}
function conn_deconn(){global $template; if (!is_ok()){echo $template['connect_form'];}else{echo $template['deconnect_button'];}}
function map_entities($chaine){return htmlentities($chaine, ENT_QUOTES, 'UTF-8');}
# Content
function save(){cache_clear();global $config,$snippets;$snippets['tag_list']=list_tags();if (!store($config['data_file'],$snippets)){return alert('Error');}else{return success('saved');}}
function load(){global $config;return unstore($config['data_file']);}
function toggle_public($nb){global $snippets;if (!isset($snippets[$nb])){return false;}if ($snippets[$nb]['#public']=='true'||$snippets[$nb]['#public']===true){$snippets[$nb]['#public']=false;}else{$snippets[$nb]['#public']=true;}}
function templatise_snippet($snippet,$tpl='snippet'){global $template,$config;if (!isset($snippet['#tags'])||!isset($snippet['#num'])||!isset($snippet['#adresse'])){return false;}$snippet['#public']=is_public($snippet['#num'],false);if($snippet['#public']==' public '){$snippet['#direct_link']=str_replace(array('#num','#height'),array($snippet['#num'], embed_height($snippet['#contenu'])),$template['embed_code']);}else{$snippet['#direct_link']='';}$snippet=secure($snippet);$snippet['#nolink']=$snippet['#tags'];if ($snippet['#adresse']!=''){$snippet['#adresse']='<a class="adr" href="'.$snippet['#adresse'].'" >'.$snippet['#adresse'].'</a>';};$snippet['#tags']=preg_replace('#([^ ]+)#',$template['tag_btn'],$snippet['#tags']);$snippet['#origine']=$_SERVER['QUERY_STRING'];return str_replace(array_keys($snippet),array_values($snippet),$template[$tpl])."\n";}
function list_tags(){global $snippets;$tags=array();foreach($snippets as $snippet){if (isset($snippet['#tags'])){$t=explode(' ',trim($snippet['#tags']));foreach ($t as $tag){$tag=trim($tag);if(!isset($tags[$tag])){$tags[$tag]=1;}else{$tags[$tag]++;}}}} ksort($tags);unset($tags['']);return $tags;}
function tag_cloud($templ='tag_cloud_link',$sortbynb=false,$tags_checked=false){
	global $snippets,$template;
	$tag_cloud='';
	if (!isset($snippets['tag_list'])){return false;} 
	if ($sortbynb){arsort($snippets['tag_list']);} 
	foreach($snippets['tag_list'] as $tag=>$nb){
		$t=str_replace('#TAG',$tag,$template[$templ]);
		$t=str_replace('#NB',$nb,$t); 
		if ($tags_checked && stripos($tags_checked,$tag)!==false || !$tags_checked && stripos($_SERVER['QUERY_STRING'],$tag) ){
			$t=str_replace('#checked','checked',$t); 
		}else{
			$t=str_replace('#checked','',$t);
		}
		$tag_cloud.= $t;
	}return $tag_cloud;
}
function make_rss($array,$titre){global $template,$config;if(isset($_POST['config'])){return false;}  echo str_replace('#titre',$config['app_name'].' '.$config['login'].': '.$titre,$template['rss_header']); foreach($array as $a){	if (isset($a['#num'])&&is_public($a['#num'])){ 		array_map('map_entities',$a);echo str_replace(array_keys($a),array_values($a),$template['rss_item']); }} echo $template['rss_footer'];}
function form($num=false){if (!is_ok()){return '';} global $config,$template,$snippets;$repl=array();$repl['#labeltags']=msg('Tags');$repl['#labeltitre']=msg('Title');$repl['labeladr']=msg('Website');$repl['#labelcontent']=msg('Content');if (!$num){$repl['#uniqid']=uniqid();	$repl['#formtitre']=msg('Add a snippet');$repl['#tagcloud']=tag_cloud('tag_cloud_checkbox',$config['sort_tags_by_nb']);$repl['value="#titre"']='value=""';$repl['value="#adresse"']='value=""';$repl['#contenu</textarea>']='</textarea>';$repl['#hidden']='hidden';return str_replace(array_keys($repl),array_values($repl),$template['snippet_frm']);}else{if (isset($snippets[$num])){$repl['#uniqid']=$num;$repl['#formtitre']=msg('Edit a snippet');	$repl['#tagcloud']=tag_cloud('tag_cloud_checkbox',$config['sort_tags_by_nb'],$snippets[$num]['#tags']);$repl['value="#titre"']='value="'.$snippets[$num]['#titre'].'"';$repl['value="#adresse"']='value="'.$snippets[$num]['#adresse'].'"';$repl['#contenu</textarea>']=$snippets[$num]['#contenu'].'</textarea>';$repl['#hidden']='';return str_replace(array_keys($repl),array_values($repl),$template['snippet_frm']);}else{return false;}}}
function form_config(){global $config;$form='';$form.=  '<form name="config" action="" method="post" class="">';foreach ($config as $cle=>$val){if ($cle!='login'&&$cle!='pass'&&$cle!='salt'&&$cle!='encryption_key'){$form.= '<label for="'.$cle.'">'.msg($cle).'</label>';if (is_bool($val)||$val=='true'||$val=='false'){if ($val==true){$val='true';}else{	$val='false';}$form.='<select id="'.$cle.'" name="'.$cle.'"><option value="'.$val.'">'.msg($val).'</option><option value="true">'.msg('true').'</option><option value="false">'.msg('false').'</option></select>';}else{$form.= '<input type="text" name="'.$cle.'" value="'.$val.'"/>';}}}	$form.='<input type="submit" value="'.msg('Save').'"/></form>';	return $form;}
function feed_link(){if (stripos($_SERVER['QUERY_STRING'],'config=')===false&&stripos($_SERVER['QUERY_STRING'],'txt=')===false){global $config;echo '<p class="rss"><a href="'.$config['url'].'?rss=on&'.$_SERVER['QUERY_STRING'].'">'.msg("This page's Feed").'</a></p>';}}
function config_link(){if (stripos($_SERVER['QUERY_STRING'],'config=')===false&&is_ok()){echo'<a class="config" href="?config=true">'.msg('Configuration').'</a> - ';}}
function are_values_in_string($array,$string,$all=true){$found=0;foreach($array as $val){if (stripos($string, $val)!==false){$found++;}}if ($all && $found==count($array) || !$all && $found>0){return true;}else{return false;}}
function search($chaine,$cle=false){
	global $snippets,$template;	
	$chaine=str_replace(' ','+',$chaine);
	$chaine=explode('+',$chaine);
	$nb_words=count($chaine);
	$list='';$counter=0;$admin=is_ok();
	
	foreach($snippets as $snippet){	
		if ($admin || isset($snippet['#num']) && is_public($snippet['#num'])){ // access allowed
			if (!$cle && are_values_in_string($chaine,implode(' ',$snippet))!==false || $cle!==false && isset($snippet[$cle]) && are_values_in_string($chaine,$snippet[$cle])!==false){ 
				$list.= templatise_snippet($snippet);$counter++;
			}
		}
	}
	if ($list!=''){return $list;}else{return false;}
}
function return_if($return_value,$truefalse){if ($truefalse){return $return_value;}else{return '';}}
function msg($m){global $msg,$config;if(isset($msg[$config['lang']][$m])){return $msg[$config['lang']][$m];}else{return $m;}}
function alert($txt){return '<p class="alert">'.msg($txt).'</p>';}
function info($txt){return '<p class="info">'.msg($txt).'</p>';}
function success($txt){return '<p class="success">'.msg($txt).'</p>';}
function e($conf_index){global $config;	if (isset($config[$conf_index])){echo $config[$conf_index];}else{return false;}}
function BodyClasses(){$regex='#(msie)[/ ]([0-9])+|(firefox)/([0-9])+|(chrome)/([0-9])+|(opera)/([0-9]+)|(safari)/([0-9]+)|(android)|(iphone)|(ipad)|(blackberry)|(Windows Phone)|(symbian)|(mobile)|(bada])#i';preg_match($regex,$_SERVER['HTTP_USER_AGENT'],$resultat);echo ' class="'.preg_replace('#([a-zA-Z ]+)[ /]([0-9]+)#','$1 $1$2',$resultat[0]).' '.basename($_SERVER['PHP_SELF'],'.php').'" ';}
# Cache
function cache_temp_folder(){if (!is_dir('temp/')){mkdir ('temp');}}
function cache_read($fichier){cache_temp_folder();if (file_exists('temp/'.$fichier)&&!cache_is_obsolete($fichier)){$donnees=file_get_contents('temp/'.$fichier);if ($donnees2=@unserialize($donnees)){$donnees=$donnees2;}   return $donnees; }else{return false;}}
function cache_write($fichier,$donnees,$duree){cache_temp_folder();file_put_contents('temp/'.$fichier,$donnees);if ($duree!=0){$duree=@date('U')+(60*$duree);}touch('temp/'.$fichier,$duree);}
function cache_clear(){cache_temp_folder();$fs=glob('temp/*'); if(!empty($fs)){foreach ($fs as $file){unlink ($file);}}
function cache_is_obsolete($fichier){$dat=@filemtime('temp/'.$fichier);if (!file_exists('temp/'.$fichier)){return true;}if ($dat==0){return false;}if ($dat<@date('U')){cache_delete($fichier);return true;}return false;}
function cache_delete($fichier){if (file_exists('temp/'.$fichier)){unlink ('temp/'.$fichier);}}
function cache_start(){ob_start();}
function cache_end($fichier,$duree){$donnees=ob_get_clean();cache_write($fichier,$donnees,$duree);return $donnees;}
# Misc
function secure($array){return array_map('map_entities',$array);}
function return_matching($chaine,$cle=false){$resultats=array();global $snippets;	foreach($snippets as $snippet){if (!$cle){$is_in=stripos(implode(' ',$snippet),$chaine);}	if (!$cle&&$is_in>-1||$cle&&isset($snippet[$cle])&&stripos($snippet[$cle],$chaine)>-1){$resultats[$snippet['#num']]= $snippet;}} return $resultats;}
function reload_page($query=''){if ($query==''){$query=$_SERVER['QUERY_STRING'];}header('Location: snippetvamp.php?'.$query);}
function temps(){$t=microtime();$tt=explode(' ',$t);return $tt[0]+$tt[1];}
function embed_height($string){return (substr_count($string, "\n")*18)+140; }

######################################################################
# Templates
######################################################################
$hidden=return_if('hidden',!$config['multiple_tag_selection']); 
$multiselect_button_state=return_if('hidden',$config['multiple_tag_selection']);

$template=array();
$template['deconnect_button']='<form action="" method="POST" class="deconnect"><input name="exit" type="hidden" value=""/><input type="submit" value="'.$config['login'].':'.msg('disconnect').'" class="exit"/></form>';
$template['connect_form']='<form action="" method="POST" class="login"><input name="login" type="text" placeholder="'.msg('login').'"/><input name="pass" type="password" title="'.msg('password').'"/><input type="submit" value="ok"/></form>';
$template['embed_code']='<iframe width="100%" height="#height" src="'.$config['url'].'?embed=#num" type="text/html"></iframe>';
$template['embeded_snippet']='<h3>#titre</h3><pre><code class="#nolink">#contenu</code></pre><p class="snippetcopyright">#adresse '.msg('embeded with SnippetVamp').'</p>';
$template['buttons']='<div class="buttons nomobile "><button class="suppr" data="#num&vars=#origine" title="'.msg('Del').'"> </button><button class="#public toggle" data="#num&vars=#origine" title="'.msg('access: ').'#public '.msg('(click to change)').'"> </button><button class="edit" data="#num" title="'.msg('Edit').'"> </button></div>';
$template['snippet']=loggedstring($template['buttons']).'<h1 class="snippet_title toggle_next #nolink #public" title="#nolink"> #titre </h1><div class="snippet_content hidden"><pre><code class="#nolink">#contenu</code></pre><hr/><p class="tags">#tags</p><p class="infos">#adresse</p><p class="embed" title="'.msg('embed code').'">#direct_link</p><p class="infos right">Snippet #public '.msg('post date').' #date</p></div>';
$template['tag_btn']='<a class="button_$1" href="snippetvamp.php?tag=$1">$1</a> ';
$template['tag_cloud_link']='<a href="snippetvamp.php?tag=#TAG" class="button_#TAG"><input type="checkbox" name="#TAG" class="'.$hidden.' tagcheck" #checked/>#TAG <em>#NB</em></a> ';
$template['tag_cloud_checkbox']='<input type="checkbox" id="ID_#TAG" name="check#TAG" value="#TAG" #checked/><label class="button_#TAG" for="ID_#TAG">#TAG</label>  ';
if (isset($_GET['edit'])){$checkpublic=return_if('checked',$snippets[$_GET['edit']]['#public']==true);$checkprivate=return_if('checked',$snippets[$_GET['edit']]['#public']==true);}
else{$checkpublic=return_if('checked',$config['default_status_private']==false);$checkprivate=return_if('checked',$config['default_status_private']==true);}
$template['snippet_frm']='<br/>
<h1 class="toggle_next add">#formtitre</h1>
<div class="add_snippet #hidden">
	<form id="add_snippet_form" method="post" action="snippetvamp.php"  accept-charset="UTF-8">
		<input type="hidden" name="#num" value="#uniqid"/>
		<li><label for="titre">#labeltitre</label> <input type="text" name="#titre" id="titre" required value="#titre"/></li>
		<li><label for="adresse">#labeladr</label> <input type="text" name="#adresse" id="adresse"  value="#adresse"/></li>
		<li><label for="contenu">#labelcontent</label><textarea type="text" name="#contenu" id="contenu" required>#contenu</textarea></li>
		<li><label for="tags">#labeltags</label><input type="text" name="#tags" id="#tags" title ="'.msg('separated with spaces').'"/></li>
		<li class="tags">#tagcloud</li>
		<li><p class="tags">
				<input type="radio" id="public" name="#public" value="true" '.$checkpublic.'/><label class="button_public" for="public" title="'.msg('Acces allowed to rss and visitors').'">'.msg('Public').'</label>
				<input type="radio" id="prive" name="#public" value="false" '.$checkprivate.' /><label class="button_prive" for="prive" title="'.msg('Only admin can access').'">'.msg('Private').'</label>
			</p>
			<input type="submit" value="'.msg('Save').'"/></li>
	</form>
</div>';
$template['rss_header']='<?xml version="1.0" encoding="utf-8" ?><rss version="2.0"><channel><title>#titre</title><link>'.$config['url'].'</link><description>Snippets</description>';
$template['rss_item']='<item><title>#titre</title><link>'.$config['url'].'?txt=#num</link><description><![CDATA[<pre><code>#contenu</code></pre>]]></description><pubDate>#date</pubDate></item>';
$template['rss_footer']='</channel></rss>';
######################################################################


######################################################################
# cache: start
######################################################################
cache_start();
$nom_page_cache='cache'.$_SERVER['QUERY_STRING'];
if ($admin||strpos($nom_page_cache,'toggle=')||strpos($nom_page_cache,'edit=')||!$contenu=cache_read($nom_page_cache)){
######################################################################




######################################################################
# GET DATA
######################################################################
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
	if (isset($_GET['tag'])){$tag=$_GET['tag'];$page=search($tag,'#tags');}
	if (isset($_GET['search'])){$page=search($_GET['search']);$tag=msg('search').':'.$_GET['search'];}
	if ($admin&&isset($_GET['txt'])&&isset($snippets[$_GET['txt']])||isset($_GET['txt'])&&isset($snippets[$_GET['txt']])&&is_public($_GET['txt'])){$page='<pre>'.htmlspecialchars($snippets[$_GET['txt']]['#contenu']).'</pre>';$tag=$snippets[$_GET['txt']]['#titre'].' ('.msg('text only').')';}	
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
	# Admin commands
	if ($admin&&isset($_GET['suppr'])&&isset($snippets[$_GET['suppr']])){unset($snippets[$_GET['suppr']]);save();reload_page($_GET['vars']);}	
	if ($admin&&isset($_GET['edit'])&&isset($snippets[$_GET['edit']])){$form=form($_GET['edit']);}
	if ($admin&&isset($_GET['toggle'])&&isset($snippets[$_GET['toggle']])){toggle_public($_GET['toggle']);save();reload_page($_GET['vars']);}	
	if ($admin&&isset($_GET['config'])){$tag=msg('Configuration');$page=form_config();}	
}


######################################################################
# if no tags or search query specified: last snippets
######################################################################
if (!isset($tag)){
	$tag=msg('last');$counter=0;
	$s=array_reverse($snippets);
	foreach($s as $snippet){
		if (isset($snippet['#num'])&&is_public($snippet['#num'])){
			$page.=templatise_snippet($snippet);$counter++;
		}
		if ($counter==$config['nb_snippets_homepage']){break;}
	}
}

######################################################################
# Adding the admin new snippet form
######################################################################
if (!isset($form)){$form=form();}
if (!isset($_GET['config'])){$page=$form.$page;}

# End ################################################################
?>
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" charset="UTF-8">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="UTF-8">
	<title><?php e('app_name').' '.$tag;?></title>
	<link rel="shortcut icon" href="theme/favicon.png" />
	<link rel="stylesheet" type="text/css" href="theme/computed_snippetvamp.css?lastupdate=1365701915"  media="screen" />
	<!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->
</head>

<body <?php BodyClasses(); ?> >
	<header> </header>
	<nav>
		<div class="logo"></div>
		
		<h1><a href="snippetvamp.php" title="<?php echo msg('last'); ?>"><?php e('app_name'); ?> </a></h1>

		<p class="description"><?php e('app_description'); ?></p>
		<hr/>
		<?php conn_deconn();// please, french reader: don't laugth ! ^^?>
		<hr/>
		<div class="recherche" ><form name="cherche" action="snippetvamp.php" method="get"><input type="text" placeholder="<?php echo msg('search');?>" name="search"/></form></div>
		<div class="tag_cloud">
			<input type="checkbox" id="multiselect" class="<?php echo $multiselect_button_state; ?>"/>
			<label for="multiselect" class="multiselect <?php echo $multiselect_button_state; ?>"  title="<?php echo msg('click to enable multi tag selection'); ?>"><?php echo msg('multiselect tag'); ?></label>
			<button href="" class="<?php echo $hidden; ?> filter"><?php echo msg('filter by tags'); ?></button>
			<?php echo tag_cloud('tag_cloud_link',$config['sort_tags_by_nb']);?> 
			<hr class="hidden"/>
			
		</div>
	</nav>
	<aside>
		<div class="margin">.</div>
		<div class="corps">
			<h1 class="titre"><?php echo htmlentities($tag); ?></h1>
			<?php echo $page; ?>
		</div>
	</aside>
	
<?php 
#*************************************************************
#Cache: end (we keep the the generation time out)

if (!$admin){$contenu=cache_end($nom_page_cache,0);}
}
echo $contenu;
if (isset($_GET['embed'])){exit();}// Don't add the footer to an embedded snippet

#*************************************************************
?>
<div style="clear:both"> </div>
		<footer><?php echo feed_link(); ?><hr/><?php echo config_link().'<em>'.$config['app_name'].' '.$config['version'].'</em> '.msg('by');?> <a href="http://warriordudimanche.net">Bronco</a> - <?php echo msg('generated in');echo ' ',round(temps()-$start,6);?> s</footer>


	</body>
<script type="text/javascript" src="jquip.min.js"></script>
<?php if (file_exists('highlight.js')){ ?> <link rel="stylesheet" href="styles/<?php e('highlight_theme'); ?>.css"> <script type="text/javascript" src="highlight.js"></script><script>hljs.initHighlightingOnLoad();</script>  <?php } ?>
<script>
	$(function() {
		$('.logo').click(function(){$(this).parent().hide();});
		$(".toggle_next").click(function(){	$(this).next().toggle();return false;}); 
		$(".edit").click(function(){document.location.href="snippetvamp.php?edit="+$(this).attr('data');return false;});
		$(".suppr").click(function(){if(confirm('<?php echo msg("delete this snippet ? ");?>')){document.location.href="snippetvamp.php?suppr="+$(this).attr('data');}else{return false;}});
		$(".toggle").click(function(){if(confirm('<?php echo msg("change the public/private status ?");?>')){document.location.href="snippetvamp.php?toggle="+$(this).attr('data');}else{return false;}});
		$(".multiselect").click(function(){$('.tag_cloud .hidden').toggle();});
		$(".filter").click(function(){
			tags='<?php echo $config['url']; ?>?tag=';
			$(".tag_cloud a .tagcheck").each(function(){
				if ($(this).attr('checked')==true){
					tags=tags+$(this).attr('name')+'+';
				}
				
			});
			tags=tags.substring(0,tags.length-1);
			document.location.href=tags;
			return false;
		});
	});
</script>
</html>
<?php

?>