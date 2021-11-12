<?php

/**
 * This file is part of the osWFrame package
 *
 * @author Juergen Schwind
 * @copyright Copyright (c) JBS New Media GmbH - Juergen Schwind (https://jbs-newmedia.com)
 * @package osWFrame
 * @link https://oswframe.com
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License 3
 */

namespace osWFrame\Core;

trait BaseConnectionTrait {

	/**
	 * @var array|null
	 */
	private static ?array $connection=null;

	/**
	 * @param string $alias
	 * @return static
	 */
	public static function getConnection($alias='default'):self {
		return new \osWFrame\Core\Database($alias);
	}

	/**
	 * @param string $alias
	 * @return static
	 */
	public static function getConnectionRef($alias='default'):self {
		if ((!isset(self::$connection[$alias]))||(self::$connection[$alias]===null)) {
			self::$connection[$alias]=new \osWFrame\Core\Database($alias);
		}

		return self::$connection[$alias];
	}

}

?>