<?php
declare(strict_types=1);

namespace PBergman\Ntfy\Util;

class TextUtil
{
    /** @api https://github.com/binwiederhier/ntfy/blob/19c30fc41157b6793e1199b5c97ff32962825f27/server/actions.go#L248 * */
    public static function quote(string $string): string
    {
        $ret = preg_replace('/([\',;])/', '\\\$1', $string, -1, $count);

        if ($count > 0 || '"' === $string[0]) {
            return '\'' . $ret . '\'';
        }

        return $string;
    }

    /** @api https://github.com/binwiederhier/ntfy/blob/19c30fc41157b6793e1199b5c97ff32962825f27/server/actions.go#L28C40-L28C57 */
    public static function validActionKey(string $name): string
    {
        if (false === preg_match('/^([-.\w]+)/', $name) ){
            throw new \RuntimeException('Invalid characters in action key "' . $name . '"');
        }

        return $name;
    }
}
