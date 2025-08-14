<?php
namespace Generator\model\MongoDatabase;

use Illuminate\Support\Facades\DB;
use Generator\model\MongoDatabase\Tile;

/**
 * Store helper functions here for fetching data from the mongo database related to tiles.
 */
class TileRepository
{

    /**
     * Check for a tile record in the database,
     * if it doesn't exist return a new one.
     * To test this function
     *   use App\Models\TempTile;
     *
     * $tile = new TempTile();
     * $tile->mapCoordinateX = 0;
     * $tile->mapCoordinateY = 0;
     * $tile->mapId = 1;
     * $tile->save();
     *
     * Will need to write some validation into this function if more than one item is returned.
     *
     * @param integer $mapId       The map record's primary key
     * @param integer $coordinateX The x-axis co-ordinate
     * @param integer $coordinateY The y-axis co-ordinate
     *
     * @return Tile
     */
    public static function findByMapCoordinates($mapId, $mapCoordinateX, $mapCoordinateY)
    {
        $query = DB::connection('mongodb')->collection('Tile')
                                          ->where('mapCoordinateX', '=', intval($mapCoordinateX))
                                          ->where('mapCoordinateY', '=', intval($mapCoordinateY))
                                          ->where('mapId', '=', intval($mapId));

        $arrTiles = $query->get();

        if (count($arrTiles) > 0) {

            // Array of tiles are returned even though only one should be.
            $arrTile = array_pop($arrTiles);

            $tile = new Tile();
            $tile->populateFromArray($arrTile);

            // Return the tile record that was returned from the database.
            return $tile;

        } else {

            // Return a new tile record.
            return new Tile();
        }
    }
}