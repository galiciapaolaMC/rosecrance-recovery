<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Email;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Text;

/**
 * Class Footer
 *
 * @package Rosecrfance\App\Fields\Options
 */
class Footer
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/footer',
            [
                Tab::make(__('Footer', 'rosecrance'))
                    ->placement('left'),
                Image::make(__('Footer Logo', 'rosecrance'), 'footer-logo')
                    ->returnFormat('array')
                    ->previewSize('thumbnail'),
                Group::make(__('Contact Column', 'rosecrance'), 'contact-column')
                  ->layout('block')
                  ->fields([
                    Text::make(__('Addiction Phone Number', 'rosecrance'), 'addiction-phone-number')
                      ->instructions(__('Preferred format: (xxx) xxx-xxxx')),
                    Text::make(__('Mental Health Phone Number', 'rosecrance'), 'mental-health-phone-number')
                      ->instructions(__('Preferred format: (xxx) xxx-xxxx')),
                    Link::make(__('Contact Page Link', 'rosecrance'), 'contact-page-link'),
                    Repeater::make(__('Addresses', 'rosecrance'), 'addresses')
                      ->layout('block')
                      ->min(1)
                      ->max(3)
                      ->buttonLabel(__('Add Address', 'rosecrance'), 'add-address')
                      ->fields([
                        TextArea::make(__('Address', 'rosecrance'), 'address')
                          ->rows(2)
                          ->wrapper([
                            'width' => '50'
                          ]),
                        Link::make(__('Directions Link', 'rosecrance'), 'directions-link')
                          ->wrapper([
                            'width' => '50'
                          ])
                      ]),
                    Text::make(__('Media Contact Name', 'rosecrance'), 'media-contact-name'),
                    Text::make(__('Media Contact Title', 'rosecrance'), 'media-contact-title'),
                    Email::make(__('Media Contact Email', 'rosecrance'), 'media-contact-email')
                  ]),
                Group::make(__('Menu Links Column', 'rosecrance'), 'links-column')
                  ->layout('block')
                  ->fields([
                    Repeater::make(__('links', 'rosecrance'), 'links')
                      ->layout('block')
                      ->min(1)
                      ->max(7)
                      ->buttonLabel(__('Add Link', 'rosecrance'), 'add-link')
                      ->fields([
                        Link::make(__('Link', 'rosecrance'), 'link')
                      ]),
                    ]),
                Group::make(__('Newsletter Column', 'rosecrance'), 'newsletter-column')    
                  ->layout('block')
                  ->fields([
                    Link::make(__('Privacy Policy', 'rosecrance'), 'privacy-policy'),
                  ]),
                Group::make(__('Badges', 'rosecrance'), 'badges')
                  ->layout('block')
                  ->fields([
                    Image::make(__('Rosecrance Network Badge', 'rosecrance'), 'rosecrance-network-badge')
                      ->returnFormat('array')
                      ->previewSize('thumbnail'),
                    Link::make(__('Rosecrance Network Link', 'rosecrance'), 'rosecrance-network-link'),
                    Image::make(__('Trusted Partner Badge', 'rosecrance'), 'trusted-partner-badge')
                      ->returnFormat('array')
                      ->previewSize('thumbnail'),
                    Link::make(__('Trusted Partner Link', 'rosecrance'), 'trusted-partner-link'),
                    Image::make(__('Elite Care Badge', 'rosecrance'), 'elite-care-badge')
                      ->returnFormat('array')
                      ->previewSize('thumbnail'),
                    Link::make(__('Elite Care Link', 'rosecrance'), 'elite-care-link'),
                  ]),
                Group::make(__('Sub Footer', 'rosecrance'), 'sub-footer')
                  ->layout('block')
                  ->fields([
                    Text::make(__('Copyright', 'rosecrance'), 'copyright'),
                    Repeater::make(__('Menu Links', 'rosecrance'), 'subfooter-links')
                      ->layout('block')
                      ->min(1)
                      ->max(4)
                      ->buttonLabel(__('Add Link', 'rosecrance'), 'add-link')
                      ->fields([
                        Link::make(__('Link', 'rosecrance'), 'link')
                      ]),
                    ]),
                Group::make(__('Social Media', 'rosecrance'), 'social-media')
                  ->layout('block')
                  ->fields([
                    Link::make(__('Facebook Link', 'rosecrance'), 'facebook-link')
                        ->wrapper([
                            'width' => '20'
                        ]),
                    Link::make(__('Instagram Link', 'rosecrance'), 'instagram-link')
                        ->wrapper([
                            'width' => '20'
                        ]),
                    Link::make(__('X Link', 'rosecrance'), 'x-link')
                        ->wrapper([
                            'width' => '20'
                        ]),
                    Link::make(__('YouTube Link', 'rosecrance'), 'youtube-link')
                        ->wrapper([
                            'width' => '20'
                        ]),
                    Link::make(__('Linkedin Link', 'rosecrance'), 'linkedin-link')
                        ->wrapper([
                            'width' => '20'
                        ])
                  ])
            ]
        );
    }
}
