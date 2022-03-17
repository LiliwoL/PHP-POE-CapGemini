<?php

namespace App\Tests;

use Dotenv\Dotenv;
use App\BLL\ArticleManager;
use App\DAL\Mapper\StyloMapper;
use PHPUnit\Framework\TestCase;
use App\DAL\Mapper\ArticleMapper;
use App\DependencyInjectionContainer;

class DependencyInjectionContainerTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load(); 
    }
    
    public function testMesMappersSontDisponibleDansMonContainer()
    {
        $dependencyInjectionContainer = DependencyInjectionContainer::getInstance();

        // Test de déps avec ArticleManager
        $this->assertInstanceOf(ArticleManager::class, $dependencyInjectionContainer->get(ArticleManager::class));

        // Lignes conservées pour rétro compatibilité, mais plus utiles
        $this->assertInstanceOf(ArticleMapper::class, $dependencyInjectionContainer->get(ArticleMapper::class));
        $this->assertInstanceOf(StyloMapper::class, $dependencyInjectionContainer->get(StyloMapper::class));        
    }
}