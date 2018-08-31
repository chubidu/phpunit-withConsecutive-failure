<?php

namespace Tests\Example;

use Example\MyMessage;
use Example\MyMessageHandler;
use Example\ParameterBag;
use Example\Repository;
use PHPUnit\Framework\TestCase;

class MyMessageHandlerTest extends TestCase
{
    private $messageHandler;
    private $message;

    public function testInvoke(): void
    {
        $invoke = $this->messageHandler;

        $invoke($this->message);
    }

    protected function setUp(): void
    {
        $repository = $this->createMock(Repository::class);
        $repository->expects(self::exactly(4))->method('all')
            ->withConsecutive(
                [
                    self::equalTo(
                        new ParameterBag([
                            'limit'  => 10,
                            'offset' => 0,
                        ])
                    )
                ],
                [
                    self::equalTo(
                        new ParameterBag([
                            'limit'  => 10,
                            'offset' => 10,
                        ])
                    )
                ],
                [
                    self::equalTo(
                        new ParameterBag([
                            'limit'  => 10,
                            'offset' => 0,
                        ])
                    )
                ],
                [
                    self::equalTo(
                        new ParameterBag([
                            'limit'  => 10,
                            'offset' => 10,
                        ])
                    )
                ]
            )
            ->willReturnOnConsecutiveCalls(
                [
                    'result' => 'of-first-outer-first-inner-iteration',
                ],
                [], // nothing here to break the inner do-while
                [
                    'result' => 'of-second-outer-first-inner-iteration',
                ],
                [] // nothing here to break the inner do-while
            );

        $this->message = $this->createMock(MyMessage::class);
        $this->message->expects(self::once())->method('getPayload')
            ->willReturn(
                [
                    11 => 'first-outer-iteration',
                    22 => 'second-outer-iteration',
                ]
            );

        $this->messageHandler = new MyMessageHandler($repository);
    }
}
