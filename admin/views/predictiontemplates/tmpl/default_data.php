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

defined('_JEXEC') or die('Restricted access');

JHtml::_( 'behavior.tooltip' );
?>

<!--	<div id='editcell'> -->
<!--		<fieldset class='adminform'> -->
			<legend>
				<?php
				if ( $this->pred_id > 0 )
				{
					$outputStr = JText::sprintf( 	'COM_SPORTSMANAGEMENT_ADMIN_PTMPLS_TITLE2',
													'<i>' . $this->predictiongame->name . '</i>',
													' ' . $this->predictiongame->id . ' ' );
				}
				else
				{
					$outputStr = JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PTMPLS_DESCR' );
				}
				echo $outputStr;
				?>
			</legend>
			<?php
			if ( ( $this->pred_id > 0 ) && ( $this->predictiongame->master_template ) )
			{
				echo $this->loadTemplate( 'import' );
			}
			if ( $this->pred_id > 0 )
			{
				?>
				<table class="<?php echo $this->table_data_class; ?>">
					<thead>
						<tr>
							<th class='title' width='5'>
								<?php
								echo JText::_( 'COM_SPORTSMANAGEMENT_GLOBAL_NUM' );
								?>
							</th>
							<th class='title' width='20'>
								<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
							</th>
							<th class='title' width='20'>
								&nbsp;
							</th>
							<th class='title' nowrap='nowrap'>
								<?php
								echo JHtml::_( 'grid.sort', JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PTMPLS_TMPL_FILE' ), 'tmpl.template', $this->sortDirection, $this->sortColumn );
								?>
							</th>							
							<th class='title' nowrap='nowrap'>
								<?php
								echo JHtml::_( 'grid.sort', JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PTMPLS_TITLE3' ), 'tmpl.title', $this->sortDirection, $this->sortColumn );
								?>
							</th>

							<th class='title' width='20' nowrap='nowrap'>
								<?php
								echo JHtml::_( 'grid.sort', JText::_( 'JGRID_HEADING_ID' ), 'tmpl.id', $this->sortDirection, $this->sortColumn );
								?>
							</th>
                            
                            <th width="" class="title">
						<?php
						echo JText::_('JGLOBAL_FIELD_MODIFIED_LABEL');
						?>
					</th>
                    <th width="" class="title">
						<?php
						echo JText::_('JGLOBAL_FIELD_MODIFIED_BY_LABEL');
						?>
					</th>
                    
						</tr>
					</thead>
						<tfoot>
							<tr>
								<td colspan='6'>
									<?php
									echo $this->pagination->getListFooter();
									?>
								</td>
                                <td colspan="2"><?php echo $this->pagination->getResultsCounter(); ?>
            </td>
							</tr>
						</tfoot>
						<tbody>
						<?php
						$k = 0;
						for ( $i = 0, $n = count( $this->items ); $i < $n; $i++ )
						{
							$row =& $this->items[$i];

							$link = JRoute::_( 'index.php?option=com_sportsmanagement&task=predictiontemplate.edit&id=' . $row->id.'&predid='.$this->prediction_id );
							//$checked = JHtml::_( 'grid.checkedout', $row, $i );
                            $canEdit	= $this->user->authorise('core.edit','com_sportsmanagement');
                            $canCheckin = $this->user->authorise('core.manage','com_checkin') || $row->checked_out == $this->user->get ('id') || $row->checked_out == 0;
                            $checked = JHtml::_('jgrid.checkedout', $i, $this->user->get ('id'), $row->checked_out_time, 'predictiontemplates.', $canCheckin);
							?>
							<tr class='<?php echo "row$k"; ?>'>
								<td>
									<?php
									echo $this->pagination->getRowOffset( $i );
									?>
								</td>
								<td>
									<?php
									echo JHtml::_('grid.id', $i, $row->id);
									?>
								</td>
								<td style='text-align:center; '>
                                <?php
                            if ($row->checked_out) : ?>
										<?php echo JHtml::_('jgrid.checkedout', $i, $this->user->get ('id'), $row->checked_out_time, 'predictiontemplates.', $canCheckin); ?>
									<?php endif; ?>	
									<a href='<?php echo $link; ?>'>
										<?php
										echo JHtml::_(	'image',
														'administrator/components/com_sportsmanagement/assets/images/edit.png',
														JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PTMPLS_EDIT_SETTINGS' ),
														'title= "' . JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PTMPLS_EDIT_SETTINGS' ) . '"' );
										?>
									</a>
								</td>
								<td style='text-align:left; ' nowrap='nowrap'>
									<?php
									echo $row->template;
									?>
								</td>								
								<td style='text-align:left; ' nowrap='nowrap'>
									<?php
									echo JText::_( $row->title );
									?>
								</td>
								<td style='text-align:center; '>
									<?php
									echo $row->id;
									?>
								</td>
                                <td><?php echo $row->modified; ?></td>
                            <td><?php echo $row->username; ?></td> 
							</tr>
							<?php
							$k = 1 - $k;
						}
						?>
						</tbody>
				</table>
			<?php
			}
			?>
<!--		</fieldset> -->
<!--	</div> -->
  