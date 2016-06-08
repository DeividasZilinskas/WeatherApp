<?php

namespace Nfq\WeatherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class WeatherExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $provider = $config['provider'];
        $delegatingProviders = $config['providers']['delegating']['providers'];

        $weatherProviders = array();
        $apiKeys = array();

        foreach ($delegatingProviders as $providerName) {
            array_push($weatherProviders, 'Nfq\\WeatherBundle\Providers\\'.$providerName);
            $apiKeys[$providerName] = $config['providers'][strtolower($providerName)]['api_key'];
        }
        if ($provider == 'cached') {
            $container->setAlias(
                'nfq_weather.provider',
                'nfq_weather.provider.'.$config['providers']['cached']['provider']
            );
            $container->setParameter('ttl', $config['providers']['cached']['ttl']);
        } else {
            $container->setAlias('nfq_weather.provider', 'nfq_weather.provider.'.$provider);
            $container->setParameter('ttl', 0);
        }
        $container->setParameter('nfq_weather.delegating_providers', $weatherProviders);
        $container->setParameter('api_keys', $apiKeys);
    }
}
