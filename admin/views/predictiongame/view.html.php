<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
* @copyright        Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie können es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
* veröffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es nützlich sein wird, aber
* OHNE JEDE GEWÄHRLEISTUNG, bereitgestellt; sogar ohne die implizite
* Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License für weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * sportsmanagementViewPredictionGame
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewPredictionGame extends sportsmanagementView
{
	
	/**
	 * sportsmanagementViewPredictionGame::init()
	 * 
	 * @return
	 */
	public function init ()
	{
        
        $pred_admins = sportsmanagementModelPredictionGames::getAdmins($this->item->id);
		$pred_projects = $this->model->getPredictionProjectIDs($this->item->id);
 
//		$this->app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' pred_admins<br><pre>'.print_r($pred_admins,true).'</pre>'),'');
//        $this->app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' pred_projects<br><pre>'.print_r($pred_projects,true).'</pre>'),'');
        
        // Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

        $this->form->setValue('user_ids', null, $pred_admins);
        $this->form->setValue('project_ids', null, $pred_projects);

	}
    
    
	/**
	 * sportsmanagementViewPredictionGame::addToolBar()
	 * 
	 * @return void
	 */
	protected function addToolBar() 
	{
		$jinput = JFactory::getApplication()->input;
        $jinput->set('hidemainmenu', true);
        
        $isNew = $this->item->id ? $this->title = JText::_('COM_SPORTSMANAGEMENT_PREDGAME_EDIT') : $this->title = JText::_('COM_SPORTSMANAGEMENT_PREDGAME_NEW');
        $this->icon = 'pgame';
        parent::addToolbar();  
	}
    
    

}
?>