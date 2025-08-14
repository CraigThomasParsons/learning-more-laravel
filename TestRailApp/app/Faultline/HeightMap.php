<?php
namespace App\Faultline;

/**
* Author: Craig Parsons
* Date of Creation: Monday February 08 2008
*/
Class HeightMap {

   /**
    * Array of heights (2 dimentional) value is the height.
    * @var array
    */
    public $heights = array();

    /**
     * void HeightMap::SetAllToMaximum(int top, int left,int bottom,int right,float Max)
     * @author Craig Parsons
     * Function name: SetAllToMaximum
     * Date of Creation: Sunday February 17 2008
     * Description: any height that is greater then
     * max will become max* Author: Craig Parsons
     * Function name: SetAllToMaximum
     * Date of Creation: Sunday February 17 2008
     * Description: any height that is greater then
     * max will become the maximum value.
     *
     *
     * @param integer $top
     * @param integer $left
     * @param integer $bottom
     * @param integer $right
     * @param float   $max
     *
     * @return void
     */
    public function setAllToMaximum($top, $left, $bottom, $right, $max) {

        $intXcoord = 0;
        $intZed = 0;
        $intHeight = $bottom - $top;
        $intWidth = $right - $left;

        for ($intZed = $top; $intZed < $intHeight; $intZed++) {
            for ($intXcoord = $left; $intXcoord < $intWidth; $intXcoord++) {
                if ($this->heights[$intXcoord][$intZed] > $maximum) {
                    $this->heights[$intXcoord][$intZed] = $maximum;
                    // Any height that is greater then
                    // max will become maximum
                }
            }
        }
    }

    /**
     * void HeightMap::FaultLine(int top, int left,int bottom,int right, int iterations)
     *
     * Date of Creation: Monday February 08 2008
     *
     * @author: Craig Parsons
     *
     * @param  int $top
     * @param  int $left
     * @param  int $bottom
     * @param  int $right
     * @param  int $iterations
     *
     * @return void
     */
    public function faultLine(int $top, int $left, int $bottom, int $right, int $iterations)
    {
        $intHeight = $bottom - $top;
        $intWidth = $right - $left;

        $p1 = new Point;
        $p2 = new Point;
        $p3 = new Point;

        $i=0;

        while($i < $iterations)
        {
            $p1->x = (int)(rand() % $intWidth);
            $p2->x = (int)(rand() % $intWidth);

            $p1->z = (int)(rand() % $intHeight);
            $p2->z = (int)(rand() % $intHeight);

            $v = $p1->subtract($p2);

            for($p3->z = 0; $p3->z < $intHeight; $p3->z++)
            {
                for($p3->x = 0; $p3->x < $intWidth; $p3->x++)
                {
                    $v2 = $p2.subtract($p3);

                    if(($v->z * $v2->x) - ($v->x * $v2->z) > 0)
                    {
                        $this->heights[(int)$p3->x][(int)$p3->z] = $this->heights[(int)$p3->x][(int)$p3->z] - 1;
                    } else {
                        $this->heights[(int)$p3->x][(int)$p3->z] = $this->heights[(int)$p3->x][(int)$p3->z] + 1;
                    }
                }
            }
            $i++;
        }

    }

    /*************************************
     * Author: Craig Parsons
     * Function name: RaiseMinto
     * Date of Creation: Sunday February 17 2008
     *****************************************/

    /**
     * void HeightMap::RaiseMinto(int top, int left,int bottom,int right,float num)
     * RaiseMin To description
     *
     * Date of Creation: Sunday February 17 2008
     */
    public function RaiseMinto(int $top, int $left, int $bottom,int $right, $num) {
        $floatNewMinHeight = (float)HeightMap::getMinHeight() + num;
        $this->SetAllToMinimum(top,left,bottom,right,NewMinHeight);
    }
}
