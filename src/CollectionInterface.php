<?php

namespace Live\Collection;

/**
 * Collection interface
 *
 * @package Live\Collection
 */
interface CollectionInterface
{
    /**
     * Returns a value by index
     *
     * @param string $index
     * @param mixed $defaultValue
     * @return mixed
     */
    public function get(string $index, $defaultValue = null);

    /**
     * Returns all elements of array
     *
     * @return array
     */
    public function getAll():array;

    /**
     * Adds a value to the collection
     *
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public function set(string $index, $value);

    /**
     * Checks whether the collection has the given index
     *
     * @param string $index
     * @return boolean
     */
    public function has(string $index);

    /**
     * Returns the count of items in the collection
     *
     * @return integer
     */
    public function count(): int;

    /**
     * Cleans the collection
     *
     * @return void
     */
    public function clean();
}
