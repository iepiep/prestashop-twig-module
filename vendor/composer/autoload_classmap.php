<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'Dimsymfony\\Controller\\Admin\\ConfigurationController' => $baseDir . '/src/Controller/Admin/ConfigurationController.php',
    'Dimsymfony\\Controller\\Admin\\CustomerListController' => $baseDir . '/src/Controller/Admin/CustomerListController.php',
    'Dimsymfony\\Controller\\Admin\\ItineraryController' => $baseDir . '/src/Controller/Admin/ItineraryController.php',
    'Dimsymfony\\Controller\\Front\\ItineraryFormController' => $baseDir . '/src/Controller/Front/ItineraryFormController.php',
    'Dimsymfony\\Entity\\Rdv' => $baseDir . '/src/Entity/Rdv.php',
    'Dimsymfony\\Service\\ItineraryService' => $baseDir . '/src/Service/ItineraryService.php',
    'Psr\\Container\\ContainerExceptionInterface' => $vendorDir . '/psr/container/src/ContainerExceptionInterface.php',
    'Psr\\Container\\ContainerInterface' => $vendorDir . '/psr/container/src/ContainerInterface.php',
    'Psr\\Container\\NotFoundExceptionInterface' => $vendorDir . '/psr/container/src/NotFoundExceptionInterface.php',
    'Psr\\Log\\AbstractLogger' => $vendorDir . '/psr/log/src/AbstractLogger.php',
    'Psr\\Log\\InvalidArgumentException' => $vendorDir . '/psr/log/src/InvalidArgumentException.php',
    'Psr\\Log\\LogLevel' => $vendorDir . '/psr/log/src/LogLevel.php',
    'Psr\\Log\\LoggerAwareInterface' => $vendorDir . '/psr/log/src/LoggerAwareInterface.php',
    'Psr\\Log\\LoggerAwareTrait' => $vendorDir . '/psr/log/src/LoggerAwareTrait.php',
    'Psr\\Log\\LoggerInterface' => $vendorDir . '/psr/log/src/LoggerInterface.php',
    'Psr\\Log\\LoggerTrait' => $vendorDir . '/psr/log/src/LoggerTrait.php',
    'Psr\\Log\\NullLogger' => $vendorDir . '/psr/log/src/NullLogger.php',
    'Symfony\\Component\\HttpClient\\AmpHttpClient' => $vendorDir . '/symfony/http-client/AmpHttpClient.php',
    'Symfony\\Component\\HttpClient\\AsyncDecoratorTrait' => $vendorDir . '/symfony/http-client/AsyncDecoratorTrait.php',
    'Symfony\\Component\\HttpClient\\CachingHttpClient' => $vendorDir . '/symfony/http-client/CachingHttpClient.php',
    'Symfony\\Component\\HttpClient\\Chunk\\DataChunk' => $vendorDir . '/symfony/http-client/Chunk/DataChunk.php',
    'Symfony\\Component\\HttpClient\\Chunk\\ErrorChunk' => $vendorDir . '/symfony/http-client/Chunk/ErrorChunk.php',
    'Symfony\\Component\\HttpClient\\Chunk\\FirstChunk' => $vendorDir . '/symfony/http-client/Chunk/FirstChunk.php',
    'Symfony\\Component\\HttpClient\\Chunk\\InformationalChunk' => $vendorDir . '/symfony/http-client/Chunk/InformationalChunk.php',
    'Symfony\\Component\\HttpClient\\Chunk\\LastChunk' => $vendorDir . '/symfony/http-client/Chunk/LastChunk.php',
    'Symfony\\Component\\HttpClient\\Chunk\\ServerSentEvent' => $vendorDir . '/symfony/http-client/Chunk/ServerSentEvent.php',
    'Symfony\\Component\\HttpClient\\CurlHttpClient' => $vendorDir . '/symfony/http-client/CurlHttpClient.php',
    'Symfony\\Component\\HttpClient\\DataCollector\\HttpClientDataCollector' => $vendorDir . '/symfony/http-client/DataCollector/HttpClientDataCollector.php',
    'Symfony\\Component\\HttpClient\\DecoratorTrait' => $vendorDir . '/symfony/http-client/DecoratorTrait.php',
    'Symfony\\Component\\HttpClient\\DependencyInjection\\HttpClientPass' => $vendorDir . '/symfony/http-client/DependencyInjection/HttpClientPass.php',
    'Symfony\\Component\\HttpClient\\EventSourceHttpClient' => $vendorDir . '/symfony/http-client/EventSourceHttpClient.php',
    'Symfony\\Component\\HttpClient\\Exception\\ClientException' => $vendorDir . '/symfony/http-client/Exception/ClientException.php',
    'Symfony\\Component\\HttpClient\\Exception\\EventSourceException' => $vendorDir . '/symfony/http-client/Exception/EventSourceException.php',
    'Symfony\\Component\\HttpClient\\Exception\\HttpExceptionTrait' => $vendorDir . '/symfony/http-client/Exception/HttpExceptionTrait.php',
    'Symfony\\Component\\HttpClient\\Exception\\InvalidArgumentException' => $vendorDir . '/symfony/http-client/Exception/InvalidArgumentException.php',
    'Symfony\\Component\\HttpClient\\Exception\\JsonException' => $vendorDir . '/symfony/http-client/Exception/JsonException.php',
    'Symfony\\Component\\HttpClient\\Exception\\RedirectionException' => $vendorDir . '/symfony/http-client/Exception/RedirectionException.php',
    'Symfony\\Component\\HttpClient\\Exception\\ServerException' => $vendorDir . '/symfony/http-client/Exception/ServerException.php',
    'Symfony\\Component\\HttpClient\\Exception\\TimeoutException' => $vendorDir . '/symfony/http-client/Exception/TimeoutException.php',
    'Symfony\\Component\\HttpClient\\Exception\\TransportException' => $vendorDir . '/symfony/http-client/Exception/TransportException.php',
    'Symfony\\Component\\HttpClient\\HttpClient' => $vendorDir . '/symfony/http-client/HttpClient.php',
    'Symfony\\Component\\HttpClient\\HttpClientTrait' => $vendorDir . '/symfony/http-client/HttpClientTrait.php',
    'Symfony\\Component\\HttpClient\\HttpOptions' => $vendorDir . '/symfony/http-client/HttpOptions.php',
    'Symfony\\Component\\HttpClient\\HttplugClient' => $vendorDir . '/symfony/http-client/HttplugClient.php',
    'Symfony\\Component\\HttpClient\\Internal\\AmpBody' => $vendorDir . '/symfony/http-client/Internal/AmpBody.php',
    'Symfony\\Component\\HttpClient\\Internal\\AmpClientState' => $vendorDir . '/symfony/http-client/Internal/AmpClientState.php',
    'Symfony\\Component\\HttpClient\\Internal\\AmpListener' => $vendorDir . '/symfony/http-client/Internal/AmpListener.php',
    'Symfony\\Component\\HttpClient\\Internal\\AmpResolver' => $vendorDir . '/symfony/http-client/Internal/AmpResolver.php',
    'Symfony\\Component\\HttpClient\\Internal\\Canary' => $vendorDir . '/symfony/http-client/Internal/Canary.php',
    'Symfony\\Component\\HttpClient\\Internal\\ClientState' => $vendorDir . '/symfony/http-client/Internal/ClientState.php',
    'Symfony\\Component\\HttpClient\\Internal\\CurlClientState' => $vendorDir . '/symfony/http-client/Internal/CurlClientState.php',
    'Symfony\\Component\\HttpClient\\Internal\\DnsCache' => $vendorDir . '/symfony/http-client/Internal/DnsCache.php',
    'Symfony\\Component\\HttpClient\\Internal\\HttplugWaitLoop' => $vendorDir . '/symfony/http-client/Internal/HttplugWaitLoop.php',
    'Symfony\\Component\\HttpClient\\Internal\\LegacyHttplugInterface' => $vendorDir . '/symfony/http-client/Internal/LegacyHttplugInterface.php',
    'Symfony\\Component\\HttpClient\\Internal\\NativeClientState' => $vendorDir . '/symfony/http-client/Internal/NativeClientState.php',
    'Symfony\\Component\\HttpClient\\Internal\\PushedResponse' => $vendorDir . '/symfony/http-client/Internal/PushedResponse.php',
    'Symfony\\Component\\HttpClient\\Messenger\\PingWebhookMessage' => $vendorDir . '/symfony/http-client/Messenger/PingWebhookMessage.php',
    'Symfony\\Component\\HttpClient\\Messenger\\PingWebhookMessageHandler' => $vendorDir . '/symfony/http-client/Messenger/PingWebhookMessageHandler.php',
    'Symfony\\Component\\HttpClient\\MockHttpClient' => $vendorDir . '/symfony/http-client/MockHttpClient.php',
    'Symfony\\Component\\HttpClient\\NativeHttpClient' => $vendorDir . '/symfony/http-client/NativeHttpClient.php',
    'Symfony\\Component\\HttpClient\\NoPrivateNetworkHttpClient' => $vendorDir . '/symfony/http-client/NoPrivateNetworkHttpClient.php',
    'Symfony\\Component\\HttpClient\\Psr18Client' => $vendorDir . '/symfony/http-client/Psr18Client.php',
    'Symfony\\Component\\HttpClient\\Response\\AmpResponse' => $vendorDir . '/symfony/http-client/Response/AmpResponse.php',
    'Symfony\\Component\\HttpClient\\Response\\AsyncContext' => $vendorDir . '/symfony/http-client/Response/AsyncContext.php',
    'Symfony\\Component\\HttpClient\\Response\\AsyncResponse' => $vendorDir . '/symfony/http-client/Response/AsyncResponse.php',
    'Symfony\\Component\\HttpClient\\Response\\CommonResponseTrait' => $vendorDir . '/symfony/http-client/Response/CommonResponseTrait.php',
    'Symfony\\Component\\HttpClient\\Response\\CurlResponse' => $vendorDir . '/symfony/http-client/Response/CurlResponse.php',
    'Symfony\\Component\\HttpClient\\Response\\HttplugPromise' => $vendorDir . '/symfony/http-client/Response/HttplugPromise.php',
    'Symfony\\Component\\HttpClient\\Response\\JsonMockResponse' => $vendorDir . '/symfony/http-client/Response/JsonMockResponse.php',
    'Symfony\\Component\\HttpClient\\Response\\MockResponse' => $vendorDir . '/symfony/http-client/Response/MockResponse.php',
    'Symfony\\Component\\HttpClient\\Response\\NativeResponse' => $vendorDir . '/symfony/http-client/Response/NativeResponse.php',
    'Symfony\\Component\\HttpClient\\Response\\ResponseStream' => $vendorDir . '/symfony/http-client/Response/ResponseStream.php',
    'Symfony\\Component\\HttpClient\\Response\\StreamWrapper' => $vendorDir . '/symfony/http-client/Response/StreamWrapper.php',
    'Symfony\\Component\\HttpClient\\Response\\StreamableInterface' => $vendorDir . '/symfony/http-client/Response/StreamableInterface.php',
    'Symfony\\Component\\HttpClient\\Response\\TraceableResponse' => $vendorDir . '/symfony/http-client/Response/TraceableResponse.php',
    'Symfony\\Component\\HttpClient\\Response\\TransportResponseTrait' => $vendorDir . '/symfony/http-client/Response/TransportResponseTrait.php',
    'Symfony\\Component\\HttpClient\\Retry\\GenericRetryStrategy' => $vendorDir . '/symfony/http-client/Retry/GenericRetryStrategy.php',
    'Symfony\\Component\\HttpClient\\Retry\\RetryStrategyInterface' => $vendorDir . '/symfony/http-client/Retry/RetryStrategyInterface.php',
    'Symfony\\Component\\HttpClient\\RetryableHttpClient' => $vendorDir . '/symfony/http-client/RetryableHttpClient.php',
    'Symfony\\Component\\HttpClient\\ScopingHttpClient' => $vendorDir . '/symfony/http-client/ScopingHttpClient.php',
    'Symfony\\Component\\HttpClient\\Test\\HarFileResponseFactory' => $vendorDir . '/symfony/http-client/Test/HarFileResponseFactory.php',
    'Symfony\\Component\\HttpClient\\TraceableHttpClient' => $vendorDir . '/symfony/http-client/TraceableHttpClient.php',
    'Symfony\\Component\\HttpClient\\UriTemplateHttpClient' => $vendorDir . '/symfony/http-client/UriTemplateHttpClient.php',
    'Symfony\\Contracts\\HttpClient\\ChunkInterface' => $vendorDir . '/symfony/http-client-contracts/ChunkInterface.php',
    'Symfony\\Contracts\\HttpClient\\Exception\\ClientExceptionInterface' => $vendorDir . '/symfony/http-client-contracts/Exception/ClientExceptionInterface.php',
    'Symfony\\Contracts\\HttpClient\\Exception\\DecodingExceptionInterface' => $vendorDir . '/symfony/http-client-contracts/Exception/DecodingExceptionInterface.php',
    'Symfony\\Contracts\\HttpClient\\Exception\\ExceptionInterface' => $vendorDir . '/symfony/http-client-contracts/Exception/ExceptionInterface.php',
    'Symfony\\Contracts\\HttpClient\\Exception\\HttpExceptionInterface' => $vendorDir . '/symfony/http-client-contracts/Exception/HttpExceptionInterface.php',
    'Symfony\\Contracts\\HttpClient\\Exception\\RedirectionExceptionInterface' => $vendorDir . '/symfony/http-client-contracts/Exception/RedirectionExceptionInterface.php',
    'Symfony\\Contracts\\HttpClient\\Exception\\ServerExceptionInterface' => $vendorDir . '/symfony/http-client-contracts/Exception/ServerExceptionInterface.php',
    'Symfony\\Contracts\\HttpClient\\Exception\\TimeoutExceptionInterface' => $vendorDir . '/symfony/http-client-contracts/Exception/TimeoutExceptionInterface.php',
    'Symfony\\Contracts\\HttpClient\\Exception\\TransportExceptionInterface' => $vendorDir . '/symfony/http-client-contracts/Exception/TransportExceptionInterface.php',
    'Symfony\\Contracts\\HttpClient\\HttpClientInterface' => $vendorDir . '/symfony/http-client-contracts/HttpClientInterface.php',
    'Symfony\\Contracts\\HttpClient\\ResponseInterface' => $vendorDir . '/symfony/http-client-contracts/ResponseInterface.php',
    'Symfony\\Contracts\\HttpClient\\ResponseStreamInterface' => $vendorDir . '/symfony/http-client-contracts/ResponseStreamInterface.php',
    'Symfony\\Contracts\\Service\\Attribute\\Required' => $vendorDir . '/symfony/service-contracts/Attribute/Required.php',
    'Symfony\\Contracts\\Service\\Attribute\\SubscribedService' => $vendorDir . '/symfony/service-contracts/Attribute/SubscribedService.php',
    'Symfony\\Contracts\\Service\\ResetInterface' => $vendorDir . '/symfony/service-contracts/ResetInterface.php',
    'Symfony\\Contracts\\Service\\ServiceCollectionInterface' => $vendorDir . '/symfony/service-contracts/ServiceCollectionInterface.php',
    'Symfony\\Contracts\\Service\\ServiceLocatorTrait' => $vendorDir . '/symfony/service-contracts/ServiceLocatorTrait.php',
    'Symfony\\Contracts\\Service\\ServiceMethodsSubscriberTrait' => $vendorDir . '/symfony/service-contracts/ServiceMethodsSubscriberTrait.php',
    'Symfony\\Contracts\\Service\\ServiceProviderInterface' => $vendorDir . '/symfony/service-contracts/ServiceProviderInterface.php',
    'Symfony\\Contracts\\Service\\ServiceSubscriberInterface' => $vendorDir . '/symfony/service-contracts/ServiceSubscriberInterface.php',
    'Symfony\\Contracts\\Service\\ServiceSubscriberTrait' => $vendorDir . '/symfony/service-contracts/ServiceSubscriberTrait.php',
);
