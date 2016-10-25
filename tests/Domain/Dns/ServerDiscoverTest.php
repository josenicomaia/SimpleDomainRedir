<?php

use SimpleDomainRedir\Domain\Dns\NsResourceRecord;
use SimpleDomainRedir\Domain\Dns\ServerDiscover;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServerDiscoverTest
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class ServerDiscoverTest extends TestCase {
    
    /**
     *
     * @var ServerDiscover
     */
    private $serverDiscover;
    
    public function setUp() {
        
        parent::setUp();
        $this->serverDiscover = $this->app->make(ServerDiscover::class);
    }
    
    public function test_discover_user_subdomain() {
        
        $result = $this->serverDiscover->byDomain('redir.maia.tech.');
        $this->assertGreaterThan(0, count($result));
        
        foreach($result as $rr) {
            
            $this->assertInstanceOf(NsResourceRecord::class, $rr);
        }
    }
    
    public function test_discover_nonexistent_user_subdomain() {
        
        $result = $this->serverDiscover->byDomain('blaredirbla.maia.tech.');
        $this->assertGreaterThan(0, count($result));
        
        foreach($result as $rr) {
            
            $this->assertInstanceOf(NsResourceRecord::class, $rr);
        }
    }
    
    public function test_discover_user_domain() {
        
        $result = $this->serverDiscover->byDomain('maia.tech.');
        $this->assertGreaterThan(0, count($result));
        
        foreach($result as $rr) {
            
            $this->assertInstanceOf(NsResourceRecord::class, $rr);
        }
    }
    
    public function test_discover_nonexistent_user_domain() {
        
        $result = $this->serverDiscover->byDomain('blaredirbla.com.');
        $this->assertGreaterThan(0, count($result));
        
        foreach($result as $rr) {
            
            $this->assertInstanceOf(NsResourceRecord::class, $rr);
        }
    }
    
    public function test_discover_tld_domain() {
        
        $result = $this->serverDiscover->byDomain('tech.');
        $this->assertGreaterThan(0, count($result));
        
        foreach($result as $rr) {
            
            $this->assertInstanceOf(NsResourceRecord::class, $rr);
        }
    }
    
    public function test_discover_root_domain() {
        
        $result = $this->serverDiscover->byDomain('.');
        $this->assertGreaterThan(0, count($result));
        
        foreach($result as $rr) {
            
            $this->assertInstanceOf(NsResourceRecord::class, $rr);
        }
    }
    
}
