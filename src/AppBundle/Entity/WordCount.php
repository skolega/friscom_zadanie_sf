<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WordCount
 *
 * @ORM\Table(name="word_count")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WordCountRepository")
 * 
 */
class WordCount
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="word", type="string", length=30)
     * @Assert\NotBlank(message="Musi zawierać slowo")
     */
    private $word;

    /**
     * @var int
     *
     * @ORM\Column(name="word_count", type="integer")
     * @Assert\NotBlank(message="Należy podać liczbę")
     */
    private $wordCount;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set word
     *
     * @param string $word
     *
     * @return WordCount
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set wordCount
     *
     * @param integer $wordCount
     *
     * @return WordCount
     */
    public function setWordCount($wordCount)
    {
        $this->wordCount = $wordCount;

        return $this;
    }

    /**
     * Get wordCount
     *
     * @return int
     */
    public function getWordCount()
    {
        return $this->wordCount;
    }
}

