<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\component\interfaces;

interface ServiceInterface
{
    /**
     * Run service
     *
     * @return mixed
     */
    public function _run();

    /**
     * Stop service
     *
     * @return mixed
     */
    public function _stop();
}
    
