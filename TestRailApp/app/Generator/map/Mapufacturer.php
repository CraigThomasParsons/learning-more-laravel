<?php
namespace Generator\map;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Generator\helpers\Processing\CellProcessing;
use Generator\helpers\Processing\MountainProcessing;
use Generator\factories\MapGeneratorFactory;

// For use only in memory
use Generator\helpers\ModelHelpers\MapLoader;
use Generator\view\MapView;

// For use only in memory.
use Generator\helpers\ModelHelpers\Map as MapMemory;

// For saving the map to the database.
use Generator\model\MongoDatabase\Map as MapStorage;

use Generator\model\MongoDatabase\MapRepository as MapRepository;

use Generator\helpers\Processing\TreeProcessing;
use Generator\helpers\Processing\WaterProcessing;
use Generator\model\MongoDatabase\MongoMapLoader;
use Generator\model\MongoDatabase\WaterProcessingMongoDatabaseLayer;

/**
 * Still need to clean this up.
 * It would be better to create different controllers for the Cell and Tree creation.
 */
class Mapufacturer extends Controller
{
    const DEFAULT_HEIGHT_MAP_GENERATOR = 'Anarchy';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Returning the index view.
     *
     * @return string
     */
    public function commandListing()
    {

        //$map = new TempMap();
        //$map->id = 2;
        //$map->save();

        /*
        $sqlMap = new Map();
        $sqlMap->id = 1;
        $sqlMap->name = 'test';
        $sqlMap->description = 'test';
        $sqlMap->coordinateX = 0;
        $sqlMap->coordinateY = 0;
        $sqlMap->save();*/

        /*
        $mongo = LMongo::connection();
        $mongoDatabase = $mongo->getMongoDB();
        $collectionNames = $mongoDatabase->getCollectionNames();

        $mapTable = $mongoDatabase->map;*/

        //echo '<pre>'.print_r($maptest, true).'</pre>';
        return view('mapgen.index');
    }

    /**
     * This should run the height map generator and set up the basic cells.
     *
     * @param integer $mapId Primary key of the map.
     *
     * @return view
     */
    public function runFirstStep($mapId)
    {
        $map  = MapRepository::findFirst($mapId);
        $size = 38;

        if ($map == false) {
            $map = new MapStorage();
        }

        $map->state = 'Cell Processing started';

        // Save the map record to update the state.
        $mapId = $map->save();

        // List of all available height map generators.
        $mapGeneratorList = new MapGeneratorFactory();

        // Get the map generator from the Factory.
        $mapGenerator = $mapGeneratorList->getGenerator(self::DEFAULT_HEIGHT_MAP_GENERATOR);

        // Generate a key.
        //$mapGenerator->setSeed(sha1(md5(time())));
        $mapGenerator->setSeed('F349ig7hw3b4flqw3filb3fh9'.sha1(md5(time())).'p3f3434hf439h3d4fhhp8');
        $mapMemory = new MapMemory();

        // Load the map and reset the size.
        $mapMemory->setDatabaseRecord($map)->setSize($size);

        // Run the algorithm on the map.
        $mapGenerator->setMap($mapMemory)->runGenerator();

        $map->state = 'Cell Processing completed';

        // Save the map record.
        $mapId = $map->save();
    }

