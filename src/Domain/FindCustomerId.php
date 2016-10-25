<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain;

use LayerShifter\TLDExtract\Extract as TLDExtract;
use SimpleDomainRedir\Domain\Dns\ResolverFactory;

/**
 * Description of FindCustomerId
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class FindCustomerId {
    
    /**
     *
     * @var ResolverFactory
     */
    private $resolverFactory;
    
    /**
     *
     * @var TLDExtract
     */
    private $tldExtract;
    
    public function __construct(
            ResolverFactory $resolverFactory,
            TLDExtract $tldExtract) {
        
        $this->resolverFactory = $resolverFactory;
        $this->tldExtract = $tldExtract;
    }
    
    /**
     * 
     * @param string[] $dnsServers
     * @param string $domain
     * @return string
     */
    public function withDnsServersByDomain(array $dnsServers, $domain) {
        
        $uri = $this->tldExtract->parse($domain);
        $resolver = $this->resolverFactory->make($dnsServers);
        $result = $resolver->resolveTxt($uri->getRegistrableDomain());
        
        return $this->filterRedirValue($result);
    }
    
    /**
     * 
     * @param string[] $txtRecords
     * @return string
     */
    private function filterRedirValue($txtRecords) {
        
        foreach($txtRecords as $txtRecord) {
            
            list($key, $value) = explode('=', $txtRecord, 2);
            
            if($key == 'redir') {
                
                return $value;
            }
        }
        
        return false;
    }
}
