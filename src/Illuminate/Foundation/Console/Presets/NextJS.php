<?php

namespace Illuminate\Foundation\Console\Presets;

use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;

class NextJS extends Preset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::ensureComponentDirectoryExists();
        static::updatePackages();
        static::updateWebpackConfiguration();
        static::updateBootstrapping();
        static::updateComponents();
        static::updateStyles();
        static::updateConfig();
        static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            'next' => '^13.0.0',
            'react' => '^18.0.0',
            'react-dom' => '^18.0.0',
            '@types/react' => '^18.0.0',
            '@types/react-dom' => '^18.0.0',
            '@types/node' => '^18.0.0',
            'typescript' => '^4.9.0',
            'tailwindcss' => '^3.2.0',
            'autoprefixer' => '^10.4.0',
            'postcss' => '^8.4.0',
            'framer-motion' => '^8.0.0',
        ] + Arr::except($packages, ['vue', 'babel-preset-react']);
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__.'/nextjs-stubs/next.config.js', base_path('next.config.js'));
        copy(__DIR__.'/nextjs-stubs/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/nextjs-stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/nextjs-stubs/tsconfig.json', base_path('tsconfig.json'));
    }

    /**
     * Update the components.
     *
     * @return void
     */
    protected static function updateComponents()
    {
        $filesystem = new Filesystem;
        
        // Clean up existing components
        $filesystem->delete(
            resource_path('assets/js/components/Example.vue')
        );
        $filesystem->delete(
            resource_path('assets/js/components/Example.js')
        );

        // Create Next.js directory structure
        $pagesDir = base_path('pages');
        $componentsDir = base_path('components');
        $libDir = base_path('lib');
        $typesDir = base_path('types');

        if (!$filesystem->isDirectory($pagesDir)) {
            $filesystem->makeDirectory($pagesDir, 0755, true);
        }
        if (!$filesystem->isDirectory($componentsDir)) {
            $filesystem->makeDirectory($componentsDir, 0755, true);
        }
        if (!$filesystem->isDirectory($libDir)) {
            $filesystem->makeDirectory($libDir, 0755, true);
        }
        if (!$filesystem->isDirectory($typesDir)) {
            $filesystem->makeDirectory($typesDir, 0755, true);
        }

        // Copy component files
        copy(__DIR__.'/nextjs-stubs/pages/_app.tsx', $pagesDir . '/_app.tsx');
        copy(__DIR__.'/nextjs-stubs/pages/index.tsx', $pagesDir . '/index.tsx');
        copy(__DIR__.'/nextjs-stubs/pages/products.tsx', $pagesDir . '/products.tsx');
        
        copy(__DIR__.'/nextjs-stubs/components/Header.tsx', $componentsDir . '/Header.tsx');
        copy(__DIR__.'/nextjs-stubs/components/Hero.tsx', $componentsDir . '/Hero.tsx');
        copy(__DIR__.'/nextjs-stubs/components/ProductCard.tsx', $componentsDir . '/ProductCard.tsx');
        copy(__DIR__.'/nextjs-stubs/components/Footer.tsx', $componentsDir . '/Footer.tsx');
        
        copy(__DIR__.'/nextjs-stubs/lib/nilfisk-data.ts', $libDir . '/nilfisk-data.ts');
        copy(__DIR__.'/nextjs-stubs/types/product.ts', $typesDir . '/product.ts');
    }

    /**
     * Update the styles.
     *
     * @return void
     */
    protected static function updateStyles()
    {
        $stylesDir = base_path('styles');
        $filesystem = new Filesystem;

        if (!$filesystem->isDirectory($stylesDir)) {
            $filesystem->makeDirectory($stylesDir, 0755, true);
        }

        copy(__DIR__.'/nextjs-stubs/styles/globals.css', $stylesDir . '/globals.css');
        copy(__DIR__.'/nextjs-stubs/styles/apple-inspired.css', $stylesDir . '/apple-inspired.css');
    }

    /**
     * Update the configuration files.
     *
     * @return void
     */
    protected static function updateConfig()
    {
        copy(__DIR__.'/nextjs-stubs/package.json', base_path('package.json'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        // Next.js doesn't need traditional bootstrapping like Laravel Mix
        // The _app.tsx handles the application bootstrapping
    }
}