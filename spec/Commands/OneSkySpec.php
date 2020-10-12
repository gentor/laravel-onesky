<?php

namespace spec\Ageras\LaravelOneSky\Commands;

use Gentor\LaravelOneSky\Commands\OneSky;
use PhpSpec\ObjectBehavior;

class OneSkySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(OneSky::class);
    }
}
