<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\Fields\Tab;

/**
 * Class Layouts
 *
 * @package Rosecrance\App\Fields\Layouts
 */
abstract class Layouts
{
    /**
     * Defines fields for layout.
     *
     * @return object
     */
    abstract public function fields();

    /**
     * Creates Content Tab Field.
     *
     * @return object
     */
    public function contentTab()
    {
        return Tab::make(__('Content', 'rosecrance'), 'content-tab')
            ->placement('left');
    }

    /**
     * Creates Options Tab Field.
     *
     * @return object
     */
    public function optionsTab()
    {
        return Tab::make(__('Options', 'rosecrance'), 'options-tab')
            ->placement('left');
    }

    /**
     * Creates Styles Tab Field.
     *
     * @return object
     */
    public function styleTab()
    {
        return Tab::make(__('Style', 'rosecrance'), 'style-tab')
            ->placement('left');
    }

    /**
     * Creates Relationships Tab Field.
     *
     * @return object
     */
    public function relationshipsTab()
    {
        return Tab::make(__('Relationships', 'rosecrance'), 'relationships-tab')
            ->placement('left');
    }

    public function locationFinderTab()
    {
        return Tab::make(__('Location Finder Rules', 'rosecrance'), 'location-finder-tab')
            ->placement('left');
    }

    /**
     * Creates Anchor Tab Field.
     *
     * @return object
     */
    public function anchorTab()
    {
        return Tab::make(__('Anchor', 'rosecrance'), 'anchor-tab')
            ->placement('left');
    }
}
