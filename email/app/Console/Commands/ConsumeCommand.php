<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConsumeCommand extends Command
{
    protected $signature = 'consume';

    public function handle()
    {
        $conf = new \RdKafka\Conf();

        $conf->set('bootstrap.servers', env('BOOTSTRAP_SERVER'));
        $conf->set('security.protocol', 'SASL_SSL');
        $conf->set('sasl.mechanism', 'PLAIN');
        $conf->set('sasl.username', env('SASL_USERNAME'));
        $conf->set('sasl.password', env('SASL_PASSWORD'));
        $conf->set('group.id', 'myGroup');
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new \RdKafka\KafkaConsumer($conf);

        while(true){
            $consumer->subscribe(['default']);
            $message = $consumer->consume(120 * 1000);

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    var_dump($message->payload);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "Timed out\n";
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
                    break;
            }

        }

    }
}
