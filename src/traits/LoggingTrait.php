<?php

namespace highfive\base\traits;

use Craft;
use craft\helpers\App;
use craft\helpers\StringHelper;
use craft\log\MonologTarget;
use Monolog\Formatter\LineFormatter;
use Psr\Log\LogLevel;
use samdark\log\PsrMessage;
use Throwable;
use yii\base\ExitException;
use yii\log\Logger;
use const JSON_PRETTY_PRINT;
use function in_array;

trait LoggingTrait
{
    /**
     * System is unusable.
     *
     * @param array<string, mixed> $context
     * @throws ExitException
     */
    public static function emergency(string $message, array $context = []): void
    {
        self::log(LogLevel::EMERGENCY, $message, $context);

        Craft::$app->end(1);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param array<string, mixed> $context
     * @throws ExitException
     */
    public static function alert(string $message, array $context = []): void
    {
        self::log(LogLevel::ALERT, $message, $context);

        Craft::$app->end(1);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param array<string, mixed> $context
     * @throws ExitException
     */
    public static function critical(string $message, array $context = []): void
    {
        self::log(LogLevel::CRITICAL, $message, $context);

        Craft::$app->end(1);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param array<string, mixed> $context
     */
    public static function error(string $message, array $context = []): void
    {
        self::log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param array<string, mixed> $context
     */
    public static function warning(string $message, array $context = []): void
    {
        self::log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param array<string, mixed> $context
     */
    public static function notice(string $message, array $context = []): void
    {
        self::log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param array<string, mixed> $context
     */
    public static function info(string $message, array $context = []): void
    {
        self::log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param array<string, mixed> $context
     */
    public static function debug(string $message, array $context = []): void
    {
        self::log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param array<string, mixed> $context
     */
    public static function log(string $level, string $message, array $context = []): void
    {
        [$colorCode, $loggerLevel] = match ($level) {
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR   => [91, Logger::LEVEL_ERROR],
            LogLevel::WARNING => [93, Logger::LEVEL_WARNING],
            LogLevel::NOTICE,
            LogLevel::INFO  => [94, Logger::LEVEL_INFO],
            LogLevel::DEBUG => [95, Logger::LEVEL_TRACE],
            default         => [39, Logger::LEVEL_INFO],
        };

        $type = StringHelper::toTitleCase($level);

        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            echo "\e[{$colorCode}m{$type}\e[39m {$message}\n";
        }

        if (!in_array($level, [LogLevel::NOTICE, LogLevel::INFO, LogLevel::DEBUG], true)) {
            $context = array_merge(
                [
                    '$_GET'    => $_GET,
                    '$_POST'   => $_POST,
                    '$_COOKIE' => $_COOKIE,
                    '$_FILES'  => $_FILES,
                    '$_SERVER' => $_SERVER,
                ],
                $context,
            );
        }

        Craft::getLogger()->log(new PsrMessage($message, $context), $loggerLevel, static::getInstance()->handle);
    }

    private function registerLogTarget(): void
    {
        try {
            Craft::getLogger()->dispatcher->targets[] = Craft::createObject([
                'class'           => MonologTarget::class,
                'name'            => $this->handle,
                'allowLineBreaks' => true,
                'categories'      => [$this->handle],
                'logContext'      => false,
                'level'           => App::devMode() ? LogLevel::DEBUG : LogLevel::WARNING,
                'formatter'       => $this->prepareFormatter(),
                'maxFiles'        => 5,
            ]);
        } catch (Throwable $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }
    }

    private function prepareFormatter(): LineFormatter
    {
        $devMode = App::devMode();

        $formatter = new LineFormatter(
            "%datetime% [%level_name%] [%extra.yii_category%] %message%\n%context% %extra%\n",
            'Y-m-d H:i:s',
            $devMode,
            false,
            $devMode,
        );

        if ($devMode) {
            $formatter->addJsonEncodeOption(JSON_PRETTY_PRINT);
        }

        return $formatter;
    }
}
