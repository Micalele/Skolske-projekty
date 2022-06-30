<?php


class stranyU4
{
    private $nazovStrany;
    private $skratka;
    private $ziskaneKresla;
    private $koalicia;
    private $volby;

    /**
     * stranyU4 constructor.
     * @param $nazovStrany
     * @param $skratka
     * @param $ziskaneKresla
     * @param $koalicia
     * @param $volby
     */
    public function __construct($nazovStrany, $skratka, $ziskaneKresla, $koalicia, $volby)
    {
        $this->nazovStrany = $nazovStrany;
        $this->skratka = $skratka;
        $this->ziskaneKresla = $ziskaneKresla;
        $this->koalicia = $koalicia;
        $this->volby = $volby;
    }

    /**
     * @return mixed
     */
    public function getNazovStrany()
    {
        return $this->nazovStrany;
    }

    /**
     * @return mixed
     */
    public function getSkratka()
    {
        return $this->skratka;
    }

    /**
     * @return mixed
     */
    public function getZiskaneKresla()
    {
        return $this->ziskaneKresla;
    }

    /**
     * @return mixed
     */
    public function getKoalicia()
    {
        return $this->koalicia;
    }

    /**
     * @return mixed
     */
    public function getVolby()
    {
        return $this->volby;
    }
}