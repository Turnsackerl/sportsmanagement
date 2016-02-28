<?php 
/** SportsManagement ein Programm zur Verwaltung f?r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: ? 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
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
* SportsManagement ist Freie Software: Sie k?nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp?teren
* ver?ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n?tzlich sein wird, aber
* OHNE JEDE GEW?HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew?hrleistung der MARKTF?HIGKEIT oder EIGNUNG F?R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f?r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

//echo ' playground<br><pre>'.print_r($this->playground,true).'</pre>';
//echo ' temas<br><pre>'.print_r($this->teams,true).'</pre>';
//echo ' config<br><pre>'.print_r($this->config,true).'</pre>';
//echo ' project<br><pre>'.print_r($this->project,true).'</pre>';

// Make sure that in case extensions are written for mentioned (common) views,
// that they are loaded i.s.o. of the template of this view
$templatesToLoad = array('globalviews');
sportsmanagementHelper::addTemplatePaths($templatesToLoad, $this);
$this->kmlpath = JURI::root().'tmp'.DS.$this->playground->id.'-playground.kml';
$this->kmlfile = $this->playground->id.'-playground.kml';

?>

<div class="<?php echo COM_SPORTSMANAGEMENT_BOOTSTRAP_DIV_CLASS; ?>" id="playground">
	<?php 
    if ( COM_SPORTSMANAGEMENT_SHOW_DEBUG_INFO )
{
echo $this->loadTemplate('debug');
}
	echo $this->loadTemplate('projectheading');

	if ( $this->config['show_sectionheader'] )
	{ 
		echo $this->loadTemplate('sectionheader');
	}
		
	if ( $this->config['show_playground'] )
	{ 
		echo $this->loadTemplate('playground');
	}
		
	if ( $this->config['show_extended'] )
	{
		echo $this->loadTemplate('extended');
	}
		
	if ( $this->config['show_picture'] )
	{ 
		echo $this->loadTemplate('picture');
	}
		
	if ( $this->config['show_maps'] )
	{ 
		echo $this->loadTemplate('googlemap');
	}
		
	if ( $this->config['show_description'] )
	{ 
		echo $this->loadTemplate('description');
	}

	if ( $this->config['show_teams'] )
	{ 
		echo $this->loadTemplate('teams');
	}

	if ( $this->config['show_matches'] )
	{ 
		echo $this->loadTemplate('matches');
	}	

	
	?>
<div id="backbuttonfooter">
<?PHP    
echo $this->loadTemplate('backbutton');
echo $this->loadTemplate('footer');
?>
</div>
    
</div>
