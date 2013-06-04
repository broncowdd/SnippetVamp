<?php  
/**
 * @author bronco@warriordudimanche.com / JeromeJ
 * @copyright open source and free to adapt (keep me aware !)
 * @version 1.2
 *   auto_css.php is an easy to use css enhancer ^^
 *   no need of ruby, javascript or plugins... 
 *      
 *   a bug removed in 1.2   
 *      
 *   What's new in 1.1?
 *   old deprecated functions removed (bshadow/gradient)
 *   BIG CHANGE: auto_css doesn't need the $values array anymore !
 *   just put you values in the css file in a comment like this:
 *    
 *   /*INITIALISATION
 *   The values used in this css file
 *   FRONTCOLOR="#AAA"
 *   FOND="background-color:BACKCOLOR;"
 *   GRADCOL1="#953"
 *   REDBUTTON="roundc 4 boxshadow 1 3"
 *   GRADCOL2=lighten(GRADCOL1,80)
 *   BACKCOLOR=darken(FRONTCOLOR,50)
 *   CONFIGCOLOR1=lighten(FRONTCOLOR,50)
 *   CONFIGCOLOR2=darken(FRONTCOLOR,20)
 *
 *   */
 /*   
 *   
 *   
 *   Changes in 1.0:
 *      -some bugs removed 
 *      -Commands added or renamed: 
 *          -mini->miniscreen, blur->txtblur,
 *          -blur for objects, sepia  [percent], desaturate [percent], negative [percent], (experimental filter functions)
 *          -lh (line-height)
 *          -pseudo classes commands (fot, lot, oot, fch, lch, och, even, odd)
 *      -you can now add !important to auto_css native commands
 *      -auto_css doesn't changes the commands that are in a filename (like url(filewith_txtb_initsname.png);) 
 *      -you can now specifie the media in the generated css file link   
 * 
 *   Thanks a lot to Idleman for his good advices and ideas ! http://www.idleman.fr 
 *   and to JeromeJ ( http://www.olissea.com ) for his usefull comments on warriordudimanche.net
*/
 
 
/* #####################################################################
   # Names of css files                                                #
   #####################################################################
   path to master css files to compute, simply add "my file name.css", into the array.
   if you have more than one file to compute, add all the files here.
*/
    $css_files=array(
      'snippetvamp.css',        
    );

    
/* #####################################################################
   # auto_css config                                                   #
   #####################################################################
   changes the behaviour of auto_css
*/ 
    global $auto_css, $values, $auto_css_replace;
    $auto_css['version']='1.2';
    $auto_css['merge_css_files']=false; // merge all files in one computed_merged.css
    $auto_css['merged_css_filename']='merged.css'; // to avoid overwriting on other versions
    $auto_css['minifie']=false;// mimifies all the computed css files / the computed_merged.Css
    $auto_css['auto_add_PIE']=false;// to auto add pie behaviour to round corners/box shadow and gradiens
    $auto_css['pie_path']='PIE.php';// important: the path to pie.htc or pie.php (see css3pie doc at css3pie.com)
    $auto_css['media']='screen';
    $auto_css['reset_css']=true;// Auto adds HTML5 Reset Stylesheet by HTML5Doctor.com
    $auto_css['auto_add_css_links']=false; // Auto adds the link to css files 
    $auto_css['allow_auto_css_regex_replacement']=true;// Allows auto_css to use its own set of replacement strings (see below or doc)
    $auto_css['use_values_as_regex_rules']=false;// if you want to use your own regexes, set it in values and change here to true
    $auto_css['default_unit']='px'; // the unit used by default (em/mm/cm/in/px/pc/%) 
    /* if your css file and the php file which calls auto_php aren't in the same folder, 
    you can add the path here (this could be a theme subfolder) DON'T FORGET THE FINAL '/'!
    With that, it's possible to add a theme path: 
    $auto_css['path_to_css_file']=$config['theme_path'] for example
     */ 
    $auto_css['path_to_css_file']='theme/white_flat/'; 
    




  
    
    
    
    
     
    
/* #####################################################################
   # Stop ! (hammertime ^^)                                            #
   #####################################################################
   Below this line begins the auto css engine.
   Don't modify if you don't know what you're doing.
   
*/
/* #####################################################################
   # auto_css regex syntax                                             #
   #####################################################################
   
   List of regex and their replacement you can use by default
   example pad 10 = padding : 10px;
   pad XX=padding: XXpx;
   padl XX, padr XX, padt XX, padb XX = padding-left/right/bottom/top: XXpx;  
   marauto = margin:0 auto;
   etc... (see documentation to get all the syntax)
   ##################################################################### 
*/
// if you know about regex, you can add your own rules in this array() 
// "regex" => "replacement"
// be carefull # is used as limiter
$pie='';$pie_gradient='';
if ($auto_css['auto_add_PIE']){
    $pie='/*PIE BEHAVIOUR */ behavior: url('.$auto_css['pie_path'].');';
    $pie_gradient="/*GRADIENT PIE BEHAVIOUR */ \n -pie-background: linear-gradient($1, $2); \n behavior: url(".$auto_css['pie_path'].");\n";
}
$detectNegativeNumber = '(-?[0-9]*\.?[0-9]+)'; // wink JeromeJ ^^
# 1) Turned into a named group so that we don't need any longer to specify which var is the 'unit' one
# 2) The whole exp can't be obsolete, otherwise 'unit' isn't always defined, we need to get it empty if not matched.
$units='(?P<unit>(?:em|px|cm|mm|in|pt|pc|%)?)';
$auto_css_replace=array(
    //text
        "txtblur ([0-9]+) \#?([A-Za-z0-9]+)(!important)?"=>"text-shadow:0 0 $1px $2$3;color:transparent$3;",
        "txtl(!important)?"=>"text-align: left$1;",
        "txtr(!important)?"=>"text-align: right$1;",
        "txtc(!important)?"=>"text-align: center$1;",
        "txti(!important)?"=>"font-style: italic$1;",
        "txtb(!important)?"=>"font-weight: bold$1;",
        "txtxb(!important)?"=>"font-weight: bolder$1;",
        "underon(!important)?"=>"text-decoration: underline;$1",
        "strikeon(!important)?" => "text-decoration:line-through;$1",
        "overon(!important)?"=>"text-decoration:overline$1;",
        "(?:underoff|overoff|strikeoff)(!important)?"=>"text-decoration: none$1;",
        "txtshadow(!important)?"=>"text-shadow: 0 1px 1px black$1;",
        "txtsmooth \#?([A-Za-z0-9]+)(!important)?"=>"text-shadow: 0 0 1px $1$1;color:transparent$1;",
        "(?:txtshadowoff|txtsmoothoff)(!important)?"=>"text-shadow: none$1;",
        "capital[^iI]"=>"text-transform:capitalize;",
        "ucase(!important)?"=>"text-transform:uppercase$1;",
        "lcase(!important)?"=>"text-transform:lowercase$1;",
        "txtemboss (\#[A-Fa-f0-9]+)(!important)?"=>"text-shadow: 0 1px 0 $1$2;",
        "txtemboss(!important)?"=>"text-shadow: 0 1px 0 #aaa$1;",
        "txthalo (\#?[A-Za-z0-9]+)(!important)?"=>"   text-shadow:0 0 5px $1$2;",
        "txtoutline (\#?[A-Za-z0-9]+)(!important)?"=>"   text-shadow:0 0 1px $1$2;",
        "lh ".$detectNegativeNumber.$units."(!important)?"=>"line-height: $1$2;",
        
        
    //fonts
        "fs ".$detectNegativeNumber.$units."(!important)?"=>"font-size: $1$2$3;",
        "smallcaps(!important)?"=>"font-variant:small-caps$1;",
                
        "ff_impact(!important)?"=>"font-family: Impact, Charcoal, sans-serif$1;",
        "ff_palatino(!important)?"=>"font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif$1;",
        "ff_tahoma(!important)?"=>"font-family: Tahoma, Geneva, sans-serif$1;",
        "ff_century(!important)?"=>"font-family: Century Gothic, sans-serif$1;",
        "ff_lucida(!important)?"=>"font-family: 'Lucida Grande', 'Lucida Sans Unicode', sans-serif$1;",
        "ff_verdana(!important)?"=>"font-family: Verdana, Geneva, sans-serif$1;",
        "ff_copperplate(!important)?"=>"font-family: Copperplate / Copperplate Gothic Light, sans-serif$1;",
        "ff_gill(!important)?"=>"font-family: Gill Sans / Gill Sans MT, sans-serif$1;",
        "ff_trebuchet(!important)?"=>"font-family: 'Trebuchet MS', Helvetica, sans-serif$1;",
        "ff_courrier(!important)?"=>"font-family: 'Courier New', Courier, monospace$1;",
        "ff_georgia(!important)?"=>"font-family: Georgia, Serif$1;",
        "ff_bitter(!important)?"=>"font-family: 'Bitter'$1;", 
        "ff_myriad(!important)?"=>"font-family: 'Myriad Pro', Arial, Helvetica, Tahoma, sans-serif$1;",
        "ff_times(!important)?"=>"Font-Family: 'Times New Roman', Times, serif$1;",
    
    //paddings
        "pad ".$detectNegativeNumber.$units."(!important)?"=>"padding : $1$2$3 ;",
        "padt ".$detectNegativeNumber.$units."(!important)?"=>"padding-top : $1$2$3 ;",
        "padb ".$detectNegativeNumber.$units."(!important)?"=>"padding-bottom : $1$2$3 ;",
        "padl ".$detectNegativeNumber.$units."(!important)?"=>"padding-left : $1$2$3 ;",
        "padr ".$detectNegativeNumber.$units."(!important)?"=>"padding-right : $1$2$3 ;",
        
    //margins
        "mar ".$detectNegativeNumber.$units."(!important)?"=>"margin : $1$2$3 ;",
        "mart ".$detectNegativeNumber.$units."(!important)?"=>"margin-top : $1$2$3 ;",
        "marb ".$detectNegativeNumber.$units."(!important)?"=>"margin-bottom : $1$2$3 ;",
        "marl ".$detectNegativeNumber.$units."(!important)?"=>"margin-left : $1$2$3 ;",
        "marr ".$detectNegativeNumber.$units."(!important)?"=>"margin-right : $1$2$3 ;",
        "marauto(!important)?"=>"margin:0 auto$1;",

    //divs
        "boxshadow ([0-9]+) ([0-9]+)(!important)?"=>"-moz-box-shadow: 0 $1px $2px #000$3; -webkit-box-shadow: 0 $1px $2px #000$3; box-shadow: 0 $1px $2px #000$3; -ms-filter: \"progid:DXImageTransform.Microsoft.Shadow(Strength=$2, Direction=135, Color='#000000')\"; filter: progid:DXImageTransform.Microsoft.Shadow(Strength=$2, Direction=135, Color='#000000'); $pie ",
        "insetshadow ([0-9]+) ([0-9]+)(!important)?"=>"-moz-box-shadow: inset 0 $1px $2px #000000; -webkit-box-shadow: inset 0 $1px $2px #000000; box-shadow: inset 0 $1px $2px #000000; $pie ",
        "opacity ([0-9]+)(!important)?"=>"opacity: .$1$2;filter: alpha(opacity=$1)$2;-ms-filter: \"alpha(opacity=$1)\"$2; -khtml-opacity: .$1$2; -moz-opacity: .$1$2; ",
        "vgradient (\#?[0-9a-fA-F]+) (\#?[0-9a-fA-F]+)(!important)?"=>"filter: progid:DXImageTransform.Microsoft.gradient(GradientType = 1, startColorstr = $1, endColorstr = $2)$3; -ms-filter: \"progid:DXImageTransform.Microsoft.gradient(GradientType = 1, startColorstr = $1, endColorstr = $2)\"$3; background-image: -moz-linear-gradient( top, $1, $2)$3; background-image: -ms-linear-gradient( top, $1, $2)$3; background-image: -o-linear-gradient( top, $1, $2)$3; background-image: -webkit-gradient(linear, center top, center bottom, from($1), to($2))$3; background-image: -webkit-linear-gradient( top, $1, $2)$3; background-image: linear-gradient( top, $1, $2)$3;  $pie_gradient ",
        "hgradient (\#?[0-9a-fA-F]+) (\#?[0-9a-fA-F]+)(!important)?"=>"filter: progid:DXImageTransform.Microsoft.gradient(GradientType = 1, startColorstr = $1, endColorstr = $2)$3;-ms-filter: \"progid:DXImageTransform.Microsoft.gradient(GradientType = 1, startColorstr = $1, endColorstr = $2)\"$3; background-image: -moz-linear-gradient( left, $1, $2)$3; background-image: -ms-linear-gradient( left, $1, $2)$3; background-image: -o-linear-gradient( left, $1, $2)$3; background-image: -webkit-gradient(linear, left top, right top, from($1), to($2))$3; background-image: -webkit-linear-gradient( left, $1, $2)$3; background-image: linear-gradient( left, $1, $2)$3;  $pie_gradient ",
        "roundc ([0-9]+)(!important)?"=>"-moz-border-radius: $1px$2;  -webkit-border-radius: $1px$2;  border-radius: $1px$2;  $pie ",
        "leafleft ([0-9]+)(!important)?"=>"-moz-border-radius: $1px 0$2;  -webkit-border-radius: $1px 0 $1px 0$2;  border-radius: $1px 0 $1px 0$2;  $pie ",
        "leafright ([0-9]+)(!important)?"=>"-moz-border-radius: 0 $1px;  -webkit-border-radius: 0 $1px 0 $1px;  border-radius: 0 $1px 0 $1px;  $pie ",
        "roundtop ([0-9]+)(!important)?"=>"-moz-border-radius: $1px $1px 0 0$2;  -webkit-border-radius: $1px $1px 0 0$2;  border-radius: $1px $1px 0 0$2;  $pie ",
        "roundbottom ([0-9]+)(!important)?"=>"-moz-border-radius: 0 0 $1px $1px$2;  -webkit-border-radius: 0 0 $1px $1px$2;  border-radius: 0 0 $1px $1px$2;  $pie ",
        "roundleft ([0-9]+)(!important)?"=>"-moz-border-radius: $1px 0 0 $1px$2;  -webkit-border-radius: $1px 0 0 $1px$2;  border-radius: $1px 0 0 $1px$2;  $pie ",
        "roundright ([0-9]+)(!important)?"=>"-moz-border-radius: 0 $1px $1px 0$2;  -webkit-border-radius: 0 $1px $1px 0$2;  border-radius: 0 $1px $1px 0$2;  $pie ",
        "boxhalo (\#?[A-Za-z0-9]+)(!important)?"=>"-moz-box-shadow: 0 0 5px $1$2; -webkit-box-shadow: 0 0 5px $1$2; box-shadow: 0 0 5px $1$2; -ms-filter: \"progid:DXImageTransform.Microsoft.Shadow(Strength=5, Direction=135, Color='$1')\"$2; filter: progid:DXImageTransform.Microsoft.Shadow(Strength=5, Direction=135, Color='$1')$2;  $pie ",
        "insethalo (\#?[A-Za-z0-9]+)(!important)?"=>"-moz-box-shadow: inset 0 0 5px $1; -webkit-box-shadow: inset 0 0 5px $1; box-shadow: inset 0 0 5px $1;   $pie  ",
        "boxemboss (\#?[A-Za-z0-9]+) ([0-9]+)(!important)?"=>"border:$2px solid #444$3;border-top-color:#333$3;border-bottom-color:$1$3;", // with color
        "boxemboss ([0-9]+)(!important)?"=>"border:$1px solid #444$2;border-top-color:#333$2;border-bottom-color:#aaa$2;", // if no color param
        "boxraise (\#?[A-Za-z0-9]+) ([0-9]+)(!important)?"=>"border:$2px solid #444$3;border-bottom-color:#333$3;border-top-color:$1$3;", 
        "boxraise ([0-9]+)(!important)?"=>"border:$1px solid #444$2;border-bottom-color:#333$2;border-top-color:#aaa$2;", 
        
    //misc
        "minh ".$detectNegativeNumber.$units."(!important)?"=>"height:auto !important;min-height:$1$2$3 ;height:$1$2$3 ;",
        "noselect(!important)?"=>"-webkit-touch-callout: none$1; -webkit-user-select: none$1; -khtml-user-select: none$1; -moz-user-select: none$1; -ms-user-select: none$1; user-select: none$1;",
        "antioverflow(!important)?"=>'white-space: pre$1;white-space: pre-wrap$1;white-space: pre-line$1;white-space: -pre-wrap$1;white-space: -o-pre-wrap$1;white-space: -moz-pre-wrap$1;white-space: -hp-pre-wrap$1;word-wrap: break-word$1;',
        "noresiz(!important)?"=>'resize:none$1;',    
        "hideme(!important)?"=>"display:none$1;",
        "disbl(!important)?"=>"display:block$1;",
        "disin(!important)?"=>"display:inline$1;",
        "disib(!important)?"=>"display:inline-block$1;",
        "disib(!important)?"=>"display:inline-block$1;",
        "flol(!important)?"=>"float:left$1;",
        "flor(!important)?"=>"float:right$1;",
        "floc(!important)?"=>"clear:both$1;",
        "borbox(!important)?"=>"-webkit-box-sizing: border-box$1;-moz-box-sizing: border-box$1;box-sizing: border-box$1;",
        
    //cursor
        "curhand(!important)?"=>"cursor: pointer$1; ",
        "curcros(!important)?"=>"cursor: crosshair$1; ",
        "curarro(!important)?"=>"cursor: default$1; ",
        "curtext(!important)?"=>"cursor: text$1; ",
        "curwait(!important)?"=>"cursor: wait$1; ",
        "curhelp(!important)?"=>"cursor: help$1; ",
        "curnowe(!important)?"=>"cursor: nw-resize$1; ",
        "cureast(!important)?"=>"cursor: ne-resize$1; ",
        "cursout(!important)?"=>"cursor: s-resize$1; ",
        "cursoes(!important)?"=>"cursor: se-resize$1; ",
        
    //transitions caution: resise move and rotate effects doesn't cumulate
        "transitall ([0-9]+)(s|ms) ?(ease-in-out|ease-in|ease-out|linear)?"=>"-webkit-transition:all $1$2 $3;-moz-transition:all $1$2 $3;-o-transition:all $1$2 $3;transition:all $1$2 $3;",   
        "resize ([0-9]+\.?[0-9]*)"=>"  -moz-transform:scale($1,$1);  -webkit-transform:scale($1,$1);  -o-transform:scale($1,$1);  transform:scale($1,$1);",           
        "xsize ([0-9]+\.?[0-9]*)"=>"  -moz-transform:scaleX($1);  -webkit-transform:scaleX($1);  -o-transform:scaleX($1); scaleX($1);",            
        "ysize ([0-9]+\.?[0-9]*)"=>"  -moz-transform:scaleY($1);  -webkit-transform:scaleY($1);  -o-transform:scaleY($1);  transform:scaleY($1);", 
        "move (-?[0-9]+) (-?[0-9]+)"=>"   -moz-transform: translate($1px, $2px); -webkit-transform: translate($1px, $2px); -o-transform: translate($1px, $2px); transform: translate($1px, $2px);", 
        "rotate ([0-9]+)"=>"  -moz-transform:rotate($1deg);  -webkit-transform:rotate($1deg);  -o-transform:rotate($1deg);  transform:rotate($1deg);", 
        
    //mediaqueries : ex @all mobile && portrait  {
        "@all"=>"@media all and ",
        "@screen"=>"@media screen and ",
        "@tv"=>"@media tv and ",  
        "&&"=>" and ",
        "!!"=>" not ",
        "miniscreen"=>" (max-width: 320px) ",
        "mobile"=>" (max-width: 480px) ",
        "portrait"=>" (orientation: portrait) ",
        "landscape"=>" (orientation: landscape) ",
        "dmax ([0-9]+)"=>" (max-device-width:$1px) ",
        "max ([0-9]+)"=>" (max-width:$1px) ",
        "min ([0-9]+)"=>" (min-width:$1px) ",

    //pseudo classes
        "(?<=:)(?:pair|even)"=>"nth_child(even)",
        "(?<=:)(?:\impair|odd)"=>"nth_child(odd)",
        "(?<=:)fot"=>"first-of-type",
        "(?<=:)lot"=>"last-of-type",
        "(?<=:)oot"=>"only-of-type",
        "(?<=:)fch"=>"first-child",
        "(?<=:)lch"=>"last-child",
        "(?<=:)och"=>"only-child",
        "(?<=:)flet"=>"first-letter",
        "(?<=:)flin"=>"first-line",

    //Experimental
        "desaturate ([0-9]+)(!important)?"=>"filter: grayscale($1%)$2; -webkit-filter: grayscale($1%)$2; -moz-filter: grayscale($1%)$2; -ms-filter: grayscale($1%)$2; -o-filter: grayscale($1%)$2;",
        "sepia ([0-9]+)(!important)?"=>"filter: sepia($1%)$2; -webkit-filter: sepia($1%)$2; -moz-filter: sepia($1%)$2; -ms-filter: sepia($1%)$2; -o-filter: sepia($1%)$2;",
        "negative ([0-9]+)(!important)?"=>"filter: invert($1%)$2; -webkit-filter: invert($1%)$2; -moz-filter: invert($1%)$2; -ms-filter: invert($1%)$2; -o-filter: invert($1%)$2;",
        "desaturate(!important)?"=>"filter: grayscale(100%)$1; -webkit-filter: grayscale(100%)$1; -moz-filter: grayscale(100%)$1; -ms-filter: grayscale(100%)$1; -o-filter: grayscale(100%)$1;",
        "negative(!important)?"=>"filter: invert(100%)$1; -webkit-filter: invert(100%)$1; -moz-filter: invert(100%)$1; -ms-filter: invert(100%)$1; -o-filter: invert(100%)$1;",
        "(?<!: |:)sepia(!important)?"=>"filter: sepia(100%)$1; -webkit-filter: sepia(100%)$1; -moz-filter: sepia(100%)$1; -ms-filter: sepia(100%)$1; -o-filter: sepia(100%)$1;",
        "blur ([0-9]+)".$units."(!important)?"=>"filter: blur($1)$2;-webkit-filter: blur($1)$2; -moz-filter: blur($1)$2;-ms-filter: blur($1)$2; -o-filter: blur($1)$2;",
        
 );
