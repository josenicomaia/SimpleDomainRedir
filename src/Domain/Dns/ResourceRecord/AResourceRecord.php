<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain\Dns\ResourceRecord;

/**
 * Description of AResourceRecord
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class AResourceRecord extends ResourceRecord {
    
    /**
     *
     * @var string
     */
    private $address;
    
    public function __construct($address, $name, $type, $class, $ttl) {
        
        parent::__construct($name, $type, $class, $ttl);
        $this->address = $address;
    }
    
    public function address() {
        
        return $this->address;
    }

}
