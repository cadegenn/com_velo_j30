<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * controls component helper.
 * 
 * host all queries/access to database outside of the model 
 * in order to build GUI controls with its values
 * e.g. when a site needs to display all categories for example
 */
abstract class velocontrols {
	/**
	 * connect to db
	 */

	/**
	 * extract categories of sites
	 */
	function selectChantiersCategories($select = 0) {
		$db = JFactory::getDbo();
		//$query = $db->getQuery(true);
		$query = "SELECT * FROM `#__velo_chantiers_categories` WHERE published = 1 ORDER BY id";
		//$result = mysql_query($query) or die('Query failed: ' . mysql_error().'<br />QUERY = '.nl2br($query));
		$db->setQuery($query);
		$db->execute();
		$rows = $db->loadAssocList();
		echo("<select id='jform_catid' name='jform[catid]'>");
		//while ($row = mysql_fetch_assoc($result)) {
		foreach ($rows as $row) {
			echo("<option value=".$row['id']." ".($row['id']==$select ? "selected" : "")." >".$row['nom']."</option>");
		}
		echo("</select>");
		//mysql_free_result($result);
	}

	/**
	 * @brief	construit le control pour sélectionner le titre d'une personne (M., Mmme, etc...)
	 * 
	 * @param	string		select	le choix sélectionné par défaut
	 * @return	control		le control complet
	 */
	function buildSelectTitres($select = "M.") {
		$control = "<select id='jform_titre' name='jform[titre]'>";
		$titres = array('Mme', 'M.', 'Association', 'Société');
		foreach ($titres as $titre) {
			$control .= "<option value='".$titre."' ".($titre == $select ? "selected" : "").">".$titre."</option>";
		}
		$control .= "</select>";
		
		return $control;
	}
	
	/**
	 * @brief	get all Years recorded into table Table
	 * @param	string $table table name to get data from
	 * @param	string $column	column name of date type
	 * @return	select object
	 */
	function selectYearsFromTable($table, $column) {
		$db = JFactory::getDbo();
		$query = "SELECT YEAR(".$column.") as years FROM ".$table." GROUP BY years ORDER BY years DESC";
		$db->setQuery($query);
		$db->execute();
		$row = $db->loadObject();
		echo ("<select name='velo_select_years' id='velo_select_years' onchange='this.form.submit();'>");
		foreach ($rows as $obj) {
			echo ("<option value='".$obj->year."'>".$obj->year."</option>");
		}
		echo ("</select>");
	}
	
}
?>
