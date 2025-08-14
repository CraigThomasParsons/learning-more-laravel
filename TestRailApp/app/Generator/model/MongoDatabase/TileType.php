<?php

namespace Generator\model\MongoDatabase;

require_once BASEDIR . '/includes/autoload.php';

class TileType extends MongoModel
{
    const TILE_TYPE_TABLE_NAME  = 'tileType';

    /**
     * Search the tileType table for a record by the name field.
     *
     * @param string $strName
     *
     * @return integer Tile Type Record
     */
    public function findByName($strName)
    {
        $strSql = ' select * from tileType where';
        $strAndWhere = ' name = "'.$strName.'"';

        $strSql .= $strAndWhere;

        $result = self::Query($strSql);

        if ($result) {
            $tileTypeRecord = new TileType();
        }

        foreach ((array) mysql_fetch_assoc($result) as $key => $value) {
            $tileTypeRecord->$key = $value;
        }

        if ($tileTypeRecord) {

            // Return the tile type record that was returned from the database.
            return $tileTypeRecord;
        }

        return false;
    }

    /**
     * Return all tile type records.
     *
     * @return array
     */
    public function findAll()
    {
        $strSql = ' select * from tileType where 1';

        $result = TileType::Query($strSql);

        $arrExpected = array(
            'id',
            'name',
            'description'
        );

        if ($result) {

            $tileTypeRecords = array();

            // Loop through each result while fetching an associative array of the results.
            while ($arrData = mysql_fetch_assoc($result)) {

                // Initialize a new tileType active record.
                $tileType = new TileType();

                foreach ($arrExpected as $key) {
                    $tileType->$key = $arrData[$key];
                    $tileTypeRecords[$tileType->id] = $tileType;
                }
            }

            // Return the tile types.
            return $tileTypeRecords;
        }

        return false;
    }
}
