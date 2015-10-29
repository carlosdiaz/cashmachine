<?php

namespace ATMAppBundle\Entity;

class ATM
{
    protected $amountToDraw;
    

    public function getATM()
    {
        return $this->amountToDraw;
    }

    public function setATM($amountToDraw)
    {
        $this->amountToDraw = $amountToDraw;
    }

    
}