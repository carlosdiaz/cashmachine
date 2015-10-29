<?php

namespace ATMAppBundle\Controller;

use ATMAppBundle\Entity\ATM;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    private $currencyAvailables = array(100, 50, 20, 10);


    public function indexAction($name)
    {
        return $this->render('ATMAppBundle:Default:index.html.twig', array('name' => $name));
    }

    public function atmAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $atm = new ATM();
        $atm->setATM(380);                
        
        $form = $this->createFormBuilder($atm)                
            ->add('atm', 'text')            
            ->add('save', 'submit', array('label' => 'Retiro'))
            ->getForm();

        
        $form->handleRequest($request);

        if ($form->isValid()) {
            
     
            if ($request->isMethod('POST')) {

                $data = $request->request->get('form');                

                if($this->validateAmount($data['atm'])) {

                    $sOutput = $this->getAmount($data['atm']);
                    //echo $sOutput;
                    //return $this->render('ATMAppBundle:Default:form1.html.twig', $draw = $sOutput);
                    return new Response('<html><body> '.$sOutput.'</body></html>');

                }

                
            }

            
        }


        return $this->render('ATMAppBundle:Default:/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function getAmount($amount) {

        $i =0;
        $aOutput = array();
        $sOutput = "";


        foreach ($this->currencyAvailables as $currency) {
           

            $iTemporal = floor($amount/$currency);

            if ($iTemporal>0) {
                //$aOutput[$i]  = floor($amount/$currency). " billetes de ".$currency;

                $sOutput  = $sOutput. floor($amount/$currency). " billetes de ".$currency. "   ";
                if ($currency == 100) {
                    $sOutput = $sOutput ."<img src='http://imagenes.comosevive.com/mexico/100-pesos-mexicanos.jpg' alt='Billete height='72' width='72'><br /><br />";
                }
                else if ($currency == 50){
                 $sOutput = $sOutput ."<img src='http://imagenes.comosevive.com/mexico/50-pesos-mexicanos.jpg' alt='Billete height='72' width='72'><br /><br />";
                }
                else if ($currency == 20){
                 $sOutput = $sOutput ."<img src='http://imagenes.comosevive.com/mexico/20-pesos-mexicanos.jpg' alt='Billete height='72' width='72'><br /><br />";
                }
                else {
                 $sOutput = $sOutput ."<img src='http://st.depositphotos.com/2193716/2385/i/450/depositphotos_23859799-ten-mexican-peso-coin.jpg' alt='Billete height='72' width='42'><br /><br />"   ;
                }

            }

            $amount = $amount%$currency;

            if ($amount ==0){
                //we have finished
                break;
            }

            $i = $i+1;
        }
        return $sOutput;

    }

    public function validateAmount($amount) {
        $bReturn = False;

        if ($amount%10 ==0 && $amount >0) {
            $bReturn = True;
        }
        return $bReturn;

    }

}
