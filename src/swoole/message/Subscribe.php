<?php
/**
 * Created by PhpStorm.
 * User: jesusslim
 * Date: 2017/8/3
 * Time: 下午8:26
 */

namespace mqttclient\src\swoole\message;


use mqttclient\src\consts\MessageType;
use mqttclient\src\swoole\Util;

class Subscribe extends BaseMessage
{
    protected $type = MessageType::SUBSCRIBE;

    /*
     * MQTT-3.8.1-1
     * Bits 3,2,1 and 0 of the fixed header of the SUBSCRIBE Control Packet are reserved
     * and MUST be set to 0,0,1 and 0 respectively.
     * The Server MUST treat any other value as malformed and close the Network Connection.
     */
    protected $reserved_flags = 0x02;

    protected $need_message_id = true;

    public function getPayload()
    {
        $buffer = "";
        $topics = $this->getClient()->getTopics();
        /* @var \mqttclient\src\subscribe\Topic $topic */
        foreach ($topics as $topic_name => $topic){
            $buffer .= Util::packLenStr($topic->getTopic());
            $buffer .= chr($topic->getQos());
        }
        return $buffer;
    }

}