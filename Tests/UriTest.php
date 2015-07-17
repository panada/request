<?php

namespace Panada\Request\Tests;

use Panada\Request;

class UriTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $_SERVER['SCRIPT_NAME'] = '/project/panada/labs/v2POC/public/index.php';
        $_SERVER['REQUEST_URI'] = '/project/panada/labs/v2POC/public/index.php/foo/bar/john/doe';
        
        $this->uri = (new Request\Uri)->fromServer();
    }
    
    public function testFrontController()
    {
        $this->assertTrue( ($this->uri->getFrontController() == 'index.php') );
    }
    
    public function testBasePath()
    {
        $this->assertTrue( ($this->uri->getBasePath() == '/project/panada/labs/v2POC/public/') );
    }
    
    public function testPathInfo()
    {
        $this->assertTrue( ($this->uri->getPathInfo() == 'foo/bar/john/doe') );
    }
    
    public function testLocation()
    {
        $this->assertTrue( ($this->uri->getLocation() == '/project/panada/labs/v2POC/public/index.php/foo/bar/john/doe') );
    }
    
    public function testPathSegment()
    {
        $this->assertTrue( ( is_array($this->uri->getPathSegment()) && count($this->uri->getPathSegment()) == 4 ) );
    }
    
    public function testGetSegment()
    {
        $this->assertTrue( ($this->uri->getSegment(0) == 'foo') );
        $this->assertTrue( ($this->uri->getSegment(1) == 'bar') );
        $this->assertTrue( ($this->uri->getController() == 'foo') );
        $this->assertTrue( ($this->uri->getAction() == 'bar') );
        $this->assertTrue( is_array($this->uri->getRequests()) && count($this->uri->getRequests()) == 2 && $this->uri->getRequests()[0] == 'john' && $this->uri->getRequests()[1] == 'doe');
    }
    
    public function testGetAssetURI()
    {
        $this->assertTrue( ($this->uri->getAssetURI() == '/project/panada/labs/v2POC/public/') );
        $this->assertTrue( ($this->uri->getAssetURI('style.css') == '/project/panada/labs/v2POC/public/style.css') );
        
        // defined URI for assets
        $this->assertTrue( ($this->uri->setConfig(['assetPath' => '/static/'])->getAssetURI('style.css')) == '/static/style.css' );
        $this->assertTrue( ($this->uri->setConfig(['assetPath' => '/static/', 'assetBaseDomain' => 'https://cdn.mysite.com'])->getAssetURI('style.css')) == 'https://cdn.mysite.com/static/style.css' );
    }
}
