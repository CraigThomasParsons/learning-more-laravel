<?php

namespace Generator\model\MysqlDatabase;

require_once BASEDIR . '/includes/autoload.php';
require_once BASEDIR . '/includes/MoreActiveRecord.php';

class Cell extends \MoreActiveRecord
{
    /**
     * Check for a cell record in the database,
     * if it doesn't exist return a new one.
     *
     * @param integer $mapId       The map record's primary key
     * @param integer $coordinateX The x-axis co-ordinate
     * @param integer $coordinateY The y-axis co-ordinate
     *
     * @return Cell
     */
    public function findByCoordinates($mapId, $coordinateX, $coordinateY)
    {
        $arrWhereKeyValuePair                = array();
        $arrWhereKeyValuePair['coordinateX'] = $coordinateX;
        $arrWhereKeyValuePair['coordinateY'] = $coordinateY;
        $arrWhereKeyValuePair['map_id']      = $mapId;

        $arrAndWhere = array();
        foreach ($arrWhereKeyValuePair as $key => $value) {
            $arrAndWhere[] = $key . ' = ' . $value;
        }
        $strAndWhere = implode(' and ', $arrAndWhere);

        // Try and see if there is a Cell Record there.
        $cellRecord = self::findFirst('Generator\model\Database\Cell', $strAndWhere);

        if ($cellRecord) {

            // Return the cell record that was returned from the database.
            return $cellRecord;

        } else {
            // Return a new cell record.
            return new Cell();
        }
    }
}