/* #####################################################################
   # Functions                                                         #
   #####################################################################
   
   List of available css functions in this version:
   - auto_prefix($css_property)
   - darken($color, $percent)
   - lighten($color, $percent)
   - reverseColor($color)

   ##################################################################### 
*/
/**
* regenerates the css file given:
* 1- loads the master css file
* 2- process the initialisation part values
* 3- str_replace all the keys with the values of the array $values
* 4- saves the file
* @param string [$css_file] the css file (!), 
* 
*/ 
$auto_css['reset_css_added']=false;
function regenere_css($css_file,$css){
    global $auto_css;
    $values=array();
    $_debut=chrono();
    // get content of master css file (if specified, $css_file!='')
    // or use the content of $css to generate the merged file
    if ($css_file!=''){$css=file_get_contents($auto_css['path_to_css_file'].$css_file);}else{$css_file=$auto_css['merged_css_filename'];}   

    // burn all non auto_css comments
    $css=preg_replace('#\/\*[^*=]+\*/#',' ',$css);
    

    // extract from comments
    preg_match_all('#\/\*([^*]+\=[^*]+)\*/#',$css,$init);
    $variables=implode($init[0]," \n ");
    
    // process values
    $nb= preg_match_all('#([^\:\t =;"\']+)[ +]?=[ +]?\"(.+)(?=\")#',$variables,$vars);
    
    if (count($vars[1])>0){$values=array_combine($vars[1],$vars[2]);}

    // process functions
    $_='[ +]?';$reg_nb='([0-9]+)';$reg_colORvar='(\#[a-fA-F0-9]+|[^\: =;"\']+)';$reg_path='("?[a-zA-Z0-9./_-]+"?)';
    $reg_var='([^\: =;"\'\<\>\)]+)';
    $reg_darkenlight='(lighten|darken)\('.$reg_colORvar.$_.','.$_.$reg_nb;
    $reg_reverse='(reverse)\('.$reg_colORvar;
    $reg_dimensions='(dimensions)\('.$reg_path;
    $regex='#'.$reg_var.$_.'='.$_.'(?:(?:'.$reg_darkenlight.')|(?:'.$reg_reverse.')|(?:'.$reg_dimensions.'))(?=\))#';
    $nb= preg_match_all($regex,$variables,$vars); 
    if ($nb>0){
        for ($i=0;$i<count($vars[1]);$i++){ // every variables in css
            if ($vars[2][$i]!=''){// lighten/darken
                $function=$vars[2][$i];$firstarg=$vars[3][$i];$secondarg=$vars[4][$i];
                if ($firstarg[0]=='#'){ $values[$vars[1][$i]]=$function($firstarg,$secondarg); } // function with color #FFF
                else{ $values[$vars[1][$i]]=$function($values[$firstarg],$secondarg); } // function with variable
            }
            if ($vars[5][$i]!=''){// reverse
                $function=$vars[5][$i];$firstarg=$vars[6][$i];
                if ($firstarg[0]=='#'){ $values[$vars[1][$i]]=$function($firstarg); } // function with color #FFF
                else{ $values[$vars[1][$i]]=$function($values[$firstarg]); } // function with variable
            }       
            if ($vars[7][$i]!=''){// dimensions
                $function=$vars[7][$i];$firstarg=$vars[8][$i];
                if ($firstarg[0]=='"'){ $values[$vars[1][$i]]=$function($auto_css['path_to_css_file'].str_replace('"','',$firstarg)); } // with path
                else {$values[$vars[1][$i]]=$function($auto_css['path_to_css_file'].$values[$firstarg]);} // width variable
            }
        }
    }
  
    // remove parameters comments 
    $css=preg_replace('#\/\*[^*]+\=[^*]+\*/#',' ',$css);
    
    // and replaces all the keys with the values
    $var=array_keys($values);
    $var=array_map('trim',$var);
    $rempl=array_values($values);
   
    //Here, auto_css applies your string replacement rules;
    if ($auto_css['use_values_as_regex_rules']){
        // values are regex rules
        $css=preg_replace($var,$rempl,$css);
        
    }else{
        // values are only a simple string replacement
        while ($css!=str_replace($var,$rempl,$css)){
            $css=str_replace($var,$rempl,$css);
        }
    } 
    // here, it applies its own replacement rules
    if ($auto_css['allow_auto_css_regex_replacement']){$css=auto_parse($css);}
    
    if (!$auto_css['reset_css_added']){
        // adds reset css only to first file
        $css=addreset().$css;
        $auto_css['reset_css_added']=true;
    }
    if ($auto_css['minifie']==true){$css=minify_css($css);}
    $t=round(chrono()-$_debut,6);
    $css='/*Generated in '.$t.'s with auto_css v'.$auto_css['version'].'*/'."\n".$css;
    // save computed css
    file_put_contents($auto_css['path_to_css_file'].'computed_'.$css_file,$css);
    // coordinate all the dates
    $date_css=time();
    touch($auto_css['path_to_css_file'].'computed_'.$css_file,$date_css);
    touch(me(),$date_css);
}
//----------------------------------------------------------
/**
* returns css dimensions of an image (width:xxpx; height:xxpx;)
* 
*/ 
function dimensions($image){
    if (file_exists($image)){
        $wh= getimagesize($image);
        $css='width:'.$wh[0].'px; height:'.$wh[1].'px;';
        return $css;
    }else{return 'Error:'.$image.' not found !';}
}

