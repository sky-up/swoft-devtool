<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Swoft\Devtool\Helper;

use Toolkit\Cli\Cli;
use Toolkit\Cli\Highlighter;
use function output;
use function input;

/**
 * Class ConsoleHelper
 *
 * @since 2.0
 */
class ConsoleHelper
{
    /**
     * Send confirm question
     *
     * @param string $question question
     * @param bool   $default  Default value
     *
     * @return bool
     */
    public static function confirm(string $question, $default = true): bool
    {
        if (!$question = trim($question)) {
            output()->writeln('Please provide a question message!', true);
        }

        $question    = ucfirst(trim($question, '?'));
        $default     = (bool)$default;
        $defaultText = $default ? 'yes' : 'no';
        $message     = "<comment>$question ?</comment>\nPlease confirm (yes|no)[default:<info>$defaultText</info>]: ";

        while (true) {
            output()->writeln($message, false);
            $answer = input()->read();

            // 如果输入为空，返回默认值
            if (empty($answer)) {
                output()->writeln($defaultText);
                return $default;
            }

            $answer = strtolower(trim($answer));
            
            if (in_array($answer, ['y', 'yes'], true)) {
                return true;
            }

            if (in_array($answer, ['n', 'no'], true)) {
                return false;
            }

            output()->writeln("Invalid input. Please enter 'yes' or 'no'");
        }
    }

    /**
     * highlight code
     *
     * @param array|string $messages
     * @param bool         $quit
     */
    public static function highlight($messages, $quit = true): void
    {
        // this is an comment
        $rendered = Highlighter::create()->highlight($messages);

        Cli::write($rendered, true, $quit);
    }
}
