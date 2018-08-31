<?php

namespace App\Example;

use Symfony\Component\HttpFoundation\ParameterBag;

class MyMessageHandler
{
    private $repository;
    private $parameterBag;
    private $chunkSize = 10;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        $this->parameterBag = new ParameterBag();
    }

    public function __invoke(MyMessage $message)
    {
        $payload = $message->getPayload();

        $result = [];
        foreach ($payload as $key => $value) {
            $iteration = 0;

            do {
                /*var_dump($this->getParameterBag([
                    'limit'  => $this->chunkSize,
                    'offset' => $this->chunkSize * $iteration,
                ]));*/

                $tmp = $this->repository->all(
                    $this->getParameterBag([
                        'limit'  => $this->chunkSize,
                        'offset' => $this->chunkSize * $iteration,
                    ])
                );

                /*var_dump($tmp);*/

                if (\count($tmp) > 0) {
                    $result[$key][] = $tmp;
                }

                $iteration++;
            } while (\count($tmp) > 0);
        }

        return $result;
    }

    protected function getParameterBag(array $params): ParameterBag
    {
        $this->parameterBag->replace($params);

        return $this->parameterBag;
    }
}