    /**
     * This is the tile step.
     * This will simply take the cells in the map
     * and change the child tiles to what the parent tile is.
     *
     * @param integer $mapId Primary key of the map.
     *
     * @return void
     */
    public function runSecondStep($mapId)
    {
        // All the cells in the current Map.
        $cells = MapRepository::findAllCells($mapId);

        // The reversed x and y made it easier to check if a row existed before iterating over it in the view.
        $tiles = MapRepository::findAllTilesReversedAxis($mapId);

        foreach ($tiles as $doesntMatter => $something) {
            foreach ($something as $doesntMatterEither => $tile) {

                $currentCell = $cells[$tile->getCellX()][$tile->getCellY()];

                if ($currentCell->name == 'Passable Land') {

                    $tile->name        = 'inner-Land';
                    $tile->description = 'Passable';
                    $tile->tileTypeId  = 1;

                } else if ($currentCell->name == 'Trees') {

                    $tile->name        = 'inner-Tree';
                    $tile->description = 'The default tree tile';
                    $tile->tileTypeId  = 29;

                } else if ($currentCell->name == 'Water') {

                    $tile->name        = 'inner-WaterTile';
                    $tile->description = 'The Inside Water Tile.';
                    $tile->tileTypeId  = 3;

                } else {

                    // Anything else becomes a Rock Tile.
                    $tile->name        = 'inner-Rock';
                    $tile->description = 'Rocky area.';
                    $tile->tileTypeId  = 2;
                }
                $tile->height = $currentCell->height;
                $tile->save();
            }
        }

        // Running this right after in prep for tree algorithms.
        $mapRecord = MapRepository::findFirst($mapId);
        $treeCells = MapRepository::findAllTreeCells($mapId);

        // Passing in tiles just doesn't actually matter at this point.
        // I won't be using the tiles in the hole punching process.
        $mapLoader = new MongoMapLoader($mapRecord->id, $tiles, $treeCells);
        $mapLoader->holePuncher($mapId);
    }

    /**
     * This will run the tree processing algorithm.
     *
     * @param integer $mapId Primary key of the map.
     *
     * @return void Does a redirect
     */
    public function runThirdStep($mapId)
    {
        // Create the tree processing class, which is the whole point of this step in the process.
        $size = 38;

        $map   = MapRepository::findFirst($mapId);
        $tiles = MapRepository::findAllTiles($mapId);

        $map->state = "running first step in tree algorithm";

        // Tell Map loader to link to tree step two.
        $map->set('nextStep', "treeStepSecond");
        $map->save();

        $mapRecord = MapRepository::findFirst($mapId);
        $treeCells = MapRepository::findAllTreeCells($mapId);
        $mapLoader = new MongoMapLoader($mapRecord->id, $tiles, $treeCells);
        $mapLoader->holePuncher($mapId);

        // Using this to process the tiles we need and start the work of randomizing tree tiles.
        $treeProcessing = new TreeProcessing($mapLoader);

        $treeProcessing->setMapLoader($mapLoader)->setIterations(20)->runJohnConwaysGameOfLife();

        // Invert What we just did.
        foreach ($tiles as $doesntMatter => $something) {
            foreach ($something as $doesntMatterEither => $tile) {

                if ($tile->tileTypeId == 29) {

                    $tile->name        = 'inner-Land';
                    $tile->description = 'Passable';
                    $tile->tileTypeId  = 1;

                } else if ($tile->tileTypeId == 1) {

                    $tile->name        = 'inner-Tree';
                    $tile->description = 'The default tree tile';
                    $tile->tileTypeId  = 29;

                }

                $tile->save();
            }
        }
        $mapLoader->killAllTreesInCell($mapId);
    }

