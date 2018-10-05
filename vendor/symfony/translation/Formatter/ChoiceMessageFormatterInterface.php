<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Formatter;

/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
interface ChoiceMessageFormatterInterface
{
    /**
     * Formats a localized messages pattern with given arguments.
     *
     * @param string $message    The messages (may also be an object that can be cast to string)
     * @param int    $number     The number to use to find the indice of the messages
     * @param string $locale     The messages locale
     * @param array  $parameters An array of parameters for the messages
     *
     * @return string
     */
    public function choiceFormat($message, $number, $locale, array $parameters = array());
}
