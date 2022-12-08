<?php

namespace App\Service;

// The code was mapped from  https://github.com/vrana/adminer/blob/master/adminer/sql.inc.php
class SplitSql
{



    public function __invoke(string $driver, string $query): array
    {

        $array_queries = [];
        $space = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
        $delimiter = ";";
        $offset = 0;
        $fp = false;
        $parse = '[\'"' . ($driver == "sql" ? '`#' : ($driver == "sqlite" ? '`[' : ($driver == "sqlsrv" ? '[' : ''))) . ']|/\*|-- |$' . ($driver == "pgsql" ? '|\$[^$]*\$' : '');

        while ($query != "") {
            if (!$offset && preg_match("~^$space*+DELIMITER\\s+(\\S+)~i", $query, $match)) {
                $delimiter = $match[1];
                $query = substr($query, strlen($match[0]));
            } else {
                preg_match('(' . preg_quote($delimiter) . "\\s*|$parse)", $query, $match, PREG_OFFSET_CAPTURE, $offset); // should always match
                list($found, $pos) = $match[0];
                if (!$found && $fp && !feof($fp)) {
                    $query .= fread($fp, 1e5);
                } else {
                    if (!$found && rtrim($query) == "") {
                        break;
                    }
                    $offset = $pos + strlen($found);
                    if ($found && rtrim($found) != $delimiter) { // find matching quote or comment end
                        while (preg_match('(' . ($found == '/*' ? '\*/' : ($found == '[' ? ']' : (preg_match('~^-- |^#~', $found) ? "\n" : preg_quote($found) . "|\\\\."))) . '|$)s', $query, $match, PREG_OFFSET_CAPTURE, $offset)) { //! respect sql_mode NO_BACKSLASH_ESCAPES
                            $s = $match[0][0];
                            if (!$s && $fp && !feof($fp)) {
                                $query .= fread($fp, 1e5);
                            } else {
                                $offset = $match[0][1] + strlen($s);
                                if ($s[0] != "\\") {
                                    break;
                                }
                            }
                        }

                    } else { // end of a query
                        $array_queries[] = substr($query, 0, $pos);
                        $query = substr($query, $offset);
                        $offset = 0;
                    }
                }
            }
        }
        return  $array_queries;
    }
}
