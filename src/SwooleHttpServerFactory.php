<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-swoole for the canonical source repository
 * @copyright Copyright (c) 2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-swoole/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Zend\Expressive\Swoole;

use Psr\Container\ContainerInterface;
use Swoole\Http\Server as SwooleHttpServer;

class SwooleHttpServerFactory
{
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 8080;

    public function __invoke(ContainerInterface $container) : SwooleHttpServer
    {
        $config = $container->get('config');
        $host = $config['swoole_http_server']['host'] ?? static::DEFAULT_HOST;
        $port = $config['swoole_http_server']['port'] ?? static::DEFAULT_PORT;
        $mode = $config['swoole_http_server']['mode'] ?? SWOOLE_BASE;
        $protocol = $config['swoole_http_server']['protocol'] ?? SWOOLE_SOCK_TCP;

        $server = new SwooleHttpServer($host, $port, $mode, $protocol);
        if (isset($config['swoole_http_server']['options'])) {
            $server->set($config['swoole_http_server']['options']);
        }
        return $server;
    }
}