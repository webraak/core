<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\component\interfaces;

interface ControllerInterface
{
    /**
     * Main method
     *
     * if not a parameter
     *
     * @return mixed
     */
    public function _main();

    /**
     * Exception method
     *
     * if it is a parameter and not a method for it
     *
     * @return mixed
     */
    public function _exception();
}