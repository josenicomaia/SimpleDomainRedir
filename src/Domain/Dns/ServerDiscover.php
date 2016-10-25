<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain\Dns;

/**
 * Description of Discover
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class ServerDiscover {
    
    /**
     *
     * @var Resolver
     */
    private $resolver;
    
    /**
     *
     * @var string[]
     */
    private $dnsServers = [
        '8.8.8.8',
        '8.8.4.4',
        '208.67.222.222',
        '208.67.220.220'
    ];
    
    public function __construct(ResolverFactory $resolverFactory) {
        
        $this->resolver = $resolverFactory->make($this->dnsServers);
    }
    
    /**
     * 
     * @param string $domain
     * @param bool $resolved
     * @return string[]
     * @throws NoDnsServerFound
     */
    public function byDomain($domain, $resolved = true) {
        
        try {
            
            $nsList = $this->resolver->resolveNs($domain);
            
            if(count($nsList) > 0) {
                
                return ($resolved)? $this->resolveIpFromNsList($nsList) : $nsList;
            }
            
            if(($parent = $this->getParent($domain)) !== false) {
                
                return $this->byDomain($parent);
            }

            throw new NoDnsServerFound();
        } catch (DomainNotFound $ex) {
            
            return $this->byDomain($this->getParent($domain));
        }
    }
    
    /**
     * 
     * @param string[] $nsList
     * @return string[]
     */
    private function resolveIpFromNsList(array $nsList = []) {
        
        $result = [];
        
        foreach($nsList as $ns) {
            
            $result = array_merge($result, $this->resolver->resolveA($ns));
        }
        
        return $result;
    }
    
    /**
     * 
     * @param string $domain
     * @return boolean|string
     */
    private function getParent($domain) {
        
        if(($pos = strpos($domain, '.')) !== false) {
            
            return substr($domain, $pos + 1);
        } else if(strlen($domain) > 0) {
            
            return '';
        }
        
        return false;
    }
}
