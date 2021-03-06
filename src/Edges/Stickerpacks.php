<?php
namespace WHATSAPP\SDK\Edges;

use WHATSAPP\SDK\API;
use WHATSAPP\SDK\APIEdge;
use WHATSAPP\SDK\APIRequest;
use WHATSAPP\SDK\Edges\Stickerpacks\Sticker;
use WHATSAPP\SDK\Edges\Stickerpacks\StickerpackID;

class Stickerpacks extends APIEdge{

    public const ENDPOINT = '/v1/stickerpacks';

    public function StickerpackID(): StickerpackID{
        return new StickerpackID($this->getAPI(),$this->getAPI()->getEndpoint().StickerpackID::ENDPOINT);
    }

    public function Sticker(): Sticker{
        return new Sticker($this->getAPI(),$this->getAPI()->getEndpoint().Sticker::ENDPOINT);
    }

    public function retrieve(?string $namespace=null){
        $request = new APIRequest(API::METHOD_GET,$this->getEndpoint().(!empty($namespace)?'?'.http_build_query(['namespace'=>$namespace]):''),[
            'Authorization: Bearer '.$this->getAPI()->getToken(),
        ]);
        return $this->getAPI()->execute($request);
    }

    public function create(string $publisher,string $name,?string $ios_app_store_link=null,?string $android_app_store_link=null){
        $json = [
            'publisher' => $publisher,
            'name' => $name,
        ];
        if($ios_app_store_link){
            $json['ios_app_store_link'] = $ios_app_store_link;
        }
        if($android_app_store_link){
            $json['android_app_store_link'] = $android_app_store_link;
        }
        $request = new APIRequest(API::METHOD_POST,$this->getEndpoint(),[
            'Authorization: Bearer '.$this->getAPI()->getToken(),
            'Content-Type: application/json',
        ],json_encode($json,JSON_FORCE_OBJECT));
        return $this->getAPI()->execute($request);
    }

}