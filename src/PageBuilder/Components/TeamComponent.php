<?php

namespace Cubetech\PageBuilder\Components;

use Cubetech\Cards\TeamCard;
use \Cubetech\Rendering\IStringRenderable;

/**
 * Team component class for pagebuilder
 *
 * @author Steeve Jeannin <steeve@cubetech.ch>
 * @version 1.0.0
 * @since 1.0.0
 */
class TeamComponent extends BaseComponent implements IStringRenderable
{
    
    /**
     * Title of this component
     * Generated by acf singleline field
     *
     * @var string
     */
    protected $title;
    
    /**
     * Constructor method for this component
     * Initializes title, file and description properties
     *
     * @param int $postId
     * @param int $index
     *
     * @author Steeve Jeannin <steeve@cubetech.ch>
     * @since 1.0.0
     */
    public function __construct($postId, $index, $containerClass)
    {
        parent::__construct('Team', $postId, $index, $containerClass);
        $this->title = $this->getComponentField('title');
        $this->posts = $this->getComponentRepeaterField("teams_repeater", ['post_type' => "teams"]);
        $this->createCards();
    }
    
    private function createCards()
    {
        $cards = [];
        foreach ($this->posts as $post) {
            $cards[] = new TeamCard($post->teams);
        }
        $this->cards = $cards;
    }
    
    
    /**
     * Renders all readable contents of this component as a string
     *
     * @return string
     *
     * @author Alex Scherer <alex.scherer@cubetech.ch>
     * @since 1.0.0
     */
    public function renderToString()
    {
        $returnString = $this->title . ' ';
        foreach ($this->cards as $card) {
            $returnString .= $card->title . ' ';
            $returnString .= $card->function . ' ';
        }
        return $returnString;
    }
    
    /**
     * Validates the component for this particular component
     * Both the title property and at least one team are needed
     * and therefore both must have been set
     *
     * @return boolean
     *
     * @author Steeve Jeannin <steeve@cubetech.ch>
     * @since 1.0.0
     */
    public function isValid()
    {
        if ($this->title && !empty($this->cards) && $this->cards[0]->post->getId()) {
            return true;
        }
        return false;
    }
}