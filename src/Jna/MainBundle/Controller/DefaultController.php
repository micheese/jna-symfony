<?php

namespace Jna\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jna\MainBundle\Entity\Enquiry;
use Jna\MainBundle\Form\EnquiryType;
use Symfony\Component\HttpFoundation\Request;

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
            ->findAll();

        return $this->render('mainBundle:Default:index.html.twig' , array(
            "projects"  => $projects,
            "workTypes" => $work_types,
            'form' => $form->createView()
        ));
    }
}
