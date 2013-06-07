<?php
/**
 * Authentication Library
 *
 * @package Authentication
 * @category Libraries
 * @author Adam Griffiths
 * @link http://adamgriffiths.co.uk
 * @version 1.0.6
 * @copyright Adam Griffiths 2009
 *
 * Auth provides a powerful, lightweight and simple interface for user authentication 
 */

/* Note: other options moved to DB access (use CodeFire::getSetting() instead!) */

/**
 * The following options provide the ability to easily rename the directories
 * for your auth views, models, and controllers.
 *
 * Remember to also update your routes file if you change the controller directory
 * MUST HAVE A TRAILING SLASH!
 */
$config['auth_controllers_root'] = 'admin/';
$config['auth_models_root'] = '';
$config['auth_views_root'] = 'admin/';

?>