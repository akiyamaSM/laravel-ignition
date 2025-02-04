<?php

namespace Spatie\LaravelIgnition\Tests\Solutions;

use ErrorException;
use Spatie\Ignition\Solutions\SolutionProviders\UndefinedPropertySolutionProvider;
use Spatie\LaravelIgnition\Tests\TestCase;

class UndefinedPropertySolutionProviderTest extends TestCase
{
    /** @test */
    public function it_can_solve_an_undefined_property_exception_when_there_is_a_similar_property()
    {
        $canSolve = app(UndefinedPropertySolutionProvider::class)->canSolve($this->getUndefinedPropertyException());

        $this->assertTrue($canSolve);
    }

    /** @test */
    public function it_cannot_solve_an_undefined_property_exception_when_there_is_no_similar_property()
    {
        $canSolve = app(UndefinedPropertySolutionProvider::class)->canSolve($this->getUndefinedPropertyException('balance'));

        $this->assertFalse($canSolve);
    }

    /** @test */
    public function it_can_recommend_a_property_name_when_there_is_a_similar_property()
    {
        /** @var \Spatie\IgnitionContracts\Solution $solution */
        $solution = app(UndefinedPropertySolutionProvider::class)->getSolutions($this->getUndefinedPropertyException())[0];

        $this->assertEquals('Did you mean Spatie\LaravelIgnition\Tests\Support\Models\Car::$color ?', $solution->getSolutionDescription());
    }

    /** @test */
    public function it_cannot_recommend_a_property_name_when_there_is_no_similar_property()
    {
        /** @var \Spatie\IgnitionContracts\Solution $solution */
        $solution = app(UndefinedPropertySolutionProvider::class)->getSolutions($this->getUndefinedPropertyException('balance'))[0];

        $this->assertEquals('', $solution->getSolutionDescription());
    }

    protected function getUndefinedPropertyException(string $property = 'colro'): ErrorException
    {
        return new ErrorException("Undefined property: Spatie\LaravelIgnition\Tests\Support\Models\Car::$$property ");
    }
}
