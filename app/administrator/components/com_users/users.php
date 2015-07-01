<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('behavior.tabstate');

$input = JFactory::getApplication()->input;
$task  = $input->get('task');
$view  = $input->get('view');

if ($view != 'login' && !in_array($task, array('session.login', 'session.logout')))
{
    if (!JFactory::getUser()->authorise('core.manage', 'com_users')) {
        return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
    }
}

JLoader::register('UsersHelper', __DIR__ . '/helpers/users.php');

$controller = JControllerLegacy::getInstance('Users');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();