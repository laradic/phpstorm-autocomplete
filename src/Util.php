<?php
namespace Laradic\Idea\Metadata;

class Util
{

    /**
     * Joins a split file system path.
     *
     * @param  array|string $path
     *
     * @return string
     */
    public static function join()
    {
        $arguments = func_get_args();

        if (func_num_args() === 1 and is_array($arguments[ 0 ])) {
            $arguments = $arguments[ 0 ];
        }

        foreach ($arguments as $key => &$argument) {
            if (is_array($argument)) {
                $argument = static::join($argument);
            }
            $argument = static::removeRight($argument, '/');

            if ($key > 0) {
                $argument = static::removeLeft($argument, '/');
            }

            #$arguments[ $key ] = $argument;
        }

        return implode(DIRECTORY_SEPARATOR, $arguments);
    }


    /**
     * Returns a new string with the prefix $substring removed, if present.
     *
     * @param  string  $substring The prefix to remove
     * @return Stringy Object having a $str without the prefix $substring
     */
    public static function removeLeft($str, $substring)
    {
        if (static::startsWith($str, $substring)) {
            $substringLength = mb_strlen($substring);
            return substr($str, $substringLength);
        }

        return $str;
    }

    /**
     * Returns a new string with the suffix $substring removed, if present.
     *
     * @param  string  $substring The suffix to remove
     * @return Stringy Object having a $str without the suffix $substring
     */
    public static function removeRight($str, $substring)
    {
        if (static::endsWith($str, $substring)) {
            return substr($str, 0, strlen($str) - strlen($substring));
        }

        return $str;
    }


    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     *
     * @author Taylor Otwell
     */
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }


    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     *
     * @author Taylor Otwell
     */
    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }

        return false;
    }

    public static function getClassNameFromFile($filePath)
    {
        $class = '';
        try {
            $fp = fopen($filePath, 'r');


            $class = $buffer = '';
            $i     = 0;
            while (!$class) {
                if (feof($fp)) {
                    break;
                }

                $buffer .= fread($fp, 512);
                $tokens = token_get_all($buffer);

                if (strpos($buffer, '{') === false) {
                    continue;
                }

                for (; $i < count($tokens); $i++) {
                    if ($tokens[ $i ][ 0 ] === T_CLASS) {
                        for ($j = $i + 1; $j < count($tokens); $j++) {
                            if ($tokens[ $j ] === '{') {
                                $class = $tokens[ $i + 2 ][ 1 ];
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $e) {

        }

        return $class;
    }


    /**
     * Canonicalizes the given path.
     *
     * During normalization, all slashes are replaced by forward slashes ("/").
     * Furthermore, all "." and ".." segments are removed as far as possible.
     * ".." segments at the beginning of relative paths are not removed.
     *
     * ```php
     * echo Path::canonicalize("\webmozart\puli\..\css\style.css");
     * // => /webmozart/style.css
     *
     * echo Path::canonicalize("../css/./style.css");
     * // => ../css/style.css
     * ```
     *
     * This method is able to deal with both UNIX and Windows paths.
     *
     * @param string $path A path string
     *
     * @return string The canonical path
     */
    public static function canonicalize($path)
    {
        $path = (string)$path;

        if ('' === $path) {
            return '';
        }

        $path = str_replace('\\', '/', $path);

        list ($root, $path) = self::split($path);

        $parts = array_filter(explode('/', $path), 'strlen');
        $canonicalParts = [ ];

        // Collapse "." and "..", if possible
        foreach ($parts as $part) {
            if ('.' === $part) {
                continue;
            }

            // Collapse ".." with the previous part, if one exists
            // Don't collapse ".." if the previous part is also ".."
            if ('..' === $part && count($canonicalParts) > 0
                && '..' !== $canonicalParts[ count($canonicalParts) - 1 ]
            ) {
                array_pop($canonicalParts);

                continue;
            }

            // Only add ".." prefixes for relative paths
            if ('..' !== $part || '' === $root) {
                $canonicalParts[] = $part;
            }
        }

        // Add the root directory again
        return $root . implode('/', $canonicalParts);
    }

    /**
     * Returns the directory part of the path.
     *
     * This method is similar to PHP's dirname(), but handles various cases
     * where dirname() returns a weird result:
     *
     *  - dirname() does not accept backslashes on UNIX
     *  - dirname("C:/webmozart") returns "C:", not "C:/"
     *  - dirname("C:/") returns ".", not "C:/"
     *  - dirname("C:") returns ".", not "C:/"
     *  - dirname("webmozart") returns ".", not ""
     *  - dirname() does not canonicalize the result
     *
     * This method fixes these shortcomings and behaves like dirname()
     * otherwise.
     *
     * The result is a canonical path.
     *
     * @param string $path A path string
     *
     * @return string The canonical directory part. Returns the root directory
     *                if the root directory is passed. Returns an empty string
     *                if a relative path is passed that contains no slashes.
     *                Returns an empty string if an empty string is passed
     */
    public static function getDirectory($path)
    {
        if ('' === $path) {
            return '';
        }

        $path = static::canonicalize($path);

        if (false !== ($pos = strrpos($path, '/'))) {
            // Directory equals root directory "/"
            if (0 === $pos) {
                return '/';
            }

            // Directory equals Windows root "C:/"
            if (2 === $pos && ctype_alpha($path[ 0 ]) && ':' === $path[ 1 ]) {
                return substr($path, 0, 3);
            }

            return substr($path, 0, $pos);
        }

        return '';
    }


    /**
     * Splits a part into its root directory and the remainder.
     *
     * If the path has no root directory, an empty root directory will be
     * returned.
     *
     * If the root directory is a Windows style partition, the resulting root
     * will always contain a trailing slash.
     *
     * list ($root, $path) = Path::split("C:/webmozart")
     * // => array("C:/", "webmozart")
     *
     * list ($root, $path) = Path::split("C:")
     * // => array("C:/", "")
     *
     * @param string $path The canonical path to split
     *
     * @return array An array with the root directory and the remaining relative
     *               path
     */
    private static function split($path)
    {
        if ('' === $path) {
            return [ '', '' ];
        }

        $root = '';
        $length = strlen($path);

        // Remove and remember root directory
        if ('/' === $path[ 0 ]) {
            $root = '/';
            $path = $length > 1 ? substr($path, 1) : '';
        } elseif ($length > 1 && ctype_alpha($path[ 0 ]) && ':' === $path[ 1 ]) {
            if (2 === $length) {
                // Windows special case: "C:"
                $root = $path . '/';
                $path = '';
            } elseif ('/' === $path[ 2 ]) {
                // Windows normal case: "C:/"..
                $root = substr($path, 0, 3);
                $path = $length > 3 ? substr($path, 3) : '';
            }
        }

        return [ $root, $path ];
    }

}
