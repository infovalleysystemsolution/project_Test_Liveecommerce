<?php

namespace Live\Collection;

/**
 * File collection
 *
 * @package Live\Collection
 */
class FileCollection implements FileInterface
{
    /**
     * Name of File
     *
     * @var string
     */
    protected $fileName;

    /**
     * Contents of File
     *
     * @var string
     */
    protected $contentsFile;

    /**
     * Pointer of File
     *
     * @var string
     */
    protected $pointerFile;

    /**
     * Status of File
     *
     * @var string
     */
    protected $statusFile;

    /**
     * Store of Colletion
     *
     * @var string
     */
    protected $storeColletion;
    
    /**
     * time for Colletion's expiration
     *
     * @var string
     */
    protected $expiration;

    /**
     *
     * Constructor
     */
    public function __construct($collection = null)
    {
        $this->fileName = "data.txt";
        $this->statusFile = false;
        $this->expiration = 10;
        if (!file_exists($this->fileName)) {
            $this->openFile('a');
            $this->closeFile();
        }
        if ($collection!=null) {
            $this->storeColletion = $collection;
        }
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setColletion($collection)
    {
        $this->storeColletion = $collection;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getExpiration():int
    {
        return $this->expiration;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setExpiration($expiration = 10)
    {
        $this->expiration = $expiration;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function openFile($modo)
    {
        if (!$this->statusFile) {
            $this->pointerFile = fopen("{$this->fileName}", "$modo");
            if ($this->pointerFile == false) {
                return false;
            }
        }
        return $this->statusFile = true;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function closeFile()
    {
        $this->statusFile = !fclose($this->pointerFile) ;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function isOpenFile()
    {
        return $this->statusFile ;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function readFile()
    {
        $this->storeColletion->clean();
        $temp = "";
        if ($this->openFile('r')) {
            while (!feof($this->pointerFile)) {
                $temp = fgets($this->pointerFile);
                $temp = explode("|", $temp);
                if (strtotime("now")<=$temp[2]) {
                    if (strpos($temp[1], "*") !==false) {
                        $this->storeColletion->set($temp[0], substr($temp[1], 1, strlen($temp[1])));
                    } elseif (strpos($temp[1], ";") !==false) {
                        $temp2 = explode(";", $temp[1]);
                        $this->storeColletion->set($temp[0], $temp2);
                    } else {
                        $this->storeColletion->set($temp[0], $temp[1]);
                    }
                }
            }
            $this->closeFile();
        }
    }

    /**
     *
     * {@inheritDoc}
     */
    public function writeFile()
    {
        $copy = $this->storeColletion->getAll();
        if ($this->openFile('w')) {
            while ($contents = current($copy)) {
                if (is_array($contents)) {
                    $contents = implode(";", $contents);
                }
                if (is_bool($contents)) {
                        $contents = $contents? "*true": "*false";
                }
                $text = key($copy)."|$contents|".strtotime("+{$this->expiration} minutes")."\n";
                fwrite($this->pointerFile, $text);
                next($copy);
            }
            $this->closeFile();
        }
    }

    /**
     *
     * {@inheritDoc}
     */
    public function obterElementCollection($key)
    {
        $this->readFile();
        return $this->storeColletion->get($key);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return $this->storeColletion->count();
    }
}
