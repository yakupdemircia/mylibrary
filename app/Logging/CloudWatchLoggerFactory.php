<?php

namespace App\Logging;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Maxbanton\Cwh\Handler\CloudWatch;
use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;

class CloudWatchLoggerFactory
{

    public function __invoke($config)
    {

        $client = new CloudWatchLogsClient($config["sdk"]);

        $handler = new CloudWatch($client, $config["group_name"], $config["stream_name"], $config["retention"], 10000, $tags = []);

        $handler->setFormatter(new JsonFormatter());

        $logger = new Logger('cloudwatch');

        $logger->pushHandler($handler);

        return $logger;
    }
}
