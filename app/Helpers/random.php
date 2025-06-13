<?php
    /**
     * Random_* Compatibility Library
     * for using the new PHP 7 random_* API in PHP 5 projects
     *
     * The MIT License (MIT)
     *
     * Copyright (c) 2015 Paragon Initiative Enterprises
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
     * SOFTWARE.
     */

    if ( ! function_exists('RandomCompat_strlen'))
    {
        /**
         * strlen() implementation that isn't brittle to mbstring.func_overload, cryptographically safely
         *
         * @param $binary_string
         * @return int
         * @throws TypeError
         */
        function RandomCompat_strlen($binary_string)
        {
            if (!is_string($binary_string)) {
                throw new TypeError(
                    'RandomCompat_strlen() expects a string'
                );
            }
            return mb_strlen($binary_string, '8bit');
        }
    }

    if ( ! function_exists('RandomCompat_substr'))
    {
        /**
         * substr() implementation that isn't brittle to mbstring.func_overload, cryptographically safely
         *
         * @param $binary_string
         * @param $start
         * @param null $length
         * @return string
         * @throws TypeError
         */
        function RandomCompat_substr($binary_string, $start, $length = null)
        {
            if (!is_string($binary_string)) {
                throw new TypeError(
                    'RandomCompat_substr(): First argument should be a string'
                );
            }
            if (!is_int($start)) {
                throw new TypeError(
                    'RandomCompat_substr(): Second argument should be an integer'
                );
            }
            if ($length === null) {
                $length = RandomCompat_strlen($length) - $start;
            } elseif (!is_int($length)) {
                throw new TypeError(
                    'RandomCompat_substr(): Third argument should be an integer, or omitted'
                );
            }
            return mb_substr($binary_string, $start, $length, '8bit');
        }
    }


    if ( ! function_exists('RandomCompat_intval'))
    {
        /**
         * Cast to an integer if we can, cryptographically safely.
         *
         * @param $number
         * @param bool $fail_open
         * @return int
         * @throws TypeError
         */
        function RandomCompat_intval($number, $fail_open = false)
        {
            if (is_numeric($number)) {
                $number += 0;
            }
            if (
                is_float($number) &&
                $number > ~PHP_INT_MAX &&
                $number < PHP_INT_MAX
            ) {
                $number = (int) $number;
            }
            if (is_int($number) || $fail_open) {
                return $number;
            }
            throw new TypeError(
                'Expected an integer.'
            );
        }
    }

    if ( ! function_exists('random_bytes'))
    {
        /**
         * Generates cryptographically secure pseudo-random bytes
         *
         * @param $bytes
         * @return string
         * @throws Error
         * @throws Exception
         * @throws TypeError
         */
        function random_bytes($length)
        {
            try {
                $length = RandomCompat_intval($length);
            } catch (TypeError $ex) {
                throw new TypeError(
                    'random_bytes(): $bytes must be an integer'
                );
            }

            if ($length < 1) {
                throw new Error(
                    'Length must be greater than 0'
                );
            }

            $buf = @mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);

            if ($buf !== false) {
                if (RandomCompat_strlen($buf) === $length) {
                    return $buf;
                }
            }

            throw new Exception(
                'Could not gather sufficient random data'
            );
        }
    }

    if ( ! function_exists('random_int'))
    {
        /**
         * Generates cryptographically secure pseudo-random integers
         *
         * @param $min
         * @param $max
         * @return int
         * @throws Error
         * @throws Exception
         * @throws TypeError
         */
        function random_int($min, $max)
        {
            try {
                $min = RandomCompat_intval($min);
            } catch (TypeError $ex) {
                throw new TypeError(
                    'random_int(): $min must be an integer'
                );
            }
            try {
                $max = RandomCompat_intval($max);
            } catch (TypeError $ex) {
                throw new TypeError(
                    'random_int(): $max must be an integer'
                );
            }

            if ($min > $max) {
                throw new Error(
                    'Minimum value must be less than or equal to the maximum value'
                );
            }
            if ($max === $min) {
                return $min;
            }

            $attempts = $bits = $bytes = $mask = $valueShift = 0;
            $range = $max - $min;

            if (!is_int($range)) {
                $bytes = PHP_INT_SIZE;
                $mask = ~0;
            } else {
                while ($range > 0) {
                    if ($bits % 8 === 0) {
                        ++$bytes;
                    }
                    ++$bits;
                    $range >>= 1;
                    $mask = $mask << 1 | 1;
                }
                $valueShift = $min;
            }
            do {
                if ($attempts > 128) {
                    throw new Exception(
                        'random_int: RNG is broken - too many rejections'
                    );
                }

                $randomByteString = random_bytes($bytes);

                if ($randomByteString === false) {
                    throw new Exception(
                        'Random number generator failure'
                    );
                }

                $val = 0;

                for ($i = 0; $i < $bytes; ++$i) {
                    $val |= ord($randomByteString[$i]) << ($i * 8);
                }

                $val &= $mask;
                $val += $valueShift;
                ++$attempts;
            } while (!is_int($val) || $val > $max || $val < $min);
            return (int) $val;
        }
    }

    if ( ! function_exists('random_string'))
    {
        /**
         * Generates cryptographically secure strings
         *
         * @param int $length
         * @param string $alphabet
         * @return string
         */
        function random_string($length = 12, $alphabet = 'abcdefghijklmnopqrstuvwxyz234567')
        {
            if ($length < 1) {
                throw new InvalidArgumentException('Length must be a positive integer');
            }
            $str = '';
            $alphamax = strlen($alphabet) - 1;
            if ($alphamax < 1) {
                throw new InvalidArgumentException('Invalid alphabet');
            }
            for ($i = 0; $i < $length; ++$i) {
                $str .= $alphabet[random_int(0, $alphamax)];
            }
            return $str;
        }
    }
