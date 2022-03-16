<?php

namespace App\Tests;

use App\DAL\Mapper\ArticleMapper;
use App\DAL\Mapper\StyloMapper;
use App\DependencyInjectionContainer;
use PHPUnit\Framework\TestCase;

class DependencyInjectionContainerTest extends TestCase
{
    public function testMesMappersSontDisponibleDansMonContainer()
    {
        $dependencyInjectionContainer = DependencyInjectionContainer::getInstance();


        $this->assertInstanceOf(ArticleMapper::class, $dependencyInjectionContainer->get(ArticleMapper::class));
        $this->assertInstanceOf(StyloMapper::class, $dependencyInjectionContainer->get(StyloMapper::class));        
    }
}