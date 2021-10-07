<?php

namespace Live\Collection;

/**
 * File interface
 *
 * @package Live\Collection
 */
interface FileInterface
{
    /**
     * Set Colletion for store
     * @param  collection for store
     *
     * @return void
     */
    public function setColletion($collection);

    /**
     * Get a name to the file
     *
     * @return string
     */
    public function getFileName();

    /**
     * Return time for Colletion's expiration
     *
     * @return integer
     */
    public function getExpiration():int;

    /**
     * Set time for Colletion's expiration
     *
     * @param time for Colletion's expiration
     *
     * @return void
     */
    public function setExpiration(int $expiration);
            
    /**
     * Open/create file and return true if sucess or false in case fail
     *
     * @param string $modo
     * @return boolean
     */
    public function openFile($modo);

    /**
     * Close file
     *
     * @return void
     */
    public function closeFile();

    /**
     * Checks if file openned
     *
     * @return boolean
     */
    public function isOpenFile();

    /**
     * Read file and store in string
     *
     * @return boolean
     */
    public function readFile();

    /**
     * Write string in file
     *
     * @return boolean
     */
    public function writeFile();

    /**
     * Print file
     *
     * @param string $key
     * @return value of index ColletionMemory
     */
    public function obterElementCollection($key);

    /**
     * Returns the count of items in the collection
     *
     * @return integer
     */
    public function count(): int;
}
