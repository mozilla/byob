<?php
/**
 * BYOB editor module registry
 *
 * @package    Mozilla_BYOB_Editor_LocaleSelection
 * @subpackage Libraries
 * @author     l.m.orchard <lorchard@mozilla.com>
 */
class Mozilla_BYOB_Editor_LocaleSelection extends Mozilla_BYOB_Editor {

    /** {{{ Object properties */
    public $id        = 'locale_selection';
    public $title     = 'Locales';
    public $view_name = 'repacks/edit/locale_selection';
    /** }}} */

    /**
     * Determine whether the current user has permission to access this 
     * editor.
     */
    public function isAllowed($repack)
    {
        return $repack->checkPrivilege('locale_selection');
    }

    /**
     * Validate data from incoming editor request.
     */
    public function validate(&$data, $repack)
    {
        $data = Validation::factory($data)
            ->pre_filter('trim');

        $data->add_rules('locales', 'required', 'is_array');
        $data->add_callbacks('locales', array($this, 'extractLocales'));

        return true;
    }

    /**
     * Extract selected locales from form data, accepting only locales that 
     * match valid product locales.
     */
    public function extractLocales($valid, $field)
    {
        if (empty($this->locales) && empty($valid[$field])) {
            // Detect locale from request if neither repack nor form offers locales.
            $m = array();
            preg_match_all(
                '/[-a-z]{2,}/', 
                strtolower(trim(@$_SERVER['HTTP_ACCEPT_LANGUAGE'])), 
                $m
            );
            $valid[$field] = $m[0];
        }

        if (empty($valid[$field])) {

            // Populate form from repack product locales.
            $valid[$field] = $this->locales;
            $valid->add_error($field, 'need_locale');

        } else {

            // Ensure that only locales appearing in the product locales are 
            // accepted from form data into the repack.
            $valid_locales = array();
            $choices = array_map('strtolower', $valid[$field]); 
            foreach (self::$locale_choices as $code=>$name) {
                if (in_array(strtolower($code), $choices)) {
                    $valid_locales[] = $code;
                }
            }

            $valid[$field] = $valid_locales;

        }

        return $valid[$field];
    }


    /**
     * TODO: Get rid of this when PHP 5.3+ can be a requirement
     */
    public static function getInstance() { return parent::getInstance(get_class()); }
        /**
         * TODO: Get rid of this when PHP 5.3+ can be a requirement
         */
        public static function register() { return parent::register(get_class()); }

}

