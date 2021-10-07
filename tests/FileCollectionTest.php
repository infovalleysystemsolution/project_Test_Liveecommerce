<?php

namespace Live\Collection;

use PHPUnit\Framework\TestCase;

class FileCollectionTest extends TestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function objectCanBeConstructed()
    {
        $file = new FileCollection();
        return $file;
    }

     /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function nameFileCanBeReturnedCorrectly()
    {
        $file = new FileCollection();
        $this->assertEquals("data.txt", $file->getFileName());
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @depends nameFileCanBeReturnedCorrectly
     * @doesNotPerformAssertions
     */
    public function objectMemoryCollectionCanBeAddedInFileColletion()
    {
        $collection = new MemoryCollection();
        $collection->set('index1', 'value');
        $collection->set('index2', 5);
        $collection->set('index3', true);
        $collection->set('index4', 6.5);
        $collection->set('index5', ['data']);
        $file = new FileCollection();
        $file->setColletion($collection);
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @depends nameFileCanBeReturnedCorrectly
     * @depends objectMemoryCollectionCanBeAddedInFileColletion
     * @doesNotPerformAssertions
     */
    public function objectMemoryCollectionCanBeSavedInFileOfFileColletion()
    {
        $collection = new MemoryCollection();
        $collection->set('index1', 'value');
        $collection->set('index2', 5);
        $collection->set('index3', true);
        $collection->set('index4', 6.5);
        $collection->set('index5', ['data']);
        $file = new FileCollection();
        $file->setColletion($collection);
        $file->writeFile();
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @depends nameFileCanBeReturnedCorrectly
     * @depends objectMemoryCollectionCanBeAddedInFileColletion
     * @depends objectMemoryCollectionCanBeSavedInFileOfFileColletion
     * @doesNotPerformAssertions
     */
    public function dataCanBeReadOfFileStoredColletion()
    {
        $collection = new MemoryCollection();
        $file = new FileCollection();
        $file->setColletion($collection);
        $file->readFile();
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @depends nameFileCanBeReturnedCorrectly
     * @depends objectMemoryCollectionCanBeAddedInFileColletion
     * @depends objectMemoryCollectionCanBeSavedInFileOfFileColletion
     * @depends dataCanBeReadOfFileStoredColletion
     */
    public function getDataCanBeReturnedColletionForIndex()
    {
        $collection = new MemoryCollection();
        $file = new FileCollection();
        $file->setColletion($collection);
        $file->readFile();
        $this->assertEquals("5", $file->obterElementCollection('index2'));
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @depends nameFileCanBeReturnedCorrectly
     * @depends objectMemoryCollectionCanBeAddedInFileColletion
     */
    public function dontGetDataCanBeReturnedColletionForIndex()
    {
        $collection = new MemoryCollection();
        $collection->set('index1', 'value');
        $collection->set('index2', 5);
        $collection->set('index3', true);
        $collection->set('index4', 6.5);
        $collection->set('index5', ['data']);
        $file = new FileCollection();
        $file->setExpiration(-10);
        $file->setColletion($collection);
        $file->writeFile();
        $file->readFile();
        $this->assertNotEquals("5", $file->obterElementCollection('index2'));
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @depends nameFileCanBeReturnedCorrectly
     * @depends objectMemoryCollectionCanBeAddedInFileColletion
     */
    public function countElementsByMemoryColletion()
    {
        $collection = new MemoryCollection();
        $collection->set('index1', 'value');
        $collection->set('index2', 5);
        $collection->set('index3', true);
        $collection->set('index4', 6.5);
        $collection->set('index5', ['data']);
        $file = new FileCollection();
        $file->setColletion($collection);
        $file->writeFile();
        $file->readFile();
        $this->assertEquals("5", $file->count());
    }
}
