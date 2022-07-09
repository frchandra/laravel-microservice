<?php

namespace App\Connector;

use Illuminate\Queue\Connectors\ConnectorInterface;
use App\Queues\KafkaQueue;
use function env;

class KafkaConnector implements ConnectorInterface{
    public function connect(array $config){
        $conf = new \RdKafka\Conf();

        $conf->set('bootstrap.servers', $config['bootstrap_servers']);
        $conf->set('security.protocol', $config['security_protocol']);
        $conf->set('sasl.mechanism', $config['sasl_mechanism']);
        $conf->set('sasl.username', $config['sasl_username']);
        $conf->set('sasl.password', $config['sasl_password']);
        $conf->set('group.id', $config['group_id']);
        $conf->set('auto.offset.reset', 'earliest');

//        $conf->set('bootstrap.servers', env('BOOTSTRAP_SERVER'));
//        $conf->set('security.protocol', 'SASL_SSL');
//        $conf->set('sasl.mechanism', 'PLAIN');
//        $conf->set('sasl.username', env('SASL_USERNAME'));
//        $conf->set('sasl.password', env('SASL_PASSWORD'));
//        $conf->set('group.id', 'myGroup');
//        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new \RdKafka\KafkaConsumer($conf);

        return new KafkaQueue($consumer);
    }
}
