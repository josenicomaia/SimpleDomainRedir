<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Requests;

use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Symfony\Component\Translation\TranslatorInterface;

/**
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
abstract class FormRequest extends Request implements ValidatesWhenResolved {

    use ValidatesWhenResolvedTrait;

    /**
     * The container instance.
     *
     * @var Container
     */
    protected $container;
    
    /**
     *
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Get the validator instance for the request.
     *
     * @return Validator
     */
    protected function getValidatorInstance()
    {
        $factory = $this->container->make(ValidationFactory::class);

        if (method_exists($this, 'validator')) {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }

        return $factory->make(
            $this->all(), $this->rules(), $this->messages(), $this->attributes()
        );
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));
    }

    /**
     * Determine if the request passes the authorization check.
     *
     * @return bool
     */
    protected function passesAuthorization()
    {
        if (method_exists($this, 'authorize')) {
            return $this->authorize();
        }

        return false;
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return mixed
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->forbiddenResponse());
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return Response
     */
    public function response(array $errors) {
        
        return new JsonResponse([
            
            $this->translator->trans('app.validation.keys.success') => false,
            $this->translator->trans('app.validation.keys.message') => $this->translator->trans('app.validation.message'),
            $this->translator->trans('app.validation.keys.errors') => $errors
        ], 422);
    }

    /**
     * Get the response for a forbidden operation.
     *
     * @return Response
     */
    public function forbiddenResponse()
    {
        return new Response('Forbidden', 403);
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  Validator  $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }

    /**
     * Set the container implementation.
     *
     * @param  Container  $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }
    
    /**
     * 
     * @param TranslatorInterface $translator
     * @return $this
     */
    public function setTranslator(TranslatorInterface $translator) {
        
        $this->translator = $translator;
        
        return $this;
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
}
