<?php

namespace Generator\model\MysqlDatabase;

require_once BASEDIR . '/includes/autoload.php';
require_once BASEDIR . '/includes/MoreActiveRecord.php';

/**
 *
 */
class Tile extends \MoreActiveRecord
{
    /**
     * Check for a tile record in the database,
     * if it doesn't exist return a new one.
     *
     * @param integer $mapId       The map record's primary key
     * @param integer $coordinateX The x-axis co-ordinate
     * @param integer $coordinateY The y-axis co-ordinate
     *
     * @return Tile
     */
    public function findByMapCoordinates($mapId, $mapCoordinateX, $mapCoordinateY)
    {
        $arrWhereKeyValuePair                   = array();
        $arrWhereKeyValuePair['mapCoordinateX'] = $mapCoordinateX;
        $arrWhereKeyValuePair['mapCoordinateY'] = $mapCoordinateY;
        $arrWhereKeyValuePair['map_id']         = $mapId;

        $arrAndWhere = array();
        foreach ($arrWhereKeyValuePair as $key => $value) {
            $arrAndWhere[] = $key . ' = ' . $value;
        }
        $strAndWhere = implode(' and ', $arrAndWhere);

        // Try and see if there is a Cell Record there.
        $tileRecord = self::findFirst('Generator\model\Database\Tile', $strAndWhere);

        if ($tileRecord) {

            // Return the cell record that was returned from the database.
            return $tileRecord;

        } else {
            // Return a new cell record.
            return new Tile();
        }
    }
}
