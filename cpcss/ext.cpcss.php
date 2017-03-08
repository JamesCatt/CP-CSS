<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpcss_ext {
    
    var $name           = 'CP CSS';
    var $version        = '1.2.0';
    var $description    = 'Allows adding of custom CSS to the ExpressionEngine Control Panel';
    var $settings_exist = 'y';
    var $docs_url       = 'https://github.com/JamesCatt/CP-CSS';
    
    var $settings   = array();
    
    function __construct($settings = '')
    {
        $this->settings = $settings;
    }
    
    /**
     * Activate Extension
     *
     * This function enters the extension into the exp_extensions table
     *
     * @see https://ellislab.com/codeigniter/user-guide/database/index.html for
     * more information on the db class.
     *
     * @return void
     */
    function activate_extension()
    {
        $this->settings = array();

        $data = array(
            'class'     => __CLASS__,
            'method'    => 'addcss',
            'hook'      => 'cp_css_end',
            'settings'  => serialize($this->settings),
            'priority'  => 10,
            'version'   => $this->version,
            'enabled'   => 'y'
        );

        ee()->db->insert('extensions', $data);
    }
    
    /**
     * Update Extension
     *
     * This function performs any necessary db updates when the extension
     * page is visited
     *
     * @return  mixed   void on update / false if none
     */
    function update_extension($current = '')
    {
        if ($current == '' OR $current == $this->version)
        {
            return FALSE;
        }

        if ($current < '1.2.0')
        {
            // Update to version 1.2.0
        }

        ee()->db->where('class', __CLASS__);
        ee()->db->update(
                    'extensions',
                    array('version' => $this->version)
        );
    }
    
    // --------------------------------
    //  Settings
    // --------------------------------

    function settings()
    {
        
        $siteIds = ee()->db->select('site_id')->from('sites')->get();
        
        $settings = array();
        
        foreach($siteIds->result_array() as $row) {
            
            $settingString = 'cpcss' . (string)$row['site_id'];
            
            $settings[$settingString] = array('t', '', "");
                
            $fileSettingString = 'cpcssfile' . (string)$row['site_id'];
            
            $settings[$fileSettingString] = array('i', '', "");
            
        }

        // General pattern:
        //
        // $settings[variable_name] => array(type, options, default);
        //
        // variable_name: short name for the setting and the key for the language file variable
        // type:          i - text input, t - textarea, r - radio buttons, c - checkboxes, s - select, ms - multiselect
        // options:       can be string (i, t) or array (r, c, s, ms)
        // default:       array member, array of members, string, nothing

        return $settings;
    }
    
    /**
     * Disable Extension
     *
     * This method removes information from the exp_extensions table
     *
     * @return void
     */
    function disable_extension()
    {
        ee()->db->where('class', __CLASS__);
        ee()->db->delete('extensions');
    }
    
    /**
     * Add CSS
     *
     * This function returns either raw CSS or an @import declaration linking
     * to a CSS file, as set by the user on a per-site basis.
     *
     * @return string
     */    
    function addcss()
    {
        $siteId = ee()->config->item('site_id');
        
        $settingString = 'cpcss' . (string)$siteId;
        $fileSettingString = 'cpcssfile' . (string)$siteId;
        
        if (isset($this->settings[$fileSettingString]) && $this->settings[$fileSettingString] != '') {
            
            return '@import url("' . $this->settings[$fileSettingString] . '");';

        } else if (isset($this->settings[$settingString]) && $this->settings[$settingString] != '') {

            return $this->settings[$settingString];

        }
        
        /**/
    }
    
}