<?php
namespace Generator\model\MongoDatabase;

use App\Models\TempCell;
use Generator\model\Coordinates;
use Generator\model\MongoDatabase\CellRepository;

/**
 * Sets up an initial Cell.
 * Should be used to start the temporary Mongo tiles.
 */
class Cell extends MongoModel
{

    /**
     * Any empty string value
     * is just a indicator that the field exists.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->data['mapId'] = '';
        $this->data['coordinateX'] = 0;
        $this->data['coordinateY'] = 0;
        $this->data['name'] = 'Initial Cell';
        $this->data['description'] = 'Initial Cell';
        $this->data['height'] = 0;
    }

    /**
     * Return the current Y coordinate.
     *
     * @return integer
     */
    public function getY()
    {
        return $this->data['coordinateY'];
    }

    /**
     * Return the current X coordinate.
     *
     * @return integer
     */
    public function getX()
    {
        return $this->data['coordinateX'];
    }

    /**
     * Gets the value of Id.
     *
     * @return mixed
     */
    public function getId()
    {
        if (isset($this->data['_id'])) {
            return $this->data['_id'];
        } else {
            return false;
        }
    }

    /**
     * Sets the value of Id.
     *
     * @param mixed $mapId the map id
     *
     * @return self
     */
    public function setId($mapId)
    {
        return $this->data['_id'];

        return $this;
    }

    /**
     * Save this record.
     * return id.
     */
    public function save()
    {
        if ($this->id) {
            $cellRecord = TempCell::find($this->id);
        } else {
            $cellRecord = new TempCell();
        }

        foreach ($this->data as $key => $value) {
            $cellRecord->$key = $value;
        }
        $cellRecord->save();

        return $cellRecord->id;
    }

    /**
     * Trying to move static calls to Repository classes.
     * But this function is called in MapHelper.
     *
     * @return mixed
     */
    public static function findByCoordinates($mapId, $mapCoordinateX, $mapCoordinateY)
    {
        return CellRepository::findByCoordinates($mapId, $mapCoordinateX, $mapCoordinateY);
    }

    /**
     * Just adding tile locations based on these cell coordinates.
     */
    public function addTileLocations(&$arrTileLocations)
    {
        for ($firstOffset=0; $firstOffset < 2; $firstOffset++) {
            for ($secondOffset=0; $secondOffset < 2; $secondOffset++) {
                $x = ($this->getX() * 2) + $firstOffset;
                $y = ($this->getY() * 2) + $secondOffset;
                $arrTileLocations[$x][$y] = 1;
            }
        }
    }

}
