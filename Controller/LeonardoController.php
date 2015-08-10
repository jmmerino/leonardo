<?php

namespace Leonardo\LeonardoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LeonardoController extends Controller
{
    /**
     * Colours
     * @Template("LeonardoBundle:Styleguide:colours.html.twig")
     */
    public function coloursAction()
    {
        return array(
            'colours' => $this->parseColours()
        );
    }

    /**
     * Icons
     * @Template("LeonardoBundle:Styleguide:icons.html.twig")
     */
    public function iconsAction()
    {
        return array(
            'icons' => $this->parseIcons()
        );
    }

    /**
     * Grid
     * @Template("LeonardoBundle:Styleguide:grid.html.twig")
     */
    public function gridAction()
    {
        return array();
    }

    /**
     * Users
     * @Template("LeonardoBundle:Styleguide:users.html.twig")
     */
    public function usersAction()
    {
        return array();
    }

    /**
     * Buttons
     * @Template("LeonardoBundle:Styleguide:buttons.html.twig")
     */
    public function buttonsAction()
    {
        return array();
    }

    /**
     * Tooltips
     * @Template("LeonardoBundle:Styleguide:tooltips.html.twig")
     */
    public function tooltipsAction()
    {
        return array();
    }

    /**
     * Forms
     * @Template("LeonardoBundle:Styleguide:forms.html.twig")
     */
    public function formsAction()
    {
        return array();
    }

    /**
     * TopBar
     * @Template("LeonardoBundle:Styleguide:top-bar.html.twig")
     */
    public function topBarAction()
    {
        return array();
    }

    /**
     * searchBox
     * @Template("LeonardoBundle:Styleguide:search-box.html.twig")
     */
    public function searchBoxAction()
    {
        return array();
    }

    /**
     * Footer
     * @Template()
     */
    public function footerAction()
    {
        return array();
    }

    /**
     * Menu
     * @Template()
     */
    public function menuAction()
    {
        return array();
    }

    /**
     * Noti Component
     * @Template()
     */
    public function notiAction()
    {
        return array();
    }

    /**
     * Product cards Component
     * @Template()
     */
    public function productAction()
    {
        return array();
    }



    private function parseColours(){
        $arr_colours = [];

        $kernel = $this->get('kernel');
        $path = $kernel->locateResource('@LeonardoBundle/Resources/assets/sass/core/_vars.scss');

        $colours_file    = file_get_contents($path);
        $rows        = explode("\n", $colours_file);
        array_shift($rows);

        foreach($rows as $row => $data)
        {

            if (substr( $data, 0, 1 ) === "$")
            {
                //Colour value
                $colour['name'] = explode(': ', $data)[0];
                $colour['value'] = explode(': ', $data)[1];

                $arr_colours[] = $colour;
            }
        }

        return $arr_colours;

    }

    private function parseIcons(){
        $arr_icons = [];

        $kernel = $this->get('kernel');
        $path = $kernel->locateResource('@LeonardoBundle/Resources/assets/sass/core/icons/icons-embedded.scss');

        $icons_file    = file_get_contents($path);
        $rows        = explode("\n", $icons_file);
        array_shift($rows);

        foreach($rows as $row => $data)
        {

            if (substr( $data, 0, 6 ) === ".icon-")
            {
                //Colour value
                $icon['name'] = str_replace(".icon-", "", explode(':', $data)[0]);
                $icon['class'] = str_replace(".", "", explode(':', $data)[0]);;

                $arr_icons[] = $icon;
            }
        }

        return $arr_icons;

    }

}
