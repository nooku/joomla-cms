<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');

$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$loggeduser = JFactory::getUser();
?>

<?php JFactory::getDocument()->setBuffer($this->sidebar, 'modules', 'sidebar'); ?>

<form class="k-component k-js-component k-js-grid-controller k-js-grid" action="<?php echo JRoute::_('index.php?option=com_users&view=users');?>" method="post" name="adminForm" id="adminForm">

    <!-- Scopebar -->
    <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('filterButton' => false))); ?>

    <!-- Table -->
    <div class="k-table-container">
        <div class="k-table">
            <table class="k-js-fixed-table-header k-js-responsive-table">
                <thead>
                    <tr>
                        <th width="1%">
                            <?php echo JHtml::_('grid.checkall'); ?>
                        </th>
                        <th>
                            <?php echo JHtml::_('searchtools.sort', 'COM_USERS_HEADING_NAME', 'a.name', $listDirn, $listOrder); ?>
                        </th>
                        <th>
                            <?php echo JHtml::_('searchtools.sort', 'JGLOBAL_USERNAME', 'a.username', $listDirn, $listOrder); ?>
                        </th>
                        <th width="1%">
                            <?php echo JHtml::_('searchtools.sort', 'COM_USERS_HEADING_ENABLED', 'a.block', $listDirn, $listOrder); ?>
                        </th>
                        <th width="1%">
                            <?php echo JHtml::_('searchtools.sort', 'COM_USERS_HEADING_ACTIVATED', 'a.activation', $listDirn, $listOrder); ?>
                        </th>
                        <th>
                            <?php echo JText::_('COM_USERS_HEADING_GROUPS'); ?>
                        </th>
                        <th width="1%" class="k-table-data--nowrap">
                            <?php echo JHtml::_('searchtools.sort', 'COM_USERS_HEADING_LAST_VISIT_DATE', 'a.lastvisitDate', $listDirn, $listOrder); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($this->items as $i => $item) :
                    $canEdit   = $this->canDo->get('core.edit');
                    $canChange = $loggeduser->authorise('core.edit.state',	'com_users');

                    // If this group is super admin and this user is not super admin, $canEdit is false
                    if ((!$loggeduser->authorise('core.admin')) && JAccess::check($item->id, 'core.admin'))
                    {
                        $canEdit   = false;
                        $canChange = false;
                    }
                ?>
                    <tr>
                        <td class="k-table-data--small">
                            <?php if ($canEdit) : ?>
                                <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($canEdit) : ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id='.(int) $item->id); ?>" title="<?php echo JText::sprintf('COM_USERS_EDIT_USER', $this->escape($item->name)); ?>">
                                    <?php echo $this->escape($item->name); ?></a>
                            <?php else : ?>
                                <?php echo $this->escape($item->name); ?>
                            <?php endif; ?>
                            <div>
                                <?php echo JHtml::_('users.notes',0, $item->id); ?>
                                <?php if ($item->requireReset == '1') : ?>
                                <span class="label label-warning"><?php echo JText::_('COM_USERS_PASSWORD_RESET_REQUIRED'); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (JDEBUG) : ?>
                                <div class="small"><a href="<?php echo JRoute::_('index.php?option=com_users&view=debuguser&user_id='.(int) $item->id);?>">
                                <?php echo JText::_('COM_USERS_DEBUG_USER');?></a></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $this->escape($item->username); ?>
                        </td>
                        <td class="k-table-data--center">
                            <?php if ($canChange) : ?>
                                <?php
                                $self = $loggeduser->id == $item->id;
                                echo JHtml::_('jgrid.state', JHtmlUsers::blockStates($self), $item->block, $i, 'users.', !$self);
                                ?>
                            <?php else : ?>
                                <?php echo JText::_($item->block ? 'JNO' : 'JYES'); ?>
                            <?php endif; ?>
                        </td>
                        <td class="k-table-data--center">
                            <?php
                            $activated = empty( $item->activation) ? 0 : 1;
                            echo JHtml::_('jgrid.state', JHtmlUsers::activateStates(), $activated, $i, 'users.', (boolean) $activated);
                            ?>
                        </td>
                        <td>
                            <?php if (substr_count($item->group_names, "\n") > 1) : ?>
                                <span class="hasTooltip" title="<?php echo JHtml::tooltipText(JText::_('COM_USERS_HEADING_GROUPS'), nl2br($item->group_names), 0); ?>"><?php echo JText::_('COM_USERS_USERS_MULTIPLE_GROUPS'); ?></span>
                            <?php else : ?>
                                <?php echo nl2br($item->group_names); ?>
                            <?php endif; ?>
                        </td>
                        <td class="k-table-data--nowrap k-table-data--small">
                            <?php if ($item->lastvisitDate != '0000-00-00 00:00:00'):?>
                                <?php echo JHtml::_('date', $item->lastvisitDate, 'Y-m-d'); ?>
                            <?php else:?>
                                -
                            <?php endif;?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </div><!-- .k-table -->

        <!-- Pagination -->
        <?php echo JLayoutHelper::render('elysio.pagination', array('view' => $this, 'pages' => $this->pagination->getListFooter())); ?>

    </div><!-- .k-table-container -->

</form><!-- .k-component -->

<?php // Load the batch processing form if user is allowed ?>
<?php if ($loggeduser->authorise('core.create', 'com_users')
    && $loggeduser->authorise('core.edit', 'com_users')
    && $loggeduser->authorise('core.edit.state', 'com_users')) : ?>
    <?php echo JHtml::_(
        'bootstrap.renderModal',
        'collapseModal',
        array(
            'title' => JText::_('COM_USERS_BATCH_OPTIONS'),
            'footer' => $this->loadTemplate('batch_footer')
        ),
        $this->loadTemplate('batch_body')
    ); ?>
<?php endif;?>
