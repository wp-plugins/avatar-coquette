<?php
/**
 * Options Plugin
 * Make configutarion
*/

if ( !class_exists('avatar_coquette_make') ) {

class avatar_coquette_make{

    public $parameter       = array();
    public $options         = array();
    public $components      = array();



    function __construct(){

        if( is_admin() )
            self::configuration_plugin();
        else
            self::parameters();

    }

    function getHeaderPlugin(){

        return array('id'             =>'avatar_coquette_id',
                     'id_menu'        =>'avatar_coquette',
                     'name'           =>'Avatar Coquette',
                     'name_long'      =>'Avatar Coquette',
                     'name_option'    =>'avatar_coquette',
                     'name_plugin_url'=>'avatar-coquette',
                     'descripcion'    =>'Change avatar sad wordpress by other coquette',
                     'version'        =>'2.8',
                     'url'            =>'',
                     'logo'           =>'<i class="fa fa-user text-long" style="padding:15px 18px;"></i>',
                     'logo_text'      =>'', // alt of image
                     'slogan'         =>'', // powered by <a href="">iLenTheme</a>
                     'url_framework'  =>plugins_url()."/avatar-coquette/assets/ilenframework",
                     'theme_imagen'   =>plugins_url()."/avatar-coquette/assets/images",
                     'twitter'        =>'',
                     'wp_review'      =>'https://wordpress.org/plugins/avatar-coquette/',
                     'link_donate'    =>'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3VBA8WCYN5ZTS',
                     'wp_support'     =>'http://support.ilentheme.com/forums/forum/plugins/avatar-coquette/',
                     'type'           =>'plugin',
                     'method'         =>'free',
                     'themeadmin'     =>'fresh',
                     'scripts_admin'  =>array( 'page' => array('avatar_coquette' => array('jquery_ui_reset')), ));
    }

    function getOptionsPlugin(){
        //code 
    global $wp_social_pupup_make_plugins;

    global ${'tabs_plugin_' . $this->parameter['name_option']};
    ${'tabs_plugin_' . $this->parameter['name_option']} = array();
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab01']=array('id'=>'tab01','name'=>'Main Settings','icon'=>'<i class="fa fa-circle-o"></i>','width'=>'550px'); 

    return array('a'=>array(                'title'      => __('Main Settings',$this->parameter['name_option']),        //title section
                                            'title_large'=> __('Main Settings',$this->parameter['name_option']),//title large section
                                            'description'=> '', //description section
                                            'icon'       => 'fa fa-circle-o',
                                            'tab'        => 'tab01',


                                            'options'    => array(  

                                                                array(  'title' =>__('Enable / Disable:',$this->parameter['name_option']), //title section
                                                                        'help'  =>'Enable / Disable the "Avatar Coquette" plugin.',
                                                                        'type'  =>'checkbox', //type input configuration
                                                                        'value' =>'1', //value default
                                                                        'value_check'=>1,
                                                                        'id'    =>$this->parameter['name_option'].'_enabled', 
                                                                        'name'  =>$this->parameter['name_option'].'_enabled',  
                                                                        'class' =>'', //class
                                                                        'row'   =>array('a','b')),         

                                                                array(  'title' =>__('Default Avatar:',$this->parameter['name_option']), //title section
                                                                        'help'  =>'Select default avatar.',
                                                                        'type'  =>'upload',  
                                                                        'value' =>plugins_url()."/avatar-coquette/assets/images/default.png",  
                                                                        'items' =>array('1'=>'Avatar set 1','2'=>'Avatar set 2'),
                                                                        'id'    =>$this->parameter['name_option'].'_avatar_default', 
                                                                        'name'  =>$this->parameter['name_option'].'_avatar_default',  
                                                                        'class' =>'', 
                                                                        'row'   =>array('a','b')),

                                                                array(  'title' =>__('Criteria:',$this->parameter['name_option']), //title section
                                                                        'help'  =>"Select the criterion by which new avatars will be displayed, this parameter determines the defaults show avatars in comments, for example: If you choose the first criterion. With this show avatars depending on the first letter of his name, that is, if a name starts with 'John' the 'J' is the first letter and in alphabetical number is the number '10' then show the cool avatar '10.png' with this may improve the static of the ugly default avatars having wordpress.",
                                                                        'type'  =>'select',  
                                                                        'value' =>'1',  
                                                                        'items' =>array('1'=>'By first letter of name comment','2'=>'For the last name letter of the comment'),
                                                                        'id'    =>$this->parameter['name_option'].'_criteria', 
                                                                        'name'  =>$this->parameter['name_option'].'_criteria',  
                                                                        'class' =>'', 
                                                                        'row'   =>array('a','b')),
                                                                
                                                                 /*array(  'title' =>__('Show text for get avatar',$this->parameter['name_option']), //title section
                                                                        'help'  =>'Enabling this option when mouse over an avatar coquette, a text is displayed to encourage the user to upload their own avatar.',
                                                                        'type'  =>'checkbox', //type input configuration
                                                                        'value' =>'0', 
                                                                        'value_check'=>1,//value default
                                                                        'id'    =>$this->parameter['name_option'].'_enabled_text', 
                                                                        'name'  =>$this->parameter['name_option'].'_enabled_text',  
                                                                        'class' =>'', //class
                                                                        'row'   =>array('a','b')), 
                                                                
                                                                array(  'title' =>__('Text for get avatar',$this->parameter['name_option']),
                                                                        'help'  =>__('This is a text to tell your users to upload their own avatar, when clicking the link will redirect you choose, the default is the link gravatar.com',$this->parameter['name_option']),
                                                                        'type'  =>'text',
                                                                        'value' =>'Change avatar',
                                                                        'id'    =>$this->parameter['name_option'].'_text_change_avatar',
                                                                        'name'  =>$this->parameter['name_option'].'_text_change_avatar',
                                                                        'class' =>'',
                                                                        'before'=>'<div class="class_coquette_avatar_enable_link">',
                                                                        'row'   =>array('a','b')),


                                                                array(  'title' =>__('Link for get avatar',$this->parameter['name_option']),
                                                                        'help'  =>__('',$this->parameter['name_option']),
                                                                        'type'  =>'text',
                                                                        'value' =>'http://gravatar.com',
                                                                        'id'    =>$this->parameter['name_option'].'_link_change_avatar',
                                                                        'name'  =>$this->parameter['name_option'].'_link_change_avatar',
                                                                        'class' =>'',
                                                                        'after' =>'</div>',
                                                                        'row'   =>array('a','b')), */

                                                                array(  'title' =>__('Set Avatar:',$this->parameter['name_option']), //title section
                                                                        'help'  =>'Select the set of avatar to replace the typical avatar wordpress.',
                                                                        'type'  =>'select',  
                                                                        'value' =>'1',  
                                                                        'items' =>array('1'=>'Avatar set 1','2'=>'Avatar set 2','3'=>'Use Avatar default'),
                                                                        'id'    =>$this->parameter['name_option'].'_set_avatar', 
                                                                        'name'  =>$this->parameter['name_option'].'_set_avatar',  
                                                                        'class' =>'', 
                                                                        'onchange'=>'avatar_coquette_operation()',
                                                                        'row'   =>array('a','b')), 


                                                                array(  'title' =>__('',$this->parameter['name_option']), //title section
                                                                        'help'  =>'',
                                                                        'type'  =>'html',  
                                                                        'html2' =>self::getSet(),  
                                                                        'id'    =>$this->parameter['name_option'].'_preview_1',
                                                                        'class' =>'preview_html1',
                                                                        'style' =>'style="display:none;"',
                                                                        'row'   =>array('a','c')), 

                                                                array(  'title' =>__('',$this->parameter['name_option']), //title section
                                                                        'help'  =>'',
                                                                        'type'  =>'html',  
                                                                        'html2' =>self::getSet(2),  
                                                                        'id'    =>$this->parameter['name_option'].'_preview_2',
                                                                        'class' =>'preview_html2',
                                                                        'style' =>'style="display:none;"',
                                                                        'row'   =>array('a','c')),    

                                                            ),
                ),
                'last_update'=>time(),


            );
        
    }

     function generateAlphabet($na) {
        $sa = "";
        while ($na >= 0) {
            $sa = chr($na % 26 + 65) . $sa;
            $na = floor($na / 26) - 1;
        }
        return $sa;
    }



    function getSet($FOLDER=1){

        $azRange = range('a', 'z');
        $array_avatar = array();
        $i=1;
        foreach ($azRange as $letter)
        {
            $array_avatar[$letter] = $i;
            $i++;
        }
        
        $_html = "";
        $url = plugins_url();
        foreach ($array_avatar as $key => $value) {
            $_html .= "<div class='avatar_preview_admin'><img src='".$url."/avatar-coquette/assets/images/$FOLDER/".$value.".png' width='50' height='50' /><span>$key</span></div>";
        }

        return $_html;
 
        
    }                   



    function parameters(){
        
        //require_once 'assets/functions/options.php';
        //global $wp_social_pupup_header_plugins;

        //$this->parameter = $wp_social_pupup_header_plugins;
        $this->parameter = self::getHeaderPlugin();
    }

    function myoptions_build(){
        
        //require_once 'assets/functions/options.php';
        //global $wp_social_pupup_make_plugins;

        //$this->options = $wp_social_pupup_make_plugins;
        $this->options = self::getOptionsPlugin();

        return $this->options;
        
    }

    function use_components(){
        //code 
        $this->components = array();

    }

    function configuration_plugin(){
        // set parameter 
        self::parameters();

        // my configuration 
        self::myoptions_build();

        // my component to use
        self::use_components();
    }

}
}


?>