<?php
namespace Generator\view\Tile\TileTypes;

/**
 * Represents single square of the 4 squares in each cell.
 */
class Land extends BaseTile
{
    /**
     * Returns this class as a divider.
     * The tiles need to be refractored into a OO way of determining how tiles are
     * printed.
     *
     * @return string
     */
    public function getString()
    {
        $strDiv = '<div class="tile">';

        $strDiv .= ' </div>';

        return $strDiv;
    }

    /**
     * Return a land icon.
     *
     * @return string
     */
    public function getTableData()
    {
        $strTableData = '<td class="tile ' . $this->getTileDisplayType() . '" style="background-color:OliveDrab;">';

        $strTableData .= ' </td>';

        return $strTableData;
    }
}
