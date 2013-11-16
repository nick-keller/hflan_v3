<?php

namespace hflan\DocumentBundle\Controller;

use hflan\DocumentBundle\Entity\Document;
use hflan\DocumentBundle\Form\DocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UploadableManager
     */
    private $uploadableManager;

    /**
     * @Secure(roles="ROLE_DOCUMENT")
     * @Template
     */
    public function indexAction()
    {
        $documents = $this->em->getRepository('hflanDocumentBundle:Document')->findAll();

        return array(
            'documents' => $documents,
        );
    }

    /**
     * @Secure(roles="ROLE_DOCUMENT")
     * @Template
     */
    public function newAction(Request $request)
    {
        $document = new Document;
        $form = $this->createForm(new DocumentType, $document);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($document);
                if($document->getFile()) $this->uploadableManager->markEntityToUpload($document, $document->getFile());
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_doc_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Secure(roles="ROLE_DOCUMENT")
     * @Template
     */
    public function editAction(Request $request, Document $document)
    {
        $form = $this->createForm(new DocumentType, $document);

        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if($form->isValid()){
                $this->em->persist($document);
                if($document->getFile()) $this->uploadableManager->markEntityToUpload($document, $document->getFile());
                $this->em->flush();

                return $this->redirect($this->generateUrl('hflan_doc_admin'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @PreAuthorize("hasRole('ROLE_REMOVE') and hasRole('ROLE_DOCUMENT')")
     * @Template
     */
    public function removeAction(Document $document)
    {
        $this->em->remove($document);
        $this->em->flush();

        return $this->redirect($this->generateUrl('hflan_doc_admin'));
    }

    /**
     */
    public function downloadAction(Document $document)
    {
        if(!file_exists($document->getPath()))
            throw new \Symfony\Component\Config\Definition\Exception\Exception($document->getPath());
        $response = new Response();
        $response->headers->set('Content-Type', "application/pdf");
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$document->getSlug().'.pdf"');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Content-Length', filesize($document->getPath()));
        $response->setStatusCode(200);
        $response->setContent(file_get_contents($document->getPath()));

        return $response;
    }

    /**
     * @Secure(roles="ROLE_DOCUMENT")
     */
    public function moveAction(Request $request, Document $document, $dir)
    {
        $document->setSortIndex(max(0, $document->getSortIndex() + $dir));
        $this->em->persist($document);
        $this->em->flush();

        return $this->redirect($this->generateUrl('hflan_doc_admin'));
    }
}
