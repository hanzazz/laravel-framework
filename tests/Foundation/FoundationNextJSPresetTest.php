<?php

namespace Illuminate\Tests\Foundation;

use PHPUnit\Framework\TestCase;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\NextJS;

class FoundationNextJSPresetTest extends TestCase
{
    protected $tempDir;
    protected $filesystem;

    public function setUp()
    {
        $this->filesystem = new Filesystem;
        $this->tempDir = sys_get_temp_dir().'/laravel_nextjs_preset_test_'.uniqid();
        $this->filesystem->makeDirectory($this->tempDir);
    }

    public function tearDown()
    {
        if ($this->filesystem->exists($this->tempDir)) {
            $this->filesystem->deleteDirectory($this->tempDir);
        }
    }

    public function testNextJSPresetExtendsBasePreset()
    {
        $reflection = new \ReflectionClass(NextJS::class);
        $this->assertTrue($reflection->isSubclassOf('Illuminate\Foundation\Console\Presets\Preset'));
    }

    public function testUpdatePackageArrayIncludesNextJSDependencies()
    {
        $packages = [
            'devDependencies' => [
                'vue' => '^2.0.0',
                'laravel-mix' => '^1.0.0',
            ]
        ];

        $updatedPackages = $this->invokePrivateMethod(NextJS::class, 'updatePackageArray', [$packages['devDependencies']]);

        // Check that Next.js dependencies are included
        $this->assertArrayHasKey('next', $updatedPackages);
        $this->assertArrayHasKey('react', $updatedPackages);
        $this->assertArrayHasKey('react-dom', $updatedPackages);
        $this->assertArrayHasKey('typescript', $updatedPackages);
        $this->assertArrayHasKey('tailwindcss', $updatedPackages);
        $this->assertArrayHasKey('framer-motion', $updatedPackages);

        // Check that Vue is removed (as specified in the preset)
        $this->assertArrayNotHasKey('vue', $updatedPackages);

        // Check version constraints
        $this->assertEquals('^13.0.0', $updatedPackages['next']);
        $this->assertEquals('^18.0.0', $updatedPackages['react']);
        $this->assertEquals('^18.0.0', $updatedPackages['react-dom']);
    }

    public function testNextJSPresetHasInstallMethod()
    {
        $this->assertTrue(method_exists(NextJS::class, 'install'));
    }

    public function testNextJSPresetHasRequiredMethods()
    {
        $requiredMethods = [
            'updatePackageArray',
            'updateWebpackConfiguration',
            'updateComponents',
            'updateStyles',
            'updateConfig',
            'updateBootstrapping',
        ];

        foreach ($requiredMethods as $method) {
            $this->assertTrue(
                method_exists(NextJS::class, $method),
                "NextJS preset should have {$method} method"
            );
        }
    }

    public function testStubFilesExist()
    {
        $stubsPath = __DIR__.'/../../src/Illuminate/Foundation/Console/Presets/nextjs-stubs';
        
        $requiredFiles = [
            'next.config.js',
            'postcss.config.js',
            'tailwind.config.js',
            'tsconfig.json',
            'package.json',
            'pages/_app.tsx',
            'pages/index.tsx',
            'pages/products.tsx',
            'components/Header.tsx',
            'components/Hero.tsx',
            'components/ProductCard.tsx',
            'components/Footer.tsx',
            'lib/nilfisk-data.ts',
            'types/product.ts',
            'styles/globals.css',
            'styles/apple-inspired.css',
        ];

        foreach ($requiredFiles as $file) {
            $filePath = $stubsPath.'/'.$file;
            $this->assertFileExists($filePath, "Required stub file {$file} should exist");
        }
    }

    public function testPackageJsonContainsValidJSON()
    {
        $packageJsonPath = __DIR__.'/../../src/Illuminate/Foundation/Console/Presets/nextjs-stubs/package.json';
        $this->assertFileExists($packageJsonPath);
        
        $content = file_get_contents($packageJsonPath);
        $json = json_decode($content, true);
        
        $this->assertNotNull($json, 'package.json should contain valid JSON');
        $this->assertArrayHasKey('dependencies', $json);
        $this->assertArrayHasKey('devDependencies', $json);
        $this->assertArrayHasKey('scripts', $json);
    }

    public function testTSConfigContainsValidJSON()
    {
        $tsconfigPath = __DIR__.'/../../src/Illuminate/Foundation/Console/Presets/nextjs-stubs/tsconfig.json';
        $this->assertFileExists($tsconfigPath);
        
        $content = file_get_contents($tsconfigPath);
        $json = json_decode($content, true);
        
        $this->assertNotNull($json, 'tsconfig.json should contain valid JSON');
        $this->assertArrayHasKey('compilerOptions', $json);
        $this->assertArrayHasKey('include', $json);
        $this->assertArrayHasKey('exclude', $json);
    }

    /**
     * Invoke a private method for testing purposes.
     */
    private function invokePrivateMethod($className, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass($className);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs(null, $parameters);
    }
}