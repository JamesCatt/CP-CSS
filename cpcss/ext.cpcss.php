<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpcss_ext {
    
    var $name           = 'CP CSS';
    var $version        = '1.1.0';
    var $description    = 'Allows adding of custom CSS to the ExpressionEngine Control Panel';
    var $settings_exist = 'y';
    var $docs_url       = '';
    
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

        if ($current < '1.1.0')
        {
            // Update to version 1.1.0
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
        
        $settings = array();

        $settings['cpcss']      = array('t', '', "");

        $settings['cpcssfile']      = array('i', '', "");

        $settings['cpcss2']      = array('t', '', "");

        $settings['cpcssfile2']      = array('i', '', "");

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
    
    function addcss()
    {
        $siteId = ee()->config->item('site_id');
        
        if ($siteId == '1') {
            
            if (isset($this->settings['cpcssfile']) && $this->settings['cpcssfile'] != '') {
            
                return '@import url("' . $this->settings['cpcssfile'] . '");';

            } else if (isset($this->settings['cpcss']) && $this->settings['cpcss'] != '') {

                return $this->settings['cpcss'];

            }
            
        } else if ($siteId == '2') {
            
            if (isset($this->settings['cpcssfile2']) && $this->settings['cpcssfile2'] != '') {
            
                return '@import url("' . $this->settings['cpcssfile2'] . '");';

            } else if (isset($this->settings['cpcss2']) && $this->settings['cpcss2'] != '') {

                return $this->settings['cpcss2'];

            }
            
        }
        
        /**/
    }
    
}