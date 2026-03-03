<?php
class Corretor
{

    private ?int $id = 0;
    private string $creci;
    private string $telefone;
    private string $whatsapp;
    private bool $ativo;

    public function __construct(
        ?int $id = 0,
        string $creci,
        string $telefone,
        string $whatsapp,
        bool $ativo

    ) {

        $this->id       = $id;
        $this->creci    = $creci;
        $this->telefone = $telefone;
        $this->whatsapp = $whatsapp;
        $this->ativo    = $ativo;
    }
    
    public function __get(string $prop)
    {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
        throw new  Exception("Propriedade {$prop} não existe");
    }

public function __set(string $prop, $valor)
    {
        switch ($prop) {
            case "id":
                $this->id = (int)$valor;
                break;
            case "creci":
                $this->creci = trim($valor);
            break;
            case "telefone":
                $this->telefone = trim($valor);
            break;
            case "whatsapp":
                $this->whatsapp = trim($valor);
            break;
            case "ativo":
                $this->ativo = (bool)$valor;
            break;
            default:
                throw new Exception("Propriedade {$prop} não permitida");
        }
    }

    public  function desativar(){
        
    }
}


$corretor = new Corretor(
    creci:      102030,
    telefone:   11944745585,
    whatsapp:   119774455,
    ativo: false    
);

print_r($corretor);
