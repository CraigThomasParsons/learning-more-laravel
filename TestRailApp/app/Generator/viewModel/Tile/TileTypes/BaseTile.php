<?php
namespace Generator\view\Tile\TileTypes;

/**
 * Represents a tile.
 */
class BaseTile
{
    protected $tileDisplayType;

    /**
     * This function is called when a new instance of BaseTile is instantiated.
     */
    public function __construct()
    {

    }

    /**
     * Gets the value of tileDisplayType.
     *
     * @return mixed
     */
    public function getTileDisplayType()
    {
        return $this->tileDisplayType;
    }

    /**
     * Sets the value of tileDisplayType.
     *
     * @param mixed $tileDisplayType the tile display type
     *
     * @return self
     */
    public function setTileDisplayType($tileDisplayType)
    {
        $this->tileDisplayType = $tileDisplayType;

        return $this;
    }

    /**
     * [getTableData description]
     *
     * @return [type] [description]
     */
    public function getTableData()
    {
        $strTableData = '<td class="tile ' . $this->getTileDisplayType() . '">';

        $strTableData .= ' </td>';

        return $strTableData;
    }
}
