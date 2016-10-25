<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain;

use SimpleDomainRedir\Domain\Dns\ServerDiscover;

/**
 * Description of ProcurarRedirecionamento
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class SearchRedirect {
    
    /**
     *
     * @var ServerDiscover
     */
    private $discover;
    
    /**
     *
     * @var FindCustomerId
     */
    private $findCustomerId;
    
    public function __construct(ServerDiscover $discover,
            FindCustomerId $findCustomerId) {
        
        $this->discover = $discover;
        $this->findCustomerId = $findCustomerId;
    }
    
    /**
     * 
     * @param string $domain
     * @return string
     */
    public function search($domain) {
        
        $dnsServers = $this->discover->byDomain($domain);
        $customerId = $this->findCustomerId->withDnsServersByDomain(
                $dnsServers,
                $domain);
        
        dd($domain, $customerId);
        
        return 'http://www.cash4lol.com';
    }
}
