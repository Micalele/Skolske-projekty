<?php


class osobaU3
{
    private $oblast;
    private $ministerstvo;
    private $meno;
    private $od;
    private $do;
    private $pocetDni;

    /**
     * osobaU3 constructor.
     * @param $ministerstvo
     * @param $meno
     * @param $od
     * @param $do
     */
    public function __construct($ministerstvo, $meno, $od, $do)
    {
        $this->ministerstvo = $ministerstvo;
        $this->meno = $meno;
        $this->od = strtotime($od);
        if ($do == ""){
            $this->do = "-";
        }
        else {
            $this->do = strtotime($do);
        }
        if ($this->ministerstvo == "Ministerstvo vnútra" or $this->ministerstvo == "Ministerstvo vnútra a životného prostredia"){
            $this->oblast = "Vnútro";
        }
        elseif ($this->ministerstvo == "Ministerstvo školstva" or $this->ministerstvo == "Ministerstvo školstva a vedy" or $this->ministerstvo == "Ministerstvo školstva, mládeže a športu" or $this->ministerstvo == "Ministerstvo školstva, mládeže a telesnej výchovy" or $this->ministerstvo == "Ministerstvo školstva, vedy, mládeže a športu"){
            $this->oblast = "Školstvo";
        }
        elseif ($this->ministerstvo == "Ministerstvo zdravotníctva" or $this->ministerstvo == "Ministerstvo zdravotníctva a sociálnych vecí"){
            $this->oblast = "Zdravotníctvo";
        }
        elseif ($this->ministerstvo == "Ministerstvo financií" or $this->ministerstvo == "Ministerstvo financií, cien a miezd"){
            $this->oblast = "Financie";
        }
        elseif ($this->ministerstvo == "Ministerstvo dopravy" or $this->ministerstvo == "Ministerstvo dopravy a spojov" or $this->ministerstvo == "Ministerstvo dopravy, pôšt a telekomunikácií" or $this->ministerstvo == "Ministerstvo dopravy, spojov a verejných prác" or $this->ministerstvo == "Ministerstvo dopravy, výstavby a regionálneho rozvoja"){
            $this->oblast = "Doprava";
        }
        if ($this->do == "-") $this->pocetDni = "-";
        else $this->pocetDni = ($this->do - $this->od)/60/60/24;
    }

    /**
     * @return mixed
     */
    public function getMinisterstvo()
    {
        return $this->ministerstvo;
    }

    /**
     * @return mixed
     */
    public function getMeno()
    {
        return $this->meno;
    }

    /**
     * @return string
     */
    public function getOblast()
    {
        return $this->oblast;
    }

    /**
     * @return mixed
     */
    public function getOd()
    {
        return $this->od;
    }

    /**
     * @return mixed
     */
    public function getDo()
    {
        return $this->do;
    }

    /**
     * @return mixed
     */
    public function getPocetDni()
    {
        return $this->pocetDni;
    }


}