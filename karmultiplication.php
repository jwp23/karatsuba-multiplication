<?php

/**
 * This is an implementation of Karatsuba Multiplication in PHP
 *
 * The algorithm used is taken from the lecture at
 * https://www.coursera.org/learn/algorithms-divide-conquer/lecture/wKEYL/karatsuba-multiplication
 *
 * Assumptions:
 * Numbers are positive
 * Numbers will have equal set of digits
 * The number of digits in the numbers is a power of 2.
 *
 * We'll put a guard operator to display an error. Since this is an exercise,
 * I probably won't generalize it.
 */

$argumentNumber = count($argv) - 1;
if ($argumentNumber !== 2) {
    echo "Only two arguments allowed. You provided {$argumentNumber}\n";
    exit(1);
}
/** given the large numbers involved, we'll need to use BC Math and treat these
 * as strings
 */
$x = $argv[1];
$y = $argv[2];

if ($x < 0 || $y < 0) {
    echo "At least one of tne of the numbers provided is negative\n";
    exit(1);
}

/**
 * Returns the number of digits in the provided integer.
 *
 * @param string $integer
 *
 * @return int The number of digits of $integer
 */
function digits( $integer) : int
{
    $digits = preg_match_all("/[0-9]/", $integer);
    echo "The digits are {$digits}\n";
    return $digits;
}

if (digits($x) !== digits($y)) {
    echo "The number of digits for both numbers need to be the same.\n";
    echo "The first argument has " . digits($x) . " digits.\n";
    echo "The second argument has " . digits($y) . " digits.\n";
    exit(1);
}

if (digits($x) % 2 !== 0) {
    echo "The number of digits must be a multiple of 2. You provided " .
         digits($x) . " digits\n";
    exit(1);
}

/**
 * An implementation of Karatsuba Multiplication
 *
 * @param string $x Multiplicand
 * @param string $y Multiplier
 *
 * @return string Product
 */
function karatsubaMultiplication( $x, $y) : string
{
    $digits = digits($x);

    /** Base case if the number of digits is one */
    if ($digits == 1) {
        return $x * $y;
    }

    $halfDigits = $digits / 2;

    $tenRaisedHalfDigits = gmp_pow(10, $halfDigits);
    $a = gmp_div_q($x, $tenRaisedHalfDigits);
    $b = gmp_sub($x, gmp_mul($a,$tenRaisedHalfDigits));

    $c = gmp_div_q($y,$tenRaisedHalfDigits);
    $d = gmp_sub($y, gmp_mul($c,$tenRaisedHalfDigits));

    $aTimeC = karatsubaMultiplication($a, $c);
    $bTimeD = karatsubaMultiplication($b, $d);
    $middleProduct = karatsubaMultiplication(gmp_add($a,$b), gmp_add($c,$d));
    $adTimeBc = gmp_sub(gmp_sub($middleProduct,$aTimeC), $bTimeD);

    return gmp_add(gmp_add(gmp_mul(gmp_pow(10, $digits),$aTimeC),gmp_mul($tenRaisedHalfDigits, $adTimeBc)),$bTimeD);
}

echo karatsubaMultiplication($x, $y) . "\n";
