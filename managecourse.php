<?php 
/**
 * @package     LOGman
 * @copyright   Copyright (C) 2011 - 2013 Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.joomlatools.com
 */

 
/**
 * LOGman content plugin.
 *
 * Provides handlers for dealing with content level events from core J! extensions.
 */
class PlgLogmanManagecourse extends ComLogmanPluginAbstract
{
    /**
     * @see ComLogmanPluginContext::$_contexts
     */
    protected $_contexts = array(
        'com_managecourse.courses',
        'com_managecourse.location');

    protected $_aliases = array('com_managecourse.form'  => 'com_managecourse.course');

    /**
     * J!1.5 after content (article) save event handler.
     *
     * @param $article
     * @param $isNew
     */
    public function onAfterManagecourseSave($article, $isNew)
    { 
        // Same as J!2.5
        $this->onManagecourseAfterSave('com_managecourse.course', $article, $isNew);
    }

    /**
     * @see ComLogmanPluginManagecourse::onManagecourseAfterSave
     */
    public function onManagecourseAfterSave($context, $content, $isNew)
    { 
        // Map inconsistent contexts.
        if (isset($this->_aliases[$context])) {
            $context = $this->_aliases[$context];
        }

        parent::onManagecourseAfterSave($context, $content, $isNew);
    }

    protected function _getRedirectLinkSubject($data)
    {
        return array('id' => $data->id, 'course' => 'redirect');
    }

    // TODO Added since the delete language event is inconsistently triggered on content plugins.
    protected function _getLanguagesLanguageSubject($data)
    {
        return array('id' => $data->id, 'course' => $data->title);
    }

    protected function _getUsersNoteSubject($data)
    {
        return array('id' => $data->id, 'course' => $data->subject);
    }
    protected function _getBannersBannerSubject($data)
    {
        return array('id' => $data->id, 'course' => $data->name);
    }

    protected function _getCategoriesCategorySubject($data)
    {
        $subject = parent::_getDefaultSubject($data);
        // Push meta data.
        $subject['metadata'] = array('extension' => $data->extension);
        return $subject;
    }
}
