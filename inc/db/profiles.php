<?php
$currentRoot = dirname(__FILE__);
require_once $currentRoot.'/dbbase.class.php';

/**
 * Profiles data class
 *
 * @author Amadeusz Dzięcioł <amadeusz.xd@gmail.com>
 */
class dbProfiles extends dbBaseClass
{
	/**
     * @see dbBaseClass
     * @var string
     */
    protected $pv_tableName = 'profiles';

    /**
     * @see dbBaseClass
     * @var string
     */
    protected $pv_defaultOrderSql = 'ORDER BY id';

    /**
     * @see dbBaseClass
     * @var array
     */
    protected $pv_aliasNames2colNames = array ('id' => 'id');


	public static $actions = array('podgląd', 'dodaj', 'import');
}