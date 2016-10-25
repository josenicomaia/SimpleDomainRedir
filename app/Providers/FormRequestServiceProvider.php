<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers;

use App\Http\Requests\CustomRequestInterface;
use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

/**
 * Description of RequestProvider
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class FormRequestServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        
        $this->configureFormRequests();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Configure the form request related services.
     *
     * @return void
     */
    protected function configureFormRequests() {
        
        $this->app->afterResolving(function (ValidatesWhenResolved $resolved) {
            
            $resolved->validate();
        });
        
        $this->app->resolving(function (FormRequest $request, $app) {
            
            $this->initializeRequest($request, $app['request']);
            $request->setContainer($app)
                    ->setTranslator($app->make('translator'));
        });
    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param  CustomRequestInterface  $form
     * @param  Request  $current
     * @return void
     */
    protected function initializeRequest(FormRequest $form, Request $current) {
        
        $files = $current->files->all();
        $files = is_array($files)? array_filter($files) : $files;
        
        $form->initialize(
                $current->query->all(), 
                $current->request->all(), 
                $current->attributes->all(), 
                $current->cookies->all(), 
                $files, 
                $current->server->all(), 
                $current->getContent()
        );
        
        if ($session = $current->getSession()) {
            
            $form->setSession($session);
        }
        
        $form->setUserResolver($current->getUserResolver());
        $form->setRouteResolver($current->getRouteResolver());
    }

}
