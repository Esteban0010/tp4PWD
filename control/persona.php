<?php
class Persona{
     
    private $nroDni;
    private $apellido;
    private $nombre;
    private $fechaNac;
    private $telefono;
    private $domicilio;

	public function __construct($nroDni, $apellido, $nombre, $fechaNac, $telefono, $domicilio) {

		$this->nroDni = $nroDni;
		$this->apellido = $apellido;
		$this->nombre = $nombre;
		$this->fechaNac = $fechaNac;
		$this->telefono = $telefono;
		$this->domicilio = $domicilio;
	}

    public function cargar($nroDni,$apellido ,$nombre, $fechaNac,$telefono,$domicilio)
    {
       $this->setNroDni($nroDni);
       $this->setApellido($apellido);
        $this->setNombre($nombre);
        $this->setFechaNac($fechaNac);
        $this->setTelefono($telefono);
        $this->setDomicilio($domicilio);
    }

	public function getNroDni() {
		return $this->nroDni;
	}

	public function setNroDni($value) {
		$this->nroDni = $value;
	}

	public function getApellido() {
		return $this->apellido;
	}

	public function setApellido($value) {
		$this->apellido = $value;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function setNombre($value) {
		$this->nombre = $value;
	}

	public function getFechaNac() {
		return $this->fechaNac;
	}

	public function setFechaNac($value) {
		$this->fechaNac = $value;
	}

	public function getTelefono() {
		return $this->telefono;
	}

	public function setTelefono($value) {
		$this->telefono = $value;
	}

	public function getDomicilio() {
		return $this->domicilio;
	}

	public function setDomicilio($value) {
		$this->domicilio = $value;
	}

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function Buscar($dni)
    {
        $base = new BaseDatos();
        $consultaViaje = 'SELECT * FROM persona WHERE NroDni = '.$dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row2 = $base->Registro()) {
                    $this->cargar($dni, $row2['Apellido'], $row2['Nombre'], $row2['fechaNac'], $row2['Telefono'], $row2['Domicilio']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function listar($condicion = '')
    {
        $arregloPersonas = null;
        $base = new BaseDatos();
        $consultaViajes = 'SELECT * FROM persona ';
        if ($condicion != '') {
            $consultaViajes = $consultaViajes.' WHERE '.$condicion;
        }
        $consultaViajes .= ' ORDER BY idempresa ';
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViajes)) {
                $arregloPersonas = [];
                while ($row2 = $base->Registro()) {
                    $nroDni = $row2['NroDni'];
                    $apellido = $row2['Apellido'];
                    $nombre = $row2['Nombre'];
                    $fechaNac = $row2['fechaNac'];
                    $telefono = $row2['Telefono'];
                    $domicilio = $row2['Domicilio'];
                    $persona = new Persona();
                    $persona->cargar($nroDni, $apellido, $nombre,$fechaNac,$telefono,$domicilio);
                    array_push($arregloPersonas, $persona);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $arregloPersonas;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE persona
                             SET Nombre='".$this->getNombre()."',Apellido='".$this->getEdireccion()."',fechaNac='".$this->getFechaNac()."',Telefono='".$this->getTelefono()."',Domicilio='".$this->getDomicilio()."' WHERE NroDni=".$this->getNroDni();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    
    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $dni = $this->getNroDni();
        $apellido =$this->getApellido();
        $nombre = $this->getEnombre();
        $fecha = $this->getFechaNac();
        $telefono = $this->getTelefono();
        $domicilio = $this->getDomicilio();

        $consultaInsertar = "INSERT INTO persona (NroDni,Apellido,Nombre,fechaNac,Telefono,Domicilio)
        VALUES ('{$dni}','{$apellido}','{$nombre}','{$fecha}', '{$telefono}', '{$domicilio}')";

         if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
                    $resp = true;
                } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }
    

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = 'DELETE FROM persona WHERE NroDni='.$this->getNroDni();
            if ($base->Ejecutar($consultaBorra)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function __toString(){

    }
}