    /**
     * This will run the tree processing algorithm
     * with the second step settings.
     *
     * @param integer $mapId Primary key of the map.
     *
     * @return void Does a redirect
     */
    public function runTreeStepTwo($mapId)
    {
        // Create the tree processing class, which is the whole point of this step in the process.
        $size = 38;
        $map  = $mapRecord = MapRepository::findFirst($mapId);

        // All the cells in the current Map.
        $cells = MapRepository::findAllCells($mapId);

        // All the tiles in the current map.
        $tiles     = MapRepository::findAllTiles($mapId);
        $treeCells = MapRepository::findAllTreeCells($mapId);
        $mapLoader = new MongoMapLoader($mapRecord->id, $tiles, $treeCells);
        $mapLoader->holePuncher($mapId);

        $map->state = "running third step in tree algorithm";
        $map->set('nextStep', "treeStepThird");
        $map->save();

        // Using this to process the tiles we need and start the work of randomizing tree tiles.
        $treeProcessing = new TreeProcessing($mapLoader);

        // Setting the amount of iterations to run when runJohnConwaysGameOfLife is called.
        $treeProcessing->setMapLoader($mapLoader)->setIterations(5);

        // Inverts the process. Life equals death.
        $treeProcessing->setBoolInvertSave(true);

        // This run should take a pretty long time.
        $treeProcessing->runJohnConwaysGameOfLife();

        // Purge Orphans will purge any tree tiles out on its own.
        // I ran the purgeOrphans twice, createLifeGrid is called twice as well.
        // I may have to get createLifeGrid to be cached.
        $treeProcessing->purgeOrphans(5);
        $treeProcessing->purgeOrphans(5);
        $treeProcessing->purgeOrphans(7);

        foreach ($tiles as $doesntMatter => $something) {
            foreach ($something as $doesntMatterEither => $tile) {

                $currentCell = $cells[$tile->getCellX()][$tile->getCellY()];

                if ($currentCell->name == 'Trees') {

                    $tile->name        = 'inner-Tree';
                    $tile->description = 'The default tree tile';
                    $tile->tileTypeId  = 29;

                } else if ($currentCell->name == 'Water') {

                    $tile->name        = 'inner-WaterTile';
                    $tile->description = 'The Inside Water Tile.';
                    $tile->tileTypeId  = 3;

                } else if ($currentCell->name == 'Impassable Rocks') {

                    // Anything else becomes a Rock Tile.
                    $tile->name        = 'inner-Rock';
                    $tile->description = 'Rocky area.';
                    $tile->tileTypeId  = 2;
                }
                $tile->save();
            }
        }
        //$mapLoader->killAllTreesInCell($mapId);
    }

    /**
     * This will run the water processing algorithm.
     *
     * @param integer $mapId Primary key of the map.
     *
     * @return view
     */
    public function runMapLoad($mapId)
    {
        $size = 38;

        // The reversed x and y made it easier to check if a row existed before iterating over it in the view.
        $map   = MapRepository::findFirst($mapId);
        $cells = MapRepository::findAllCells($mapId);
        $tiles = MapRepository::findAllTilesReversedAxis($mapId);

        $arrTemplateDependencies = array(
            'size' => $size,
            'cells' => $cells,
            'tiles' => $tiles,
            'mapId' => $mapId
        );

        if ($map->nextStep) {
            $arrTemplateDependencies['next'] = 'mapgen.' . $map->nextStep;
        }

        // echo "Going to run second step on MapId".$mapId;
        return view('mapgen.mapload', $arrTemplateDependencies);
    }

    /**
     * This will run the water processing algorithm.
     *
     * @param integer $mapId Primary key of the map.
     *
     * @return view
     */
    public function runFourthStep($mapId)
    {
        $size = 38;
        $map = MapRepository::findFirst($mapId);
        $waterTileLocations = MapRepository::findAllWaterTileCoordinates($mapId);

        // Initializing dependencies.
        $waterProcessingMongoDatabaseLayer = new WaterProcessingMongoDatabaseLayer($mapId);
        $waterProcessingMongoDatabaseLayer->setMapId($mapId);

        $mapMemory = new MapMemory();

        // Load the map and reset the size.
        $mapMemory->setDatabaseRecord($map)->setSize($size);

        // Water Processing setup.
        $WaterProcessor = new WaterProcessing($waterProcessingMongoDatabaseLayer);
        $WaterProcessor->setWaterTileLocations($waterTileLocations)
                       ->setMap($mapMemory);

        //echo "Going to run third step on MapId" . $mapId;
        //return Redirect::to('/Map/load/' . $mapId);
        $WaterProcessor->waterTiles();
    }

    /**
     * This will run the mountain tile processor.
     *
     * @param integer $mapId Primary key of the map.
     *
     * @return view
     */
    public function runLastStep($mapId, $mountainLine)
    {
        $map = MapRepository::findFirst($mapId);

        // I would like to write something that can trace each groupings of mountain cells.
        // Then record the cell count, if the count is less that 5 then leave it alone.
        // It will be hard to write something that can trace the outside of each mountain.
        //http://www.geeksforgeeks.org/find-number-of-islands/

        // This means you that I'll have to run the cell processor over and over again.
        echo "Going to run the last step on MapId" . $mapId.'
        ';

        // Mountain cell and tile processor in one.
        // Use mongo db to grab all the cells found that are higher than the mountain line.
        // Loop through the tiles in all of these cells and start determining the tile types at the edges.
        // You'll need to establish the tile locations by the cells.
        $mountainProcessor = new MountainProcessing();
        $mountains = MapRepository::findAllMountainCells($mapId, $mountainLine);

        if ($mountains) {
            $mountainProcessor->init()
                ->setTiles(MapRepository::findAllTiles($mapId))
                ->setMountainCells($mountains)
                ->setMountainLine($mountainLine)
                ->createRidges();
        }
    }

    /**
     * This isn't a function that will be here for ever.
     * It is mostly a test.
     * Save the mongo cells to mysql records.
     * todo
     * Add in uniqueId in mysql records.
     * Save the mongo id in there.
     */
    public function saveMongoToMysql($mapId)
    {
        echo '
<html>
<head>
<style>
body {
    background-color: black;
}
h1 {
    color: maroon;
    margin-left: 40px;
}
</style>
</head>
<body>
<pre>';

        $tiles = MapRepository::findAllTiles($mapId);

        foreach ($tiles as $rowOfTiles) {
            foreach ($rowOfTiles as $mongoTile) {
                echo '<div style="color:white;">';

                // Try to get the cell from sql first, if it doesn't exist, then create it.
                if ($mongoTile->cellId && is_object($mongoTile->cellId)) {
                    $uniqueId = $mongoTile->cellId->{'$id'};

                    $sqlCell = Cell::where('uniqueId', '=', $uniqueId)->first();
                }

                if ($sqlCell == null) {

                    $mongoCell = MapRepository::findCell($mongoTile->cellId->{'$id'});

                    $sqlCell = new Cell;
                    $sqlCell->uniqueId = $mongoCell->id->{'$id'};
                    $sqlCell->name = $mongoCell->name;
                    $sqlCell->description = $mongoCell->description;
                    $sqlCell->coordinateX = $mongoCell->coordinateX;
                    $sqlCell->coordinateY = $mongoCell->coordinateY;
                    $sqlCell->height = $mongoCell->height;
                    $sqlCell->map_id = $mongoCell->mapId;
                    $sqlCell->save();
                }
                $sqlTile = Tile::where('uniqueId', '=', $mongoTile->id->{'$id'})->first();
                if ($sqlTile == null) {
                    $sqlTile = new Tile();
                    $sqlTile->coordinateX = $mongoTile->coordinateX;
                    $sqlTile->coordinateY = $mongoTile->coordinateY;
                    $sqlTile->mapCoordinateX = $mongoTile->mapCoordinateX;
                    $sqlTile->mapCoordinateY = $mongoTile->mapCoordinateY;
                    $sqlTile->height = $mongoTile->height;
                    $sqlTile->map_id = $mongoTile->mapId;
                    $sqlTile->cell_id = $sqlCell->id;
                    $sqlTile->tileType_id = $mongoTile->tileTypeId;
                    $sqlTile->description = $mongoTile->description;
                    $sqlTile->name = $mongoTile->name;
                    $sqlTile->uniqueId = $mongoTile->id->{'$id'};
                    $sqlTile->save();
                }
            }
        }
        die('done</div></body></html>');
    }
}
