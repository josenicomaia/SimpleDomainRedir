<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain\Dns;

use SimpleDomainRedir\Domain\Dns\ResourceRecord;

/**
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
abstract class Resolver {
    
    /**
     * 
     * @param string $domain
     * @param string $type
     * @return ResourceRecord[]
     * @throws DomainNotFound
     */
    public abstract function query($domain, $type = 'A', $class = 'IN');
    
    /**
     * 
     * @param string $domain
     * @return string[]
     * @throws DomainNotFound
     */
    public function resolveNs($domain) {
        
        $nsList = [];
        $result = $this->query($domain, 'NS');
        
        foreach($result as $rr) {

            $nsList[] = $rr->nsdName();
        }
        
        return $nsList;
    }
    
    /**
     * 
     * @param string $domain
     * @return string[]
     * @throws DomainNotFound
     */
    public function resolveA($domain) {
        
        $aList = [];
        $result = $this->query($domain, 'A');
        
        foreach($result as $rr) {

            $aList[] = $rr->address();
        }
        
        return $aList;
    }
    
    /**
     * 
     * @param string $domain
     * @return string[]
     */
    public function resolveTxt($domain) {
        
        $txtList = [];
        $result = $this->query($domain, 'TXT');
        
        foreach($result as $rr) {
            
            $txtList = array_merge($txtList, $rr->text());
        }
        
        return $txtList;
    }
}
