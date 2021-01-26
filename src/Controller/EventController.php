<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EventController extends AbstractController
{
    /**
     * @var array
     */
    private $options;

    public function __construct(array $eventControllerOptions)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($eventControllerOptions);
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['eventSourceUrl']);
    }
    /**
     * @Route("/", name="event")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig');
    }

    /**
     * @Route("/{id}", name="event_show")
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'options' =>
                [
                    'reactUrl' => $this->generateUrl(
                        'event_react',
                        ['id' => $event->getId()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ),
                ] + $this->options,
        ]);
    }

    /**
     * @Route("/{id}/share", name="event_share")
     */
    public function share(Event $event): Response
    {
        return $this->render('event/share.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/present/{code}", name="event_present")
     */
    public function present(Event $event, string $code): Response
    {
        $this->options['eventSourceUrl'] .=
            '?' . http_build_query(['topic' => 'event:' . $event->getId()]);

        return $this->render('event/present.html.twig', [
            'event' => $event,
            'options' => $this->options,
        ]);
    }

    /**
     * @Route("/{id}/react", name="event_react", methods={"POST"})
     */
    public function react(
        Request $request,
        Event $event,
        PublisherInterface $publisher
    ): Response {
        $data = json_decode((string) $request->getContent());

        $update = new Update('event:' . $event->getId(), json_encode($data));
        $publisher($update);

        $update = new Update('reaction', json_encode($data));
        $publisher($update);

        return new JsonResponse($data);
    }
}
