<?php
/**
 * @package    Joomla.Administrator
 *
 * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @copyright  Copyright (C) 2015 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

//Define the platform
define('JOOMLATOOLS_PLATFORM', 1);

//Required by Joomla
define('_JEXEC', 1);

// Configuration
define('JPATH_CONFIGURATION', JPATH_ROOT . '/config');
define('JPATH_LIBRARIES',     JPATH_ROOT . '/lib/libraries');
define('JPATH_LAYOUTS',       JPATH_ROOT . '/lib/layouts');
define('JPATH_PLUGINS',       JPATH_ROOT . '/lib/plugins');
define('JPATH_MANIFESTS',     JPATH_ROOT . '/config/manifests');
define('JPATH_VENDOR',        JPATH_ROOT . '/vendor');

define('JPATH_APP'          , JPATH_ROOT . '/app');
define('JPATH_ADMINISTRATOR', JPATH_APP  . '/administrator');
define('JPATH_SITE'         , JPATH_APP  . '/site');
