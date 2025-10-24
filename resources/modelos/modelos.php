<?php
class Tarifa {
    public $codigo;
    public $fecha_alta;
    public $fecha_baja;
    public $cantidad;
    public $nombre_usuario;
    public $email;
    public $imagen;
    public $tarifa;
    public $max_rebaja;
    public $precio_meses;

    public function __construct($codigo, $fecha_alta, $fecha_baja, $cantidad, $nombre_usuario, $email, $imagen, $tarifa, $max_rebaja, $precio_meses) {
        $this->codigo = $codigo;
        $this->fecha_alta = $fecha_alta;
        $this->fecha_baja = $fecha_baja;
        $this->cantidad = $cantidad;
        $this->nombre_usuario = $nombre_usuario;
        $this->email = $email;
        $this->imagen = $imagen;
        $this->tarifa = $tarifa;
        $this->max_rebaja = $max_rebaja;
        $this->precio_meses = $precio_meses;
    }
}