<?php

namespace CF\TheForumBundle\Editor;

use mjohnson\decoda\filters\Filter;
use mjohnson\decoda\Decoda as BaseDecoda;

/**
 * Was chanched 2 methods:
 * addFilter() - was a problem with namespaces
 * _buildTag() - there added * in the regular expression
 */
class Decoda extends BaseDecoda
{
    /**
     * Add additional filters.
     *
     * @access public
     * @param \mjohnson\decoda\filters\Filter $filter
     * @return \mjohnson\decoda\Decoda
     * @chainable
     */
    public function addFilter(Filter $filter)
    {
        $filter->setParser($this);
        $class = str_replace(array('Filter', 'mjohnson\\decoda\\filters\\'), '', basename(get_class($filter)));
//		$class = str_replace('Filter', '', basename(get_class($filter)));
        $tags = $filter->tags();

        $this->_filters[$class] = $filter;
        $this->_tags            = $tags + $this->_tags;

        foreach ($tags as $tag => $options) {
            $this->_filterMap[$tag] = $class;
        }

        $filter->setupHooks($this);

        return $this;
    }

    /**
     * Determine if the string is an open or closing tag. If so, parse out the attributes.
     *
     * @access protected
     * @param string $string
     * @return array
     */
    protected function _buildTag($string)
    {
        $disabled = $this->config('disabled');
        $tag      = array(
            'tag'        => '',
            'text'       => $string,
            'attributes' => array()
        );

        // Closing tag
        if (substr($string, 1, 1) === '/') {
            $tag['tag']  = strtolower(substr($string, 2, strlen($string) - 3));
            $tag['type'] = self::TAG_CLOSE;

            if (!isset($this->_tags[$tag['tag']])) {
                return false;
            }
            // Opening tag
        } else {
            if (strpos($string, ' ') && (strpos($string, '=') === false)) {
                return false;
            }

            // Find tag
            $oe = preg_quote($this->config('open'));
            $ce = preg_quote($this->config('close'));
            if (preg_match('/' . $oe . '([*a-z0-9]+)(.*?)' . $ce . '/i', $string, $matches)) {
                $tag['type'] = self::TAG_OPEN;
                $tag['tag']  = strtolower($matches[1]);
            }

            if (!isset($this->_tags[$tag['tag']])) {
                return false;
            }

            // Find attributes
            if (!$disabled) {
                $found = array();

                preg_match_all('/([a-z]+)=\"(.*?)\"/i', $string, $matches, PREG_SET_ORDER);

                if ($matches) {
                    foreach ($matches as $match) {
                        $found[$match[1]] = $match[2];
                    }
                }

                // Find attributes that aren't surrounded by quotes
                if (!$this->config('strict')) {
                    preg_match_all('/([a-z]+)=([^\s\]]+)/i', $string, $matches, PREG_SET_ORDER);

                    if ($matches) {
                        foreach ($matches as $match) {
                            if (!isset($found[$match[1]])) {
                                $found[$match[1]] = $match[2];
                            }
                        }
                    }
                }

                if ($found) {
                    $source = $this->_tags[$tag['tag']];

                    foreach ($found as $key => $value) {
                        $key   = strtolower($key);
                        $value = trim(trim($value), '"');

                        if ($key === $tag['tag']) {
                            $key = 'default';
                        }

                        if (isset($source['mapAttributes'][$key])) {
                            $finalKey = $source['mapAttributes'][$key];
                        } else {
                            $finalKey = $key;
                        }

                        if (isset($source['attributes'][$key])) {
                            $pattern = $source['attributes'][$key];

                            if ($pattern === true) {
                                $tag['attributes'][$finalKey] = $value;
                            } else {
                                if (is_array($pattern)) {
                                    if (preg_match($pattern[0], $value)) {
                                        $tag['attributes'][$finalKey] = str_replace('{' . $key . '}', $value, $pattern[1]);
                                    }
                                } else {
                                    if (preg_match($pattern, $value)) {
                                        $tag['attributes'][$finalKey] = $value;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($disabled || ($this->_whitelist && !in_array($tag['tag'], $this->_whitelist))) {
            $tag['type'] = self::TAG_NONE;
            $tag['text'] = '';
        }

        return $tag;
    }
}