/**
* it only adds prefixes (not a complicated function ^^ )
* 
*/ 
function auto_prefix($css_property){
    // 
    $prefixes=array('-o-','-moz-','-webkit-','-ms-','-khtml-');
    $r="\n";
    $css=$css_property.$r;
    foreach($prefixes as $i){
        $css.=$i.$css_property.$r;
    }
    return $css;
}
//----------------------------------------------------------
/**
* returns a colour x% darker
* 
* @param string [$color] a hex rgb color :#FFF or #FFFFFF 
* @param integer [$percent] amount to substract
*/ 
function darken($color, $percent){
    // change the color to a x% darker
    $rgb=separatRGB($color);
    
    $percent=100-$percent;    
    $rgb['r']=round(($percent*$rgb['r'])/100);
    $rgb['g']=round(($percent*$rgb['g'])/100);
    $rgb['b']=round(($percent*$rgb['b'])/100);    
     
    return dec2hexRGB($rgb);
}
//----------------------------------------------------------
/**
* returns a colour x% lighter
* 
* @param string [$color] a hex rgb color :#FFF or #FFFFFF 
* @param integer [$percent] amount to add
*/ 
function lighten($color, $percent){
    $rgb=separatRGB($color);
    
    $r2=round(($percent*255)/100);
    $g2=round(($percent*255)/100);
    $b2=round(($percent*255)/100);
    $rgb['r']+=$r2;
    $rgb['g']+=$g2;
    $rgb['b']+=$b2; 
    if ($rgb['r']>255){$rgb['r']=255;}
    if ($rgb['g']>255){$rgb['g']=255;}
    if ($rgb['b']>255){$rgb['b']=255;}   
    return dec2hexRGB($rgb);
}
//----------------------------------------------------------
/**
* reverse the lighter and the darker color
* 
* @param string [$color] a hex rgb color :#FFF or #FFFFFF 
* 
*/ 
function reverse($color){
   $rgb=separatRGB($color);
   $max=array_search(max($rgb),$rgb);
   $min=array_search(min($rgb),$rgb);
   
   $temp=$rgb[$max];
   $rgb[$max]=$rgb[$min];
   $rgb[$min]=$temp;
   
   return dec2hexRGB($rgb);
   
}

