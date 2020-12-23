<?php
namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumesExternalServices{

    public function makeRequest($method,$requestUrl,$queryParams=[],$formParams=[],
    $headers=[],$isBodyJson=false){
        $client = new Client([
            "base_uri" => $this->baseUri
        ]);

        if(method_exists($this,"resolveAuthorization")){
            $this->resolveAuthorization($headers,$formParams,$queryParams);
        }
        $response = $client->request($method,$requestUrl,array(
            $isBodyJson ? 'json' : 'form_params' => $formParams,
            'headers' => $headers,
            'query' => $queryParams
        ));

        $response = $response->getBody()->getContents();
        
        if(method_exists($this,"decodeResponse")){
            $response = $this->decodeResponse($response);
        }

        return $response;
    }
}