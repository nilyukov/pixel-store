<?php

namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBotApi;
use Exception;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;

    protected string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->chatId = $config['chat_id'];
        $this->token = $config['token'];
    }

    protected function write(LogRecord $record): void {
        try {
            $isSuccess = TelegramBotApi::sendMessage(
                $this->token,
                $this->chatId,
                $record->formatted
            );

            if (!$isSuccess) {
                throw new Exception('Failed to send message!');
            }
        } catch (Exception $e) {
            logger()->error($e->getMessage());
        }
    }
}
