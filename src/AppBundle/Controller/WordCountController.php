<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\WordCount;

/**
 * WordCount controller.
 *
 * @Route("/wordcount")
 */
class WordCountController extends Controller
{

    public function getTextFromUrl($url)
    {
        $text = file_get_contents($url);

        return $text;
    }

    public function countSpecificWords($text)
    {
        $t = [' ', "';\\n \\' \\''\" '; exit 0; ')", 'ąąąą', ' " ', "\'", '=', '+', '-', '*', '/', '\\', ',', '.', ';', ':', '[', ']', '{', '}', '(', ')', '<', '>', '&', '%', '$', '@', '#', '^', '!', '?', '~'];
        $text = str_replace($t, " ", $text);
        $words = array_count_values(str_word_count($text, 1));

        return $words;
    }

    public function writeWordsInDatabase($words)
    {
        $em = $this->getDoctrine()->getManager();
        
        $wordCounts = $em->getRepository('AppBundle:WordCount')->findAll();

        if ($wordCounts) {

            $query = $em->createQuery('DELETE FROM AppBundle:WordCount');
            $query->execute();
        }
        

        foreach ($words as $word => $count) {
            $wordCounted = new WordCount();
            $wordCounted->setWord($word);
            $wordCounted->setWordCount($count);
            $em->persist($wordCounted);
        }
        $em->flush();

    }

    /**
     * Lists all WordCount entities.
     *
     * @Route("/", name="wordcount_index")
     * @Method("GET")
     */
    public function indexAction($url = "http://www.wkrakowie.pl/tekstownik.txt")
    {


        $em = $this->getDoctrine()->getManager();
        $wordCounts = $em->getRepository('AppBundle:WordCount')->findBy([], ['wordCount' => 'DESC']);

        $text = $this->getTextFromUrl($url);
        $words = $this->countSpecificWords($text);

        $this->writeWordsInDatabase($words);

        return $this->render('wordcount/index.html.twig', array(
                    'wordCounts' => $wordCounts,
        ));
    }

    /**
     * Finds and displays a WordCount entity.
     *
     * @Route("/{id}", name="wordcount_show")
     * @Method("GET")
     */
    public function showAction(WordCount $wordCount)
    {
        $deleteForm = $this->createDeleteForm($wordCount);

        return $this->render('wordcount/show.html.twig', array(
                    'wordCount' => $wordCount,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

}
