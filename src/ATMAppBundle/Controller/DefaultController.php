<?php

namespace ATMAppBundle\Controller;

use ATMAppBundle\Entity\ATM;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    private $currencyAvailables = array(100, 50, 20, 10);   //The currencies availables in ATM

    
    //This is the action that will display the form and it will return the amount requested
    public function atmAction(Request $request)
    {

        $atm = new ATM();
        $atm->setATM(0);                
        
        $form = $this->createFormBuilder($atm)                
            ->add('atm', 'text')            
            ->add('save', 'submit', array('label' => 'Retiro'))
            ->getForm();

        
        $form->handleRequest($request);

        //Probably I will need to add more validations
        if ($form->isValid()) {
            
     
            if ($request->isMethod('POST')) {

                $data = $request->request->get('form');                

                if($this->validateAmount($data['atm'])) {

                    $sOutput = $this->getAmount($data['atm']);

                    //From what I read there are other ways of passing the parameters and let the twig file
                    // to generate the complete html with variables included
                    return new Response('<html><body> '.$sOutput.'</body></html>');

                }

                
            }

            
        }


        return $this->render('ATMAppBundle:Default:/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    //This function will return the amount requested if the input parameter is valid
    public function getAmount($amount) {

        $i =0;        
        $sOutput = "";


        foreach ($this->currencyAvailables as $currency) {
           

            $iTemporal = floor($amount/$currency);


            if ($iTemporal>0) {
                
                $sOutput  = $sOutput. floor($amount/$currency). " billetes de ".$currency. "   ";
                //Displaying the images, better way would be to have the images locally
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

    //Function to validate if we will be able to make the draw correctly
    public function validateAmount($amount) {
        $bReturn = False;

        if ($amount%10 ==0 && $amount >0) {
            $bReturn = True;
        }
        return $bReturn;

    }

}
