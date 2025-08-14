<?php
namespace Generator\view\Tile\TileTypes;

/**
 * Represents single square of the 4 squares in each cell.
 */
class CliffSideTile extends BaseTile
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
        $strDiv = '<div class="tile ' . $this->getTileDisplayType() . '">';

        $strDiv .= ' </div>';

        return $strDiv;
    }

    /**
     * [getTableData description]
     *
     * @return [type] [description]
     */
    public function getTableData()
    {
        $strTableData = '<td class="tile ' . $this->getTileDisplayType() . '" style="background-color:gray;">';

        $strTableData .= ' </td>';

        return $strTableData;
    }
}
