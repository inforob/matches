<?php
namespace App\Api\Action;


use App\Events\SneakEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MatchController
{

    public function index(EventDispatcherInterface $dispatcher, Request $request, LoggerInterface $logger)
    {

        $test = 'ok';
        
        if($request->getMethod() == 'GET') {
            return new JsonResponse(['msg'=>'this ok4']);
        } else if($request->getMethod() == 'POST') {
            $test = json_decode($request->getContent());

            $event = new SneakEvent();

            $dispatcher->dispatch($event,'sneak.event');




            return new JsonResponse(['msg'=>'this ok2','parameters'=>$test]);
        }


    }

}
