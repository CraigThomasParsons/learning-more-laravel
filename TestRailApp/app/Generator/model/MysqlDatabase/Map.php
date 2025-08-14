<?php

namespace Generator\model\MysqlDatabase;

require_once BASEDIR . '/includes/autoload.php';
require_once BASEDIR . '/includes/MoreActiveRecord.php';

/**
 * Represents 1 single square Map of a Rts game's entire world.
 * This should be moved to helpers, Create a Map class in the model folder
 * to used exclusivly for loading and saving the Map record.
 */
class Map extends \MoreActiveRecord
{
    public function emptyTileTable()
    {
        $strSql = 'truncate tile;';

        $result = self::Query($strSql);
    }
}
