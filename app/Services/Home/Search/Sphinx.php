<?php namespace App\Services\Home\Search;

use Lang;

/**
 * sphinx处理
 */
class Sphinx
{
    /**
     * sphinx client object
     * 
     * @var string
     */
    private $sphinx;

    /**
     * sphinx server
     * 
     * @var string
     */
    private $sphinxServer = '115.28.27.73';

    /**
     * sphinx port
     * 
     * @var string
     */
    private $sphinxPort = 9312;

    /**
     * 初始化sphinx客户端
     */
    public function initSphinxClient()
    {
        $this->sphinx = new \SphinxClient();
        dd($this->sphinx);
        $this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED);
        $this->sphinx->SetServer($this->getSphinxServer(), $this->getSphinxPort());
        return $this->sphinx;
    }

    /**
     * sphinx server
     * 
     * @param string $sphinxServer
     */
    public function setSphinxServer($sphinxServer)
    {
        $this->sphinxServer = $sphinxServer;
        return $this;
    }

    /**
     * get sphinx server
     * 
     * @return string
     */
    public function getSphinxServer()
    {
        return $this->sphinxServer;
    }

    /**
     * sphinx server
     * 
     * @param string $sphinxPort
     */
    public function setSphinxPort($sphinxPort)
    {
        $this->sphinxPort = $sphinxPort;
        return $this;
    }

    /**
     * get sphinx server
     * 
     * @return string
     */
    public function getSphinxPort()
    {
        return $this->sphinxPort;
    }

}