/*
------------------------------------------------------------
-- SYSTEM FUNCTIONS ----------------------------------------
------------------------------------------------------------
*/
function filemtim($file_name){
    return (is_file($file_name) ? filemtime($file_name):false);
}

function auto_parse($chaine){
    global $auto_css_replace, $auto_css;  
    $auto_css_regex=array_keys($auto_css_replace);
    foreach($auto_css_regex as $key=>$val){$auto_css_regex[$key]='#(?<=[^a-zA-Z0-9\(\.\#_/-])'.$val.'#';}  
    $chaine= preg_replace($auto_css_regex,$auto_css_replace, $chaine);
    return auto_add_default_unit($chaine);
}
function auto_add_default_unit($chaine){
    global $auto_css, $detectNegativeNumber;
    $add_units_to_rules=array(
        '#margin(-top|-bottom|-left|-right)? ?: ?'.$detectNegativeNumber.'+([; }])#'=>'margin$1 : $2'.$auto_css['default_unit'].'$3',
        '#padding(-top|-bottom|-left|-right)? ?: ?'.$detectNegativeNumber.'+([; }])#'=>'padding$1 : $2'.$auto_css['default_unit'].'$3',
        '#font-size ?: ?'.$detectNegativeNumber.'+([; }])#'=>'font-size : $1'.$auto_css['default_unit'].'$2',
        '#(min-|line-)?height ?: ?'.$detectNegativeNumber.'+([; }])#'=>'$1height : $2'.$auto_css['default_unit'].'$3',
        '#filter: blur\('.$detectNegativeNumber.'+\)#'=>'filter: blur($1'.$auto_css['default_unit'].')',

    );
    
    return preg_replace(array_keys($add_units_to_rules),array_values($add_units_to_rules),$chaine);
}

