<?php
namespace App\Api\Action;


use App\Entity\EntityBase;
use App\Entity\Match;
use App\Entity\Score;
use App\Events\SneakEvent;
use App\Utils\RequestTransformer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class MatchController
{
    // Dispatcher Event
    private $dispatcher;
    // Data persistence
    private $managerRegistry = null;
    // Object serializer
    private $serializer = null;
    // Dependences Injection
    public function __construct(EventDispatcherInterface $dispatcher,ManagerRegistry $managerRegistry,SerializerInterface $serializer)
    {
        $this->managerRegistry = $managerRegistry;
        $this->serializer = $serializer;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/bnzsa/match-data", methods={"POST"})
     *
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        $matchJson = RequestTransformer::getRequiredField($request, 'match');

        $data = $this->reportMatchData($matchJson);

        $jsonResponse = $this->prepareJsonResponse($data);

        return new Response($jsonResponse);
    }

    /**
     * @param $object
     * @return string
     */
    public function prepareJsonResponse($object) {

        return $this->serializer->serialize([$object],'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
    }

    /**
     * @param string $class
     * @param array $data
     * @return EntityBase
     */
    private function saveEntity(string $class, array $data) : EntityBase
    {
       return $this->managerRegistry->getRepository($class)->save($data);
    }

    /**
     * @param string $class
     * @param EntityBase $entity
     * @param array $data
     * @return EntityBase
     */
    private function updateEntity(string $class, EntityBase $entity, array $data) : EntityBase
    {
        $goals = [] ;

        /** @var Score $score */
        if(isset($data['home']['scorers'])){
            $goals = array_merge($goals,$data['home']['scorers']) ;
        }

        if(isset($data['away']['scorers'])){
            $goals = array_merge($goals,$data['away']['scorers']) ;
        }

        if(count($goals) > 0) {
            $event = new SneakEvent($goals);
            $this->dispatcher->dispatch($event, SneakEvent::NAME);
        }

        return $this->managerRegistry->getRepository($class)->update($entity,$data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    private function reportMatchData(array $data) : Match {

        $match = $this->managerRegistry
            ->getRepository(Match::class)
            ->findOneBy(['id'=>$data['id']]);

        if(!$match) {
            $match = $this->saveEntity(Match::class, $data);
        } else {
            /** @var EntityBase $match */
            $match = $this->updateEntity(Match::class, $match ,$data);
        }

        return $match;


    }

}
