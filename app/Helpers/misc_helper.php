<?php

if (!function_exists('uniformiza_espacos')) {
    function uniformiza_espacos($name) {
        $name = preg_replace('/\s+/', ' ', trim($name));
        return $name;
    }

}

if (!function_exists('uniformiza_string')) {
    function uniformiza_string($name) {
        $name = mb_strtoupper(remove_acentos(uniformiza_espacos($name)));
        return $name;
    }

}

if (!function_exists('remove_acentos')) {
    function remove_acentos($str) {
        $str = preg_replace('/[áàãâä]/u', 'a', $str);
        $str = preg_replace('/[ÁÀÃÂÄ]/u', 'A', $str);
        $str = preg_replace('/[éèẽêë]/u', 'e', $str);
        $str = preg_replace('/[ÉÈẼÊË]/u', 'E', $str);
        $str = preg_replace('/[íìĩîï]/u', 'i', $str);
        $str = preg_replace('/[ÍÌĨÎÏ]/u', 'I', $str);
        $str = preg_replace('/[óòõôö]/u', 'o', $str);
        $str = preg_replace('/[ÓÒÕÔÖ]/u', 'O', $str);
        $str = preg_replace('/[úùũûü]/u', 'u', $str);
        $str = preg_replace('/[ÚÙŨÛÜ]/u', 'U', $str);
        $str = preg_replace('/[ç]/u', 'c', $str);
        $str = preg_replace('/[Ç]/u', 'c', $str);
        return $str;
    }
}

if(!function_exists('uniformiza_data')) {
    function uniformiza_data($data)
    {
        return !empty($data) ? date_format(date_create($data), "d/m/Y") : '';
    }
}

if(!function_exists('normaliza_permissoes')) {
    function normaliza_permissoes($data)
    {
        switch($data) {
            case '0':
                return 'LEITOR';
            case '1':
                return 'ADMIN';
            default:
                return 'LEITOR';
        }
    }
}

if(!function_exists('normaliza_status')) {
    function normaliza_status($data)
    {
        switch($data) {
            case '0':
                return '0';
            case '1':
                return '1';
            default:
                return '0';
        }
    }
}
