<?php

class Imagen{
    // private Peticion $peticion;
    // se cambio de tipo Peticion a string ya que se creaba una referencia circular y hacia al sistema mas pesado en vano
    private string $nroPet;
    private string $nroImg;
    private string $extension;
    private array $valid_formats=[
        "jpeg",
        "jpg",
        "png"
    ];
    public function __construct(string $nroPet, string $nroImg, string $extension){
        $this->nroPet=$nroPet;
        $this->nroImg=$nroImg;
        $this->extension=$extension;
        
    }

    public function showImagen(){
        if (__FILE__==get_included_files()[0]){
            // return "../../public/imagenes/".$this->peticion.getNro().".".$this->nroImg.".".$this->extension;
            return $this->nroPet.".".$this->nroImg.".".$this->extension;
        }else{
            // return "imagenes/".$this->peticion.getNro().".".$this->nroImg.".".$this->extension;
            return $this->nroPet.".".$this->nroImg.".".$this->extension;
        }
    }
    public function checkFormat(string $imagen){

    }
}

// if (__FILE__==get_included_files()[0]){

// }
