<?php
namespace App\Faultline;

Class math
{
    /**
     * Generate Normal
     *
     * @param  float  $x1
     * @param  float  $y1
     * @param  float  $z1
     * @param  float  $x2
     * @param  float  $y2
     * @param  float  $z2
     * @param  float  $x3
     * @param  float  $y3
     * @param  float  $z3
     *
     * @return normal
     */
    public function genNormal (float $x1, float $y1, float $z1,
                               float $x2, float $y2, float $z2,
                               float $x3, float $y3, float $z3) {
         $len = 0;
         $v1x = 0;
         $v1y = 0;
         $v1z = 0;
         $v2x = 0;
         $v2y = 0;
         $v2z = 0;

         $v1x = $x2 - $x1;
         $v1y = $y2 - $y1;
         $v1z = $z2 - $z1;
         $v2x = $x3 - $x1;
         $v2y = $y3 - $y1;
         $v2z = $z3 - $z1;

         $normal = array();

         $normal[0] = $v1y * $v2z - $v1z * $v2y;
         $normal[1] = $v1z * $v2x - $v1x * $v2z;
         $normal[2] = $v1x * $v2y - $v1y * $v2x;

         $len = (float) sqrt ($normal[0]*$normal[0] + $normal[1] * $normal[1] +
          $normal[2] * $normal[2]);

         $normal[0] = $normal[0] / $len;
         $normal[1] = $normal[0] / $len;
         $normal[2] = $normal[0] / $len;

         return $normal;
    }
}
