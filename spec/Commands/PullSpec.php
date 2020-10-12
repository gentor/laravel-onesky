<?php

namespace spec\Ageras\LaravelOneSky\Commands;

use Gentor\LaravelOneSky\Commands\Pull;
use PhpSpec\ObjectBehavior;

class PullSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Pull::class);
    }
}
