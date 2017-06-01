# Karatsuba Multiplication
This is an exercise done as part of an algorithm course.

The intention is that I could use this exercise to write the algorithm
in other languages I want to learn, e.g. Haskell or whatever.

The lesson learned in the php implementation is the GMP library is needed to
handle numbers larger than float or integer can handle. That means we had to
work with the numbers as strings.

## PHP implementation
From the command line `php karmultiplication.php <number> <number>`
