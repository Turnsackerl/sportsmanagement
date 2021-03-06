<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      jlextprofleagimport.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage controllers
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');


/**
 * sportsmanagementControllerjlextprofleagimport
 * 
 * @package 
 * @author diddi
 * @copyright 2014
 * @version $Id$
 * @access public
 */
class sportsmanagementControllerjlextprofleagimport extends JControllerLegacy
{
	
	/**
	 * sportsmanagementControllerjlextprofleagimport::save()
	 * 
	 * @return
	 */
	function save()
	{
		$option = JFactory::getApplication()->input->getCmd('option');
		$app = JFactory::getApplication();
        // Check for request forgeries
		JSession::checkToken() or jexit(\JText::_('JINVALID_TOKEN'));
		$msg='';
		JToolbarHelper::back(JText::_('JPREV'),JRoute::_('index.php?option=com_sportsmanagement&view=jlextprofleagimport&controller=jlextprofleagimport'));
		$app = JFactory::getApplication();
		$post=JFactory::getApplication()->input->post->getArray(array());
    $model=$this->getModel('jlextprofleagimport');
    
		// first step - upload
		if (isset($post['sent']) && $post['sent']==1)
		{
			//$upload=JFactory::getApplication()->input->getVar('import_package',null,'files','array');
$upload = $app->input->files->get('import_package');

			$lmoimportuseteams=JFactory::getApplication()->input->getVar('lmoimportuseteams',null);
			$app->setUserState($option.'lmoimportuseteams',$lmoimportuseteams);
			
			$tempFilePath=$upload['tmp_name'];
			$app->setUserState($option.'uploadArray',$upload);
			$filename='';
			$msg='';
			$dest=JPATH_SITE.DS.'tmp'.DS.$upload['name'];
			$extractdir=JPATH_SITE.DS.'tmp';
			$importFile=JPATH_SITE.DS.'tmp'. DS.'joomleague_import.xml';
			if (JFile::exists($importFile))
			{
				JFile::delete($importFile);
			}
			if (JFile::exists($tempFilePath))
			{
					if (JFile::exists($dest))
					{
						JFile::delete($dest);
					}
					if (!JFile::upload($tempFilePath,$dest))
					{
						JError::raiseWarning(500,JText::_('COM_SPORTSMANAGEMENT_ADMIN_PROF_LEAGUE_IMPORT_CTRL_CANT_UPLOAD'));
						return;
					}
					else
					{
						if (strtolower(JFile::getExt($dest))=='zip')
						{
							$result=JArchive::extract($dest,$extractdir);
							if ($result === false)
							{
								JError::raiseWarning(500,JText::_('COM_SPORTSMANAGEMENT_ADMIN_PROF_LEAGUE_IMPORT_CTRL_EXTRACT_ERROR'));
								return false;
							}
							JFile::delete($dest);
							$src=JFolder::files($extractdir,'xml',false,true);
							if(!count($src))
							{
								JError::raiseWarning(500,'COM_SPORTSMANAGEMENT_ADMIN_PROF_LEAGUE_IMPORT_CTRL_EXTRACT_NOJLG');
								//todo: delete every extracted file / directory
								return false;
							}
							if (strtolower(JFile::getExt($src[0]))=='xml')
							{
								if (!@ rename($src[0],$importFile))
								{
									JError::raiseWarning(21,JText::_('COM_SPORTSMANAGEMENT_ADMIN_PROF_LEAGUE_IMPORT_CTRL_ERROR_RENAME'));
									return false;
								}
							}
							else
							{
								JError::raiseWarning(500,JText::_('COM_SPORTSMANAGEMENT_ADMIN_PROF_LEAGUE_IMPORT_CTRL_TMP_DELETED'));
								return;
							}
						}
						else
						{
							if (strtolower(JFile::getExt($dest))=='xml')
							{
								if (!@ rename($dest,$importFile))
								{
									JError::raiseWarning(21,JText::_('COM_SPORTSMANAGEMENT_ADMIN_PROF_LEAGUE_IMPORT_CTRL_RENAME_FAILED'));
									return false;
								}
							}
							else
							{
								JError::raiseWarning(21,JText::_('COM_SPORTSMANAGEMENT_ADMIN_PROF_LEAGUE_IMPORT_CTRL_WRONG_EXTENSION'));
								return false;
							}
						}
					}
			}
		}

/*        
$convert = array (
'Ä' => '&#196;',
'Ö' => '&#214;',
'Ü' => '&#220;',
'ä' => '&#228;',
'ö' => '&#246;',
'ü' => '&#252;',
'ß' => '&#223;',
'charset=' => '',
'<![CDATA[' => '',
']]>' => '',
'é' => '&#233;'
  );
*/


$convert = array (
'charset=' => '',
'encoding="ISO-8859-1"' => 'encoding="utf-8"',
'<h2>' => '',
'</h2>' => '',
'<h3>' => '',
'</h3>' => '',
'<br>' => '',
'</br>' => '',
'<b>' => '',
'</b>' => '',
'<![CDATA[' => '',
']]>' => ''
  );
  

      
$source	= JFile::read($importFile);
$source = str_replace(array_keys($convert), array_values($convert), $source  );
$source = utf8_encode ( $source );
$return = JFile::write($importFile,$source );

    $model->getData();
		//$link='index.php?option='.$option.'&task=jlextlmoimports.edit';
        $link = 'index.php?option='.$option.'&view=jlxmlimports&task=jlxmlimport.edit';
		#echo '<br />Message: '.$msg.'<br />';
		#echo '<br />Redirect-Link: '.$link.'<br />';
		
        $this->setRedirect($link,$msg);
        
	}










}


?>
