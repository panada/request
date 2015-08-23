<?php

namespace Panada\Request\Tests;

use Panada\Request;

class UriRootDomainTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_URI'] = '/cookies/me/and/you';
        
        $this->uri = (new Request\Uri)->fromServer();
    }
    
    public function testFrontController()
    {
        $this->assertTrue( ($this->uri->getFrontController() == 'index.php') );
    }
    
    public function testBasePath()
    {
        $this->assertTrue( ($this->uri->getBasePath() == '/') );
    }
    
    public function testPathInfo()
    {
        $this->assertTrue( ($this->uri->getPathInfo() == 'cookies/me/and/you') );
    }
    
    public function testLocation()
    {
        $this->assertTrue( ($this->uri->getLocation() == '/cookies/me/and/you') );
    }
    
    public function testPathSegment()
    {
        $this->assertTrue( ( is_array($this->uri->getPathSegment()) && count($this->uri->getPathSegment()) == 4 ) );
    }
    
    public function testGetSegment()
    {
        $this->assertTrue( ($this->uri->getSegment(0) == 'cookies') );
        $this->assertTrue( ($this->uri->getSegment(1) == 'me') );
        $this->assertTrue( ($this->uri->getController() == 'cookies') );
        $this->assertTrue( ($this->uri->getAction() == 'me') );
        $this->assertTrue( is_array($this->uri->getRequests()) && count($this->uri->getRequests()) == 2 && $this->uri->getRequests()[0] == 'and' && $this->uri->getRequests()[1] == 'you');
    }
    
    public function testGetAssetURI()
    {
        $this->assertTrue( ($this->uri->getAssetURI() == '/') );
        $this->assertTrue( ($this->uri->getAssetURI('style.css') == '/style.css') );
        
        // defined URI for assets
        $this->assertTrue( ($this->uri->setConfig(['assetPath' => '/static/'])->getAssetURI('style.css')) == '/static/style.css' );
        $this->assertTrue( ($this->uri->setConfig(['assetPath' => '/static/', 'assetBaseDomain' => 'https://cdn.mysite.com'])->getAssetURI('style.css')) == 'https://cdn.mysite.com/static/style.css' );
    }
}
