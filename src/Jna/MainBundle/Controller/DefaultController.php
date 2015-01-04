<?php

namespace Jna\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jna\MainBundle\Entity\Enquiry;
use Jna\MainBundle\Form\EnquiryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $doctrine_entity = $this->getDoctrine();
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Demande provenant du site internet JNA renovation.')
                    ->setFrom($enquiry->getEmail())
                    ->setTo('michael_chemani@hotmail.com')
                    ->setBody($this->renderView('mainBundle:Default:email-template.html.twig', array(
                        'enquiry' => $enquiry
                    )));
                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->Add('notice', 'Votre demande a bien été transmise. Notre équipe communiquera avec vous sous peu. Merci!');

            }
        }

        $projects = $doctrine_entity
            ->getRepository('mainBundle:Project')
            ->findAll();

        $work_types = $doctrine_entity
            ->getRepository('mainBundle:WorkType')
            ->findBy(array(), array('type' => 'ASC'));

        return $this->render('mainBundle:Default:index.html.twig' , array(
            "projects"  => $projects,
            "workTypes" => $work_types,
            'form' => $form->createView()
        ));
    }

    public function invoiceAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {

            $customers        = $_POST['invoice_client'];
            $customers_adress = $_POST['invoice_adress'];
            $invoice_date     = $_POST['invoice_date'];
            $materials        = $this->formatMaterials($_POST['material'] , $_POST['price']);

            var_dump($_POST);
            exit();

            $html = $this->renderView('mainBundle:Default:invoice_pdf.html.twig', array(
                'customers' => 'customers',
                'customers_adress' => 'customers_adress',
                'invoice_date'     => 'invoice_date',
                'materiaux'        => 'materiaux',
                'divers'           => 'divers',
                'main_oeuvre'      => 'main_oeuvre',
            ));

            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="file.pdf"'
                )
            );
        }

        return $this->render('mainBundle:Default:invoice.html.twig');
    }

    private function formatMaterials($materials_name , $material_prices)
    {
        $subtotal_materials = 0;

        foreach($materials_name as $key=>$mn){

            $materials['recap'][] = $mn . ' - ' . $material_prices[$key] . ' $';
            $subtotal_materials   +=  $material_prices[$key];
        }

        $materials['subtotal'] = $subtotal_materials;

        return $materials;
    }
}
