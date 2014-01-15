<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * db component helper.
 * 
 * host all queries/access to database outside of the model
 * when we need only the data
 * If wee need to build a control, please see velocontrols
 */
abstract class velodb {
    /**
     * @brief   getSpecLabel()  get the label of a spec in specified language
     * @param   (integer)   $id     identifier of string to retrieve
     * @param   (string)    $lan    language in wich to retrieve the string
     * @since   0.0.27
     */
    function getSpecLabel($id = 0, $lang = "en-GB") {
        if ($id == 0) return false;
        $db = JFactory::getDbo();
        $db->setQuery('SELECT * FROM #__velo_const_specs WHERE id = '.$id.' AND published = 1 LIMIT 1');
		$result = $db->execute();
        if ($db->getNumRows() > 0) {
            $row = $db->loadAssoc();
            if ($row['language'] == $lang) {
                // if label's id is in the same language as requested, we return it
                return $row['label_tr'];
            } else {
                // if not, we look for an available translation
                $db->setQuery('SELECT * FROM #__velo_const_specs WHERE label_id = "'.$row['label_id'].'" AND language = "'.$lang.'" AND published = 1 LIMIT 1');
                $db->execute();
                if ($db->getNumRows() > 0) {
                    $row = $db->loadAssoc();
                    return $row['label_tr'];
                } else {
                    return $row['label_id'];
                }
            }
        } else {
            return $id;
        }
    }
	/**
	 * @brief	getCurrentUser() get informations about currently logged user
	 * @since	0.0.06
	 * 
	 */
	function getCurrentUser() {
		$user = null;
		/*
		 * Joomla! method
		 */
		$user = JFactory::getUser();
		$status = $user->guest;

		if ($status == 1){
			//do user logged out stuff
			// ensure user id is 0
			$user->id = 0;
		} else { 
			//do user logged in stuff
		}
		
		/*
		 * Adhérent method (com_adh)
		 */
		// $user = JAdh::getUser();
		//$status = $user->guest;
		
		/*
		 *  Other component method
		 */
		return $user;
	}
	
	/**
	 * @brief	connect to OldDb
	 * @since	0.0.14
	 */
	function getOldDbo() {
		$db = JFactory::getDbo();
		$db->setQuery('SELECT params FROM #__extensions WHERE name = "com_velo"');
		$params = json_decode( $db->loadResult(), true );
		$options = array(   "driver"    => "mysql",
				"database"  => $params['database'],
				"select"    => true,
				"host"      => $params['db_host'],
				"user"      => $params['db_username'],
				"password"  => $params['db_passwd']
		);
		$old_db = JDatabaseMySQL::getInstance($options);
		if ($old_db->getErrorNum()>0) { JFactory::getApplication()->enqueueMessage(JText::_('COM_VELO_IMPORT_DATABASE_CONNEXION_ERROR'), 'error'); }
		
		return $old_db;
	}

}
?>
