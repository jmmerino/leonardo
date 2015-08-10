<?php

namespace Leonardo\LeonardoBundle\Twig;

class ComponentsExtension extends \Twig_Extension
{

    public function __construct(){}

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'parse_component_properties'    => new \Twig_Function_Method($this, 'parseComponentProperties')
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('html_attribute', array($this, 'htmlAttribute')),
        );
    }

    public function htmlAttribute($var, $attribute) {
        if ($var) {
            return $attribute . "='" . $var . "'";
        }
    }

    /**
     * Parse properties for component
     *
     * @param array  $component Name of the component
     * @param string $properties Properties to be parsed
     *
     * @return array
     */
    public function parseComponentProperties($component, $properties)
    {

        $parseMethod = 'parse' . str_replace(" ", "", ucwords(str_replace("-", " ", $component)));

        if (method_exists($this, $parseMethod)){
            if (!empty($properties)){
                return $this->$parseMethod($properties);
            } else {
                return array();
            }
        } else {
            return $properties;
        }

    }

    /**
     * Process button properties
     * @param  array $properties array with all the properties for the component
     * @return array             array with the parsed properties
     */
    private function parseButton($properties){

        //Defaults properties for buttons
        $defaults = array(
            "id"        => null,
            "url"       => null,
            "value"     => null,
            "alt"       => null,
            "data"      => null,
            "type"      => null,
            "icon"      => null,
            "is_hidden" => false,
            "blank"     => false,
            "image"     => null,
            "retina"    => false,
            "pre_text"  => null
        );
        // Apply defaults
        $properties = array_merge($defaults, $properties);

        //Set custom classes of buttons
        $classes = array("btn");
        $classes[] = $this->processProperty($properties, "size", "btn-medium");
        $classes[] = $this->processProperty($properties, "color", "btn-coral-red");
        $classes[] = (isset($properties["icon"]) ? "btn-icon" : null);
        $classes = array_merge($classes, $this->processProperty($properties, "extra_class", array()));

        // Set data attribute of buttons
        $data = [];
        if (isset($properties["data"])){
            foreach($properties["data"] as $key => $value) {
                if ($value){
                    $data[] = "data-" . $key . "=\"" . $value . "\"";
                } else {
                    $data[] = "data-" . $key;
                }
           }
           unset($properties["data"]);
        }

        //Merge classes and data with other properties
        $processed = array(
            'classes' => implode( array_filter($classes), " "),
            'data' => implode($data, " ")
        );

        return array_merge($properties, $processed);
    }


    /**
     * Process a property and return it´s value or the default value
     * Also unset the property in the array
     *
     * @param  array $properties array of properites
     * @param  string $key        key of the property to process
     * @param  whatever $default    default value for the property
     * @return whatever             the value of the property or default
     */
    private function processProperty($properties, $key, $default = null){

        $retVal = $default;

        if (isset($properties[$key])){
            $retVal =  $properties[$key];
            unset($properties[$key]);
        }

        return $retVal;

    }

    public function getName()
    {
        return 'components_extension';
    }

}
