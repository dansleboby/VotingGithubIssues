<?php

namespace App\Libraries;

use DateTime;

class Helpers {
    public static function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @param string $h HTTP headers as a string
     * @param string $url optional base URL to resolve relative URLs
     * @return array $rels rel values as indices to arrays of URLs, empty array if no rels at all
     */
    public static function http_rels($h, $url = '') {
        $h    = preg_replace("/(\r\n|\r)/", "\n", $h);
        $h    = explode("\n", preg_replace("/(\n)[ \t]+/", " ", $h));
        $rels = [];
        foreach($h as $f) {
            if(!strncasecmp($f, 'X-Pingback: ', 12)) {
                // convert to a link header and have common code handle it
                $f = 'Link: <' . trim(substr($f, 12)) . '>; rel="pingback"';
            }
            if(!strncasecmp($f, 'Link: ', 6)) {
                $links = explode(', ', trim(substr($f, 6)));
                foreach($links as $link) {
                    $hrefandrel = explode('; ', $link);
                    $href       = trim($hrefandrel[0], '<>');
                    $relarray   = '';
                    foreach($hrefandrel as $p) {
                        if(!strncmp($p, 'rel=', 4)) {
                            $relarray = explode(' ', trim(substr($p, 4), '"\''));
                            break;
                        }
                    }
                    if($relarray !== '') { // ignore Link: headers without rel
                        foreach($relarray as $rel) {
                            $rel = strtolower(trim($rel));
                            if($rel != '') {
                                if(!array_key_exists($rel, $rels)) {
                                    $rels[$rel] = [];
                                }
                                if($url) {
                                    $href = get_absolute_uri($href, $url);
                                }
                                if(!in_array($href, $rels[$rel])) {
                                    $rels[$rel][] = $href;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $rels;
    }

    public static function fetch($url, $headers = ['User-Agent: php']) {

        $responseHeaders = [];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($ch, $header) use (&$responseHeaders) {
            $len    = strlen($header);
            $header = explode(':', $header, 2);
            if(count($header) < 2) {
                return $len;
            }

            $name = strtolower(trim($header[0]));
            if(!array_key_exists($name, $responseHeaders)) {
                $responseHeaders[$name] = [trim($header[1])];
            } else {
                $responseHeaders[$name][] = trim($header[1]);
            }

            return $len;
        });

        $response_raw = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType  = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $header_size  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $response = substr($response_raw, $header_size);
        if(self::is_json($response)) {
            $response = json_decode($response);
        }

        $errno = curl_errno($ch);

        return [
            'response'        => $response,
            'responseCode'    => $responseCode,
            'error'           => $errno,
            'contentType'     => $contentType,
            'responseHeaders' => $responseHeaders,
            'links'           => self::http_rels(substr($response_raw, 0, $header_size))
        ];
    }

    public static function time_elapsed_string($datetime, $full = false) {
        $now  = new DateTime;
        $ago  = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach($string as $k => &$v) {
            if($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if(!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function btn_oAuth($provider) {
        $style = ['color' => '#fff', 'background' => '#4caf50'];
        switch($provider) {
            case 'github':
                $style['background'] = '#24292E';
                break;
            case 'google':
                $style['background'] = '#E33E2B';
                break;
            case 'twitter':
                $style['background'] = '#1DA1F2';
                break;
            case 'facebook':
                $style['background'] = '#4267B2';
                break;
        }

        return "<a href='" . url('/oauth/' . $provider) . "' class='btn' style='background: {$style['background']};color: {$style['color']}'>" . ucfirst($provider) . "</a>";
    }
}