function addreset(){
    // adds reset css if asked
    global $auto_css;
    if ($auto_css['reset_css']==true){return '
    /* HTML5 Reset Stylesheet by HTML5Doctor.com */
    html,body,div,span,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,abbr,address,cite,code,del,dfn,em,img,ins,kbd,q,samp,small,strong,sub,sup,var,b,i,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,figcaption,figure,footer,header,hgroup,menu,nav,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent}
    body{line-height:1}
    article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}
    nav ul{list-style:none}
    blockquote,q{quotes:none}
    blockquote:before,blockquote:after,q:before,q:after{content:none}
    a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent}
    ins{background-color:#ff9;color:#000;text-decoration:none}
    mark{background-color:#ff9;color:#000;font-style:italic;font-weight:bold}
    del{text-decoration:line-through}
    abbr[title],dfn[title]{border-bottom:1px dotted;cursor:help}
    table{border-collapse:collapse;border-spacing:0}
    hr{display:block;height:1px;border:0;border-top:1px solid #ccc;margin:1em 0;padding:0}
    input,select{vertical-align:middle}  
    ';}
    
}

function minify_css($str)
{
// http://code.seebz.net/p/minify-css/ (thanx)
    $str = str_replace(array("\r","\n"), '', $str);
    $str = preg_replace('`([^*/])\/\*([^*]|[*](?!/)){5,}\*\/([^*/])`Us', '$1$3', $str);
    $str = preg_replace('`\s*({|}|,|:|;)\s*`', '$1', $str);
    $str = str_replace(';}', '}', $str);
    $str = preg_replace('`(?=|})[^{}]+{}`', '', $str);
    $str = preg_replace('`[\s]+`', ' ', $str);
    
    return $str;
}
function changes($files){ 
    //compares each file to its computed version / me() or computed_merged
    $flag=false;
    global $auto_css;
    
    foreach ($files as $file){
        
        if (file_exists($auto_css['path_to_css_file'].$file)){
                $date_css=filemtim($auto_css['path_to_css_file'].$file);
                $date_computed=filemtim($auto_css['path_to_css_file'].'computed_'.$file);  
                $date_me=filemtim(me());
                $date_merged_css=filemtim($auto_css['path_to_css_file'].'computed_'.$auto_css['merged_css_filename']);  
               // echo $date_css.'<br/>'.$date_computed.'<br/>'.$date_me.'<br/>'.$date_merged_css.'<br/>';
                if ($date_css>$date_computed&&$auto_css['merge_css_files']==false||$date_me>$date_computed&&$auto_css['merge_css_files']==false){ 
                    return true;
                }
                if ($date_css>$date_merged_css&&$auto_css['merge_css_files']==true||$date_me>$date_merged_css&&$auto_css['merge_css_files']==true){ 
                    return true;
                }
                  
        }else{return true;}
    }
    return false;
}
function echolinks($css_files){
    global $auto_css;
    if ($auto_css['auto_add_css_links']==true){
        echo "\n";
        if ($auto_css['merge_css_files']==true){
            echo '<link rel="stylesheet" type="text/css" href="'.$auto_css['path_to_css_file'].'computed_'.$auto_css['merged_css_filename'].'?lastupdate='.filemtim($auto_css['path_to_css_file'].'computed_merged.css').'" media="'.$auto_css['media'].'" />'."\n";            
        }else{
            foreach ($css_files as $css_file){
                echo '<link rel="stylesheet" type="text/css" href="'.$auto_css['path_to_css_file'].'computed_'.$css_file.'?lastupdate='.filemtime($auto_css['path_to_css_file'].'computed_'.$css_file).'"  media="'.$auto_css['media'].'" />'."\n";
            }
        }
    }  
}
function separatRGB($color){
    $color=str_replace('#','',$color);
    if (strlen($color)==3){
        $color=$color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
    }
    $RGB=array();
    $RGB['r']=hexdec(substr($color, 0,2));
    $RGB['g']=hexdec(substr($color, 2,2));
    $RGB['b']=hexdec(substr($color, 4,2));    
    return $RGB;
}
function dec2hexRGB($rgb){
    $rgb['r']=dechex($rgb['r']);
    $rgb['g']=dechex($rgb['g']);
    $rgb['b']=dechex($rgb['b']); 
    if (strlen($rgb['r'])==1){$rgb['r'].=$rgb['r'];}
    if (strlen($rgb['g'])==1){$rgb['g'].=$rgb['g'];}
    if (strlen($rgb['b'])==1){$rgb['b'].=$rgb['b'];}       
    return '#'.$rgb['r'].$rgb['g'].$rgb['b'];
}
function me(){
    $me=basename(__FILE__);
    if (file_exists($me)){return $me;}
    else{
        global $auto_css;
        return $auto_css['path_to_css_file'].$me;
    }
}
function chrono(){$t=microtime();$tt=explode(' ',$t);return $tt[0]+$tt[1];}
//----------------------------------------------------------
/* #####################################################################
   # Run baby, run !                                                   #
   #####################################################################
   if the date of you master css file and the computed one aren't equal, regenerate ! (changes made in the master css) 
   if the date of you auto_css.php file and the computed one aren't equal, regenerate ! (changes made in the values to replace) 
  
   otherwise, it doesn't touch and use the last computed version. 
   (server says: "thanks a lot folk !")
   
*/
$regen=changes($css_files); // need to regen ?
if ($regen==true){
    if ($auto_css['merge_css_files']==true){ 
        // MERGE ALL CSS FILES !
        $css='';
        foreach ($css_files as $css_file){
            $css.='/*'.$css_file.'*/'."\n".file_get_contents($auto_css['path_to_css_file'].$css_file)."\n\n";
        }  
        regenere_css('',$css);
    }else{
        // DO NOT MERGE ALL CSS FILES !    
        
        foreach ($css_files as $css_file){
            regenere_css($css_file,'');
        } 
    
    }
}
// auto echoes links to css if config's ok
echolinks($css_files);
?>
