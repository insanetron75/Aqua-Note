<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{
    /**
     * @Route("/genus")
     */
    public function listAction()
    {
        $em      = $this->getDoctrine()->getManager();
        $genuses = $em->getRepository('AppBundle:Genus')
                      ->findAllPublishedOrderByRecentlyActive();

        return $this->render("genus/list.html.twig", [
            'genuses' => $genuses
        ]);
    }

    /**
     * @Route("/genus/new", name="")
     */
    public function newAction()
    {
        $genus = new Genus();
        $genus->setName("Octopus" . rand(1, 100));
        $genus->setSubFamily("Octopodinae");
        $genus->setSpeciesCount(rand(100, 1000));

        $genusNote = new GenusNote();
        $genusNote->setUserName('AquaWeaver');
        $genusNote->setUserAvatarFileName('ryan.jpeg');
        $genusNote->setNote('I counted 8 legs...as they wrapped around me');
        $genusNote->setCreatedAt(new DateTime('-1 month'));
        $genusNote->setGenus($genus);

        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->persist($genusNote);
        $em->flush();

        return new Response('<html><body>genus created</body></html>');

    }

    /**
     * @Route("/genus/{genusName}", name="genus_show")
     * @param string $genusName
     *
     * @return Response
     */
    public function showAction(string $genusName)
    {
        $em    = $this->getDoctrine()->getManager();
        $genus = $em->getRepository("AppBundle:Genus")
                    ->findOneBy(['name' => $genusName]);
        /*
        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($funFact);
        if ($cache->contains($key)) {
            $funFact = $cache->fetch($key);
        } else {
            $funFact = $this->get('markdown.parser')
                ->transform($funFact);
            $cache->save($key, $funFact);
        }*/

        if (!$genus) {
            throw $this->createNotFoundException('genus not found');
        }

        $this->get('logger')
             ->info('Showing genus: ' . $genusName);

        $recentNotes = $em->getRepository('AppBundle:GenusNote')
            ->findAllRecentNotesForGenus($genus);

        return $this->render('genus/show.html.twig', [
            'genus' => $genus,
            'recentNoteCount' => count($recentNotes)
        ]);
    }

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction(Genus $genus)
    {
        $notes = [];
        foreach ($genus->getNotes() as $note) {
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUserName(),
                'avatarUri' => "/images/{$note->getUserAvatarFilename()}",
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y')
            ];
        }

        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }
}