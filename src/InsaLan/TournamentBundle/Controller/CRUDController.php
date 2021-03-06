<?php
namespace InsaLan\TournamentBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use InsaLan\TournamentBundle\Entity\Round;

class CRUDController extends Controller
{
    public function createRoundAction()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $match = $this->admin->getObject($id);

        if (!$match) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }


        $round = new Round();
        $round->setScore1(0);
        $round->setScore2(0);
        $round->setMatch($match);
        $match->addRound($round);

        $this->admin->create($round);
        $this->admin->update($match);


        $this->addFlash('sonata_flash_success', 'Round ajouté');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}

?>