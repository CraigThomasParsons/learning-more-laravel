<?php
namespace Generator\model\MongoDatabase;

use App\Models\TempTile;
/**
 * Sets up an initial Tile.
 * Should be used to start the temporary Mongo tiles.
 */
class Tile extends MongoModel
{
    protected $tileHelper;

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
        $this->data['mapCoordinateX'] = 0;
        $this->data['mapCoordinateY'] = 0;
        $this->data['cellId'] = '';
        $this->data['tileTypeId'] = 1;
        $this->data['name'] = 'Initial tile';
        $this->data['description'] = 'Initial tile';
        $this->data['height'] = 0;
    }

    /**
     * Set String Type
     *
     * @return self
     */
    public function setStrType($name)
    {
        $this->data['name'] = $name;

        return $this;
    }

    /**
     * set Tile Display Type
     */
    public function setTileDisplayType($tileDisplayType)
    {
        $this->data['tileDisplayType'] = $tileDisplayType;
        $this->name = $tileDisplayType;
    }

    /**
     * Gets the value of mapId.
     *
     * @return mixed
     */
    public function getMapId()
    {
        return $this->data['mapId'];
    }

    /**
     * Sets the value of mapId.
     *
     * @param mixed $mapId the map id
     *
     * @return self
     */
    public function setMapId($mapId)
    {
        return $this->data['mapId'];

        return $this;
    }

    /**
     * Return the parent cell's Y axis coordinates.
     *
     * @return integer
     */
    public function getCellY()
    {
        return ($this->mapCoordinateY - $this->coordinateY) / 2;
    }

    /**
     * Return the parent cell's X axis coordinates.
     *
     * @return integer
     */
    public function getCellX()
    {
        return ($this->mapCoordinateX - $this->coordinateX) / 2;
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
     * Return the Mongo database id.
     *
     * @return MongoId This is a MongoId Object
     */
    public function getMongoId()
    {
        if (isset($this->data['_id'])) {
            return $this->data['_id'];
        }

        return false;
    }

    /**
     * Save this record.
     */
    public function save()
    {
        if ($this->getMongoId() == false) {
            $tileRecord = new TempTile();
        } else {
            $tileRecord = TempTile::find($this->getMongoId());
        }

        foreach ($this->data as $key => $value) {
            $tileRecord->$key = $value;
        }

        $status = $tileRecord->save();

        if ($status) {
            foreach ($tileRecord as $key => $value) {
                $this->data[$key] = $value;
            }
            return $this->id;
        }

        return $status;
    }

    /**
     * Gets the value of tileHelper.
     *
     * @return mixed
     */
    public function getHelper()
    {
        return $this->tileHelper;
    }

    /**
     * Sets the value of tileHelper.
     *
     * @param mixed The tile helper
     *
     * @return self
     */
    public function setHelper($tileHelper)
    {
        $this->tileHelper = $tileHelper;

        return $this;
    }

    /**
     * Returns the StrType from the helper object.
     */
    public function getStrType()
    {
        if($this->tileHelper) {
            return $this->tileHelper->getStrType();
        }

        trigger_error("Member variable tileHelper wasn't defined");
    }

    /**
     * Just returns the Type Id from the tile Helper
     */
    public function getStrTypeId()
    {
        if($this->tileHelper) {
            return $this->tileHelper->getStrTypeId();
        }

        trigger_error("Member variable tileHelper wasn't defined");
    }

    /**
     * [getCellIntYaxisCoordinate description]
     *
     * @param [type] $intYaxisCoordinate [description]
     *
     * @return [type]
     */
    public function getCellIntYaxisCoordinate($intYaxisCoordinate)
    {
        if($this->tileHelper) {
            return $this->tileHelper->getCellIntYaxisCoordinate($intYaxisCoordinate);
        }

        trigger_error("Member variable tileHelper wasn't defined");
    }


    /**
     * [getCellIntXaxisCoordinate description]
     *
     * @param [type] $intXaxisCoordinate [description]
     *
     * @return [type]
     */
    public function getCellIntXaxisCoordinate($intXaxisCoordinate)
    {
        if($this->tileHelper) {
            return $this->tileHelper->getCellIntXaxisCoordinate($intXaxisCoordinate);
        }

        trigger_error("Member variable tileHelper wasn't defined");
    }

    /**
     * [getIntXaxisCoordinate description]
     *
     * @return [type]
     */
    public function getIntXaxisCoordinate()
    {
        if($this->tileHelper) {
            return $this->tileHelper->getIntXaxisCoordinate();
        }

        trigger_error("Member variable tileHelper wasn't defined");
    }

    /**
     * [getIntYaxisCoordinate description]
     *
     * @return [type]
     */
    public function getIntYaxisCoordinate()
    {
        if($this->tileHelper) {
            return $this->tileHelper->getIntYaxisCoordinate();
        }

        trigger_error("Member variable tileHelper wasn't defined");
    }

    /**
     * Checks to see if this type is not water.
     *
     * @return boolean
     */
    public function notWater()
    {
        if($this->tileHelper) {
            return ($this->getStrType() != 'inner-WaterTile');
        }

        trigger_error("Member variable tileHelper wasn't defined");
    }

    /**
     * Checks to see if this type is water.
     *
     * @return boolean
     */
    public function isWater()
    {
        if($this->tileHelper) {
            return ($this->getStrType() == 'inner-WaterTile');
        }

        trigger_error("Member variable tileHelper wasn't defined");
    }

    /**
     * Checks to see if this type is not water.
     *
     * @return boolean
     */
    public function notRocky()
    {
        if ($this->tileTypeId != 2) {
            return (($this->tileTypeId > 15) || ($this->tileTypeId < 4));
        }

        return false;        
    }

    /**
     * Checks to see if this type is water.
     *
     * @return boolean
     */
    public function isRocky()
    {
        return ((($this->tileTypeId > 3) && ($this->tileTypeId < 16)) || ($this->tileTypeId == 2));
    }

    /**
     * Trying to move static calls to Repository classes.
     * But this function is called in MapHelper.
     *
     * @return mixed
     */
    public static function findByMapCoordinates($mapId, $mapCoordinateX, $mapCoordinateY)
    {
        return TileRepository::findByMapCoordinates($mapId, $mapCoordinateX, $mapCoordinateY);
    }
}