<?php
namespace Generator\model\MongoDatabase;

use Illuminate\Support\Facades\DB;
use Generator\model\MongoDatabase\Cell;

/**
 * Store helper functions here for fetching data from the mongo database related to Cells.
 */
class CellRepository
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
    public static function findByCoordinates($mapId, $coordinateX, $coordinateY)
    {
        $query = DB::connection('mongodb')->collection('Cell')
                                          ->where('coordinateX', '=', intval($coordinateX))
                                          ->where('coordinateY', '=', intval($coordinateY))
                                          ->where('mapId', '=', intval($mapId));

        $arrCell = $query->get();

        if (count($arrCell) > 0) {
            // $query->get() unfortunately returns an array.
            foreach ($arrCell as $key => $arrValues) {

                $Cell = new Cell();
                $Cell->populateFromArray($arrValues);
            }

            // Return the cell record that was returned from the database.
            return $Cell;

        } else {

            // Return a new cell record.
            return new Cell();
        }
    }

    /**
     * Check to see if there is a cell already there.
     *
     * @return [type]
     */
    public static function findFirst()
    {

    }
}