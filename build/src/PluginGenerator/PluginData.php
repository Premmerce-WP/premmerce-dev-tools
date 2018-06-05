<?php namespace Premmerce\DevTools\PluginGenerator;

/**
 * Class PluginData
 * @package Premmerce\DevTools
 */
class PluginData
{

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $nameHumanized;

    /**
     * @var string
     */
    private $nameSpace;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $version;

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNameHumanized()
    {
        return $this->nameHumanized;
    }

    /**
     * @param mixed $nameHumanized
     */
    public function setNameHumanized($nameHumanized)
    {
        $this->nameHumanized = $nameHumanized;
    }

    /**
     * @return mixed
     */
    public function getNameSpace()
    {
        return $this->nameSpace;
    }

    /**
     * @param mixed $nameSpace
     */
    public function setNameSpace($nameSpace)
    {
        $nameSpace       = trim(preg_replace('/\\\\+/', '\\', $nameSpace), ' \/');
        $this->nameSpace = $nameSpace;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return array_pop(explode('\\', $this->nameSpace)) . 'Plugin';
    }

    /**
     * @return string
     */
    public function getMainFileName()
    {
        return $this->getName() . '.php';
    }

    /**
     * @return mixed
     */
    public function getNameSpaceJson()
    {
        return str_replace('\\', '\\\\', $this->nameSpace);
    }


}
