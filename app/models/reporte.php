<?php


class Reporte{
    private int $nroRep;
    private string $fechaDesde;
    private string $fechaHasta;
    private int $cantPet;
    private int $cantFirmas;

    public function __construct(int $nroRep, string $fechaDesde, string $fechaHasta, int $cantPet, int $cantFirmas){
        $this->nroRep=$nroRep;
        $this->fechaDesde=$fechaDesde;
        $this->fechaHasta=$fechaHasta;
        $this->cantPet=$cantPet;
        $this->cantFirmas=$cantFirmas;
    